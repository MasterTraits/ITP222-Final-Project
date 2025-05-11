<?php

namespace App\controllers;

use App\models\UserModel;
use App\controllers\Auth;

class AuthController
{
    protected $userModel;

    public function __construct($db)
    {
        $this->userModel = new UserModel($db);
    }

    // Show login form
    public function loginForm()
    {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function registerForm()
    {
        include __DIR__ . '/../views/auth/register.php';
    }

    public function forgotPasswordForm()
    {
        include __DIR__ . '/../views/auth/forgot-pass.php';
    }


    // Handle login submission
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Email and password are required.";
            header("Location: /login");
            exit;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            Auth::login($user);
            header("Location: /dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: /login");
            exit;
        }
    }

    public function register()
    {
        $email = $_POST['email'] ?? '';
        $given = $_POST['given'] ?? '';
        $surname = $_POST['surname'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validate input
        if (empty($email) || empty($given) || empty($surname) || empty($password)) {
            $_SESSION['error'] = "All fields are required.";
            header("Location: /register");
            exit;
        }

        // Check if email already exists
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = "Email already in use.";
            header("Location: /register");
            exit;
        }

        // Fix: Call the register method instead of create
        if ($this->userModel->create($email, $given, $surname, password_hash($password, PASSWORD_BCRYPT))) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: /login");
            exit;
        } else {
            $_SESSION['error'] = "Registration failed.";
            header("Location: /register");
            exit;
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        header("Location: /login");
        exit;
    }
}
