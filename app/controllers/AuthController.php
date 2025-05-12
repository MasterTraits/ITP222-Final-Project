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
            header("Location: /");
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password. ";
            header("Location: /login");
            exit;
        }
    }

    public function registerForm()
    {
        include __DIR__ . '/../views/auth/register.php';
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
        if ($this->userModel->create($email, $given, $surname, $password)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: /login");
            exit;
        } else {
            $_SESSION['error'] = "Registration failed.";
            header("Location: /register");
            exit;
        }
    }

    public function forgotPasswordForm()
    {
        include __DIR__ . '/../views/auth/forgot-pass.php';
    }

    public function forgotPassword()
    {
        $email = $_POST['email'] ?? '';
        if (empty($email)) {
            $_SESSION['error'] = "Email is required.";
            header("Location: /forgot-pass");
            exit;
        }

        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 1800); // 30 minute expiry
        

        // Here you would typically send a password reset email
        $_SESSION['success'] = "Password reset link sent to your email.";
        header("Location: /login");
        exit;
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        header("Location: /login");
        exit;
    }
}
