<?php

use Tasky\Controllers\DashboardController;
use Tasky\Controllers\UserController;
use Tasky\Models\Project;
use Tasky\Models\User;
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
    default:
        echo "404 Not Found";
        break;
}