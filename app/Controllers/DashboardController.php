<?php

namespace Tasky\Controllers;

use Tasky\Services\ProjectService;

class DashboardController
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function getProjects(): void {
        if(!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $projects = $this->projectService->getProjects($_SESSION['user_id']);
        require_once './app/Views/dashboard.php';
    }

    public function createProject(): void {
        if(!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once './app/Views/create-project.php';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->projectService->createProject($_POST, $_SESSION['user_id']);
            header('Location: /dashboard');
        }
    }
}