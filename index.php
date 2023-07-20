<?php
require_once("controllers/Controller.php");
require_once('models/Session.php');

$session = new Session();
$session->start();

if ($session->isLoggedIn() && isset($_SESSION['userData'])) {
    // użytkownik jest zalogowany
    $section = filter_input(INPUT_GET, 'section', FILTER_SANITIZE_STRING) ?? 'dashboard';
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? 'index';
    

    $controllerClass = ucfirst($section) . 'Controller';
    $controllerFile = 'controllers/' . $controllerClass . '.php';

    // echo $controllerClass;
    // echo "<br>";
    // echo $controllerFile;

    if (file_exists($controllerFile)) {
        require_once($controllerFile);
        $controller = new $controllerClass();
        $controller->runAction($action);
    } else {
        include 'views/status-pages/404.html';
    }
} else {
    // użytkownik nie jest zalogowany
    require_once("controllers/LoginController.php");
    if (isset($_GET['section']) == "login" && isset($_GET['action']) ) {
        $controller = new LoginController();
        $controller->runAction($_GET['action'] ?? "index");
    } else {
        $controller = new LoginController();
        $controller->runAction('index');
        exit();
    }
}
?>