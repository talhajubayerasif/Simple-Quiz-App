<?php
try {
    // Get action from query parameter set by .htaccess
    $action = $_GET['path'] ?? 'index';
    $action = trim($action, '/'); // remove leading/trailing slashes

    require_once __DIR__ . '/controllers/AuthController.php';
    $controller = new AuthController();

    require_once __DIR__ . '/controllers/UserController.php';
    $user_controller = new UserController();

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

        case 'dashboard':      // unified dashboard
            $user_controller->dashboard();
            break;

        case 'logout':
        $user_controller->logout();
        break;

        case 'profile':
        $user_controller->profile();
        break;

        case 'profile-edit':
        $user_controller->editProfile();
        break;

        case 'profile-update':
        $user_controller->updateProfile();
        break;

        case 'profile-delete':
        $user_controller->deleteProfile();
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
