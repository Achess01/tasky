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
}