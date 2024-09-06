<?php

use Tasky\Controllers\DashboardController;
use Tasky\Controllers\ReportController;
use Tasky\Controllers\UserController;
use Tasky\Controllers\BoardController;
use Tasky\Models\Project;
use Tasky\Models\User;
use \Tasky\Models\ReportModel;
use Tasky\Services\AuthService;
use Tasky\Services\ProjectService;
use Tasky\Services\Database;

require("vendor/autoload.php");
$config = require_once('config/config.php');

// Dependency injection
$db = new Database($config['db']);
$userModel = new User($db);
$authService = new AuthService($userModel);
$userController = new UserController($authService);
$projectModel = new Project($db);
$projectService = new ProjectService($projectModel);
$dashboardController = new DashboardController($projectService);
$boardController = new BoardController($projectService);
$reportModel = new ReportModel($db);
$reportController = new ReportController($reportModel);

// Routing
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/login':
        $userController->login();
        break;
    case '/logout':
        $userController->logout();
        break;
    case '/dashboard':
        $dashboardController->getProjects();
        break;
    case '/projects':
        $boardController->getBoard();
        break;
    case '/task/update-status':
        $boardController->updateTaskStatus();
        break;
    case '/projects/create':
        $dashboardController->createProject();
        break;
    case '/projects/task':
        $boardController->createTask();
        break;
    case '/projects/addUser':
        $boardController->addUserToProject();
        break;
    case '/projects/editUserRoles':
        $boardController->editUserRoles();
        break;
    case '/report/tasksByUserAndProject':
        $reportController->reportTasksByUserAndProject();
        break;
    case '/report/taskCountByStatus':
        $reportController->reportTaskCountByStatus();
        break;
    case '/report/totalTimeByProject':
        $reportController->reportTotalTimeByProject();
        break;
    case '/report/taskStatusHistory':
        $reportController->reportTaskStatusHistory();
        break;
    default:
        require_once './app/Views/404NotFound.php';
        break;
}