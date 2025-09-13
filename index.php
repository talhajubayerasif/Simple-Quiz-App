<?php
try {
    // Get action from query parameter set by .htaccess
    $action = $_GET['path'] ?? 'index';
    $action = trim($action, '/'); // remove leading/trailing slashes

    // Load controllers
    require_once __DIR__ . '/controllers/AuthController.php';
    require_once __DIR__ . '/controllers/UserController.php';

    $auth_controller = new AuthController();
    $user_controller = new UserController();

    switch ($action) {
        // ===== Auth routes =====
        case 'register':         // show signup form or handle POST
            $auth_controller->signup();
            break;

        case 'login':            // show login form
            $auth_controller->login();
            break;

        case 'authenticate':     // handle login POST
            $auth_controller->authenticate();
            break;

        case 'logout':           // logout
            $auth_controller->logout();
            break;

        case 'change-password':  // change/reset password (logged in user)
            $auth_controller->changePassword();
            break;

        case 'dashboard':        // unified dashboard
            $user_controller->dashboard();
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

        case 'manage-users':
            $user_controller->listUsers();
            break;

        case 'user-create':
            $user_controller->createUser();
            break;

        case (preg_match('/^user-edit\/(\d+)$/', $action, $matches) ? true : false):
            $user_controller->editUser($matches[1]);
            break;

        case (preg_match('/^user-delete\/(\d+)$/', $action, $matches) ? true : false):
            $user_controller->deleteUser($matches[1]);
            break;



        // ===== Home & errors =====
        case 'index':            // home page
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
