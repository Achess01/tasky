<?php

namespace Tasky\Controllers;

use Tasky\Services\ProjectService;

class BoardController
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function getBoard(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $project_id = intval($_GET['id']);

            $project = $this->projectService->getProjectById($project_id, $_SESSION['user_id']);
            if ($project === null) {
                require_once './app/Views/404NotFound.php';
                exit;
            }

            $status = $this->projectService->getStatus();
            $tasks = $this->projectService->getTasksByProject($project_id, $_SESSION['user_id']);
            $separated_tasks = [];
            foreach ($status as $st) {
                $separated_tasks[$st['project_task_status']] = array_filter($tasks, function ($task) use ($st) {
                    return $task['project_task_status'] === $st['project_task_status'];
                });

            }

            require_once './app/Views/board.php';
            exit;
        }
    }

    public function updateTaskStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the JSON input from the request body
            $data = json_decode(file_get_contents("php://input"), true);

            // Extract entity ID and new data
            $projectId = $data['project_id'];
            $task_id = $data['task_id'];
            $new_status_id = $data['status_id'];
            $has_permissions = $this->projectService->hasPermissionsByProject($projectId, $_SESSION['user_id'], 'update', 'task');
            if (!$has_permissions) {
                http_response_code(403);
                echo json_encode(['error' => 'No puede realizar esta operación']);
                exit;
            }
            $this->projectService->updateTaskStatus($task_id, $new_status_id);
            // Call the model to update the entity

            // Send a JSON response back to the JavaScript side
            header('Content-Type: application/json');
            echo json_encode(['success' => 'ok']);
        }

    }
}