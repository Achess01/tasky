<?php

namespace Tasky\Controllers;

use Tasky\Services\AuthService;

class UserController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->authService->login($email, $password)) {
                header('Location: /dashboard');
                exit;
            } else {
                $error = "Invalid email or password";
                require_once './app/Views/login.php';
            }
        } else {
            require_once './app/Views/login.php';
        }
    }

    public function logout()
    {
        $this->authService->logout();
        header('Location: /login');
        exit;
    }
}

