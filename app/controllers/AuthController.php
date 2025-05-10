<?php
namespace app\controllers;

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

    // Handle login submission
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            Auth::login($user);
            header("Location: /dashboard");
            exit;
        } else {
            echo "Invalid credentials.";
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
?>