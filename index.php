<?php

session_start();

// Autoloader for classes
spl_autoload_register(function($class) {
    // Convert namespace separators to directory separators
    $path = str_replace('\\', '/', $class) . '.php';
    $fullPath = __DIR__ . '/' . $path;
    
    if (file_exists($fullPath)) {
        require_once $fullPath;
    }
});

$env = parse_ini_file(__DIR__ . '/.env');
$db = new PDO("mysql:host={$env['HOST']};dbname={$env['DBNAME']}", $env['USERNAME'], $env['PASSWORD']);

use App\controllers\AuthController;
$authController = new AuthController($db);

// Improved request handling
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_dir = dirname($_SERVER['SCRIPT_NAME']);

if($base_dir != '/' && strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}
$request = rtrim($request, '/') ?: '/';


// Add debug output (remove in production)
// echo "Debug - Request URI: " . $request . "<br>";

// Route to the appropriate controller action
switch ($request) {
    case '/':
        // Home page
        include __DIR__ . '/app/views/home.php';
        break;
        
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
        
    case '/logout':
        $authController->logout();
        break;
        
    default:
        http_response_code(404);
        break;
}
?>
