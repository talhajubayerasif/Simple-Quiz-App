<?php
try {
    // Get action from query parameter set by .htaccess
    $action = $_GET['path'] ?? 'index';
    $action = trim($action, '/'); // remove leading/trailing slashes

    require_once __DIR__ . '/controllers/AuthController.php';
    $controller = new AuthController();

    switch ($action) {
        case 'register':       // show signup form or handle POST
            $controller->signup();
            break;

        case 'login':          // show login form
            $controller->login();
            break;

        case 'authenticate':   // handle login POST
            $controller->authenticate();
            break;

        case 'index':          // home page
            include __DIR__ . '/views/home.php';
            break;

        default:
            http_response_code(404);
            include __DIR__ . '/views/errors/404.php';
            break;
    }

} catch (Exception $e) {
    http_response_code(500);
    error_log("MVC Error: " . $e->getMessage());
    include __DIR__ . '/views/errors/500.php';
}
