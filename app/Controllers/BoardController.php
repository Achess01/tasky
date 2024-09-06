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
            $can_create = $this->projectService->hasPermissionsByProject($project_id, $_SESSION['user_id'], 'create', 'task');
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

    public function createTask(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $project_id = intval($_GET['id']);
        $task_id = isset($_GET['task_id']) ? intval($_GET['task_id']) : null;
        $is_edit = $task_id !== null;
        $project = $this->projectService->getProjectById($project_id, $_SESSION['user_id']);
        $task = $this->projectService->getTasksById($task_id ?? 0);
        if ($project === null || ($task === null && $is_edit)) {
            require_once './app/Views/404NotFound.php';
            exit;
        }

        $has_permissions = $this->projectService->hasPermissionsByProject($project_id, $_SESSION['user_id'], 'create', 'task');
        $has_edit_permissions = $this->projectService->hasPermissionsByProject($project_id, $_SESSION['user_id'], 'update', 'task');
        if (!$has_permissions || !$has_edit_permissions) {
            $error = 'No tienes permisos para realizar esta acción';
            require_once './app/Views/create_task.php';
            exit;
        }


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {


            $status = $this->projectService->getStatus();
            $users = $this->projectService->getUsersByProject($project_id);
            $tasks = $this->projectService->getTasksByProject($project_id, $_SESSION['user_id']);

            require_once './app/Views/create_task.php';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['assigned_user_id'] == '') {
                $_POST['assigned_user_id'] = null;
            }

            if ($_POST['parent_id'] == '') {
                $_POST['parent_id'] = null;
            }
            $is_edit ? $this->projectService->updateTask($_POST) : $this->projectService->createTask($_POST);
            header('Location: /projects?id=' . $project_id);
        }
    }

    public function addUserToProject() : void {
        $projectId = $this->validateProject();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $roleId = $_POST['role_id']; // Assuming roles are also managed

            $success = $this->projectService->projectModel->addUserToProject($projectId, $userId, $roleId);

            if ($success) {
                header('Location: /projects?id=' . $projectId); // Redirect to project page
                exit;
            } else {
                echo "Error adding user to project";
            }
        }

        // Get users not already in the project
        $users = $this->projectService->projectModel->notInProjectUsers($projectId);
        $roles = $this->projectService->projectModel->findRoles();
        require './app/Views/add_use_to_project_view.php';
    }

    public function editUserRoles() : void {
        $projectId = $this->validateProject();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Update the role for a specific user
            $userId = $_POST['user_id'];
            $roleId = $_POST['role_id'];

            $success = $this->projectService->projectModel->updateUserRoleInProject($projectId, $userId, $roleId);

            if ($success) {
                header('Location: /projects?id=' . $projectId);
                exit;
            } else {
                echo "Error updating user role.";
            }
        }

        // Get all users in the project with their roles
        $usersInProject = $this->projectService->getUsersByProject($projectId);
        $roles = $this->projectService->projectModel->findRoles();
        require './app/Views/edi_user_roles_view.php';
    }

    /**
     * @return int|void
     */
    public function validateProject()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $projectId = isset($_GET['id']) ? intval($_GET['id']) : null;
        $project = $this->projectService->getProjectById($projectId ?? 0, $_SESSION['user_id']);
        if ($projectId == null) {
            require_once './app/Views/404NotFound.php';
            exit;
        }

        $has_edit_permissions = $this->projectService->hasPermissionsByProject($projectId, $_SESSION['user_id'], 'update', 'project');
        if (!$has_edit_permissions) {
            require_once './app/Views/404NotFound.php';
            exit;
        }
        return $projectId;
    }
}