<?php

// Autoloader for classes
spl_autoload_register(function($class) {
    // Convert namespace separators to directory separators
    $path = str_replace('\\', '/', $class) . '.php';
    $fullPath = __DIR__ . '/../' . $path;
    
    if (file_exists($fullPath)) {
        require_once $fullPath;
    }
});

$env = parse_ini_file(__DIR__ . '/../.env');
$db = new PDO("mysql:host={$env['HOST']};dbname={$env['DBNAME']}", $env['USERNAME'], $env['PASSWORD']);

use App\controllers\AuthController;
$authController = new AuthController($db);

$request = $_SERVER['REQUEST_URI'];
$basePath = '/public';  

// Remove base path from request if present
if (strpos($request, $basePath) === 0) {
    $request = substr($request, strlen($basePath));
}

// Route to the appropriate controller action
switch ($request) {
    case '/':
        // Home page
        include __DIR__ . '/../app/views/home.php';
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
        
    case '/logout':
        $authController->logout();
        break;
        
    default:
        http_response_code(404);
        break;
}
?>
