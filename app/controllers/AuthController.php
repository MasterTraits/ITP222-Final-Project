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
            $_SESSION['error'] = "Invalid email or password. " . $user['reset_token_hash']  ;
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
        
        if ($this->userModel->resetPassword($email, $token_hash, $expiry)) {
            header("Location: /forgot-pass");
        } else {
            $_SESSION['error'] = "Failed to send password reset link.";
            header("Location: /forgot-pass");
        }
    }

    public function resetPasswordForm()
    {
        $token = $_GET['token'] ?? '';
        if (empty($token)) {
            $_SESSION['error'] = "Invalid token.";
            header("Location: /login");
            exit;
        }

        include __DIR__ . '/../views/auth/reset.php';
    }

    public function resetPassword()
    {
        $token = $_POST['token'];
        
        if (empty($token)) {
            $_SESSION['error'] = "Missing reset token. Please try again.";
            header("Location: /forgot-pass");
            exit;
        }
        
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Password validation
        $errors = [];
        
        // Check if passwords match
        if ($new_password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }
        
        // Check password length
        if (strlen($new_password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        
        // Check password complexity
        if (!preg_match('/[A-Z]/', $new_password)) {
            $errors[] = "Password must include at least one uppercase letter.";
        }
        
        if (!preg_match('/[a-z]/', $new_password)) {
            $errors[] = "Password must include at least one lowercase letter.";
        }
        
        if (!preg_match('/[0-9]/', $new_password)) {
            $errors[] = "Password must include at least one number.";
        }
        
        if (!preg_match('/[^A-Za-z0-9]/', $new_password)) {
            $errors[] = "Password must include at least one special character.";
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode("<br>", $errors);
            header("Location: /reset?token=$token");
            exit;
        }
        
        if ($this->userModel->updatePassword($token, $new_password)) {
            $_SESSION['success'] = "Password reset successful! Please login.";
            header("Location: /login");
            exit;
        } else {
            $_SESSION['error'] = "Failed to reset password.";
            header("Location: /reset?token=$token");
            exit;
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        header("Location: /");
        exit;
    }
}
