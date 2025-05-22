<?php

session_start();
require 'vendor/autoload.php';

$env = parse_ini_file(__DIR__ . '/.env');
$db = new PDO("mysql:host={$env['HOST']};dbname={$env['DBNAME']}", $env['USERNAME'], $env['PASSWORD']);

use App\controllers\AuthController;
use App\controllers\TripController;

$authController = new AuthController($db);
$tripController = new TripController($db);

// Improved request handling
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_dir = dirname($_SERVER['SCRIPT_NAME']);

if ($base_dir != '/' && strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}
$request = rtrim($request, '/') ?: '/';

switch ($request) {
    case '/':
        // Home page
        include __DIR__ . '/app/views/home.php';
        break;

    /*******************************
           USER AUTHENTICATION
         ********************************/

    case '/login':
        $authController->loginForm();
        break;

    case '/auth/login':
        $authController->login();
        break;

    case '/register':
        $authController->registerForm();
        break;

    case '/auth/register':
        $authController->register();
        break;

    case '/forgot-pass':
        $authController->forgotPasswordForm();
        break;

    case '/auth/forgot-pass':
        $authController->forgotPassword();
        break;

    case '/reset':
        $authController->resetPasswordForm();
        break;

    case '/auth/reset':
        $authController->resetPassword();
        break;

    case '/logout':
        $authController->logout();
        break;

    /*******************************
            BOOKING STEPS
    ********************************/
    case '/book/1':
        include __DIR__ . '/app/views/book/book-step1.php';
        break;

    case '/book/2':
        include __DIR__ . '/app/views/book/book-step2.php';
        break;

    case '/book/3':
        include __DIR__ . '/app/views/book/book-step3.php';
        break;

    case '/booking-confirmation':
        $tripController->saveFormData();
        break;

    case '/booking-success':
        include __DIR__ . '/app/views/book/booking-success.php';
        break;

    case '/your-trips':
        $tripController->userTrips();
        break;

    case '/test':
        include __DIR__ . '/app/views/test.php';
        break;

    /*******************************
            USER TRIPS
    ********************************/

    case '/travel/palawan':
        include __DIR__ . 'app/views/travel/palawan.php';
        break;


    default:
        http_response_code(404);
        include __DIR__ . '/app/views/not-found.php';
        error_log("404 Not Found: " . $request);
        break;
}
