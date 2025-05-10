<?php
namespace App\controllers;

class Auth
{
    // Log the user in by saving data to session
    public static function login($user)
    {
        session_regenerate_id(true); // Prevent session fixation
        $_SESSION['user'] = $user;
    }

    // Log the user out
    public static function logout()
    {
        session_unset();    // Remove all session variables
        session_destroy();  // Destroy the session
    }

    // Check if user is logged in
    public static function check()
    {
        return isset($_SESSION['user']);
    }

    // Get the currently logged in user's data
    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }
}

?>