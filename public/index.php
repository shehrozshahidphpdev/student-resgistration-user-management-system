<?php

declare(strict_types=1);
error_reporting(E_ALL);

use App\Controllers\Database;
use App\Controllers\UserController;



use App\Controllers\DashboardController;
use App\Controllers\StudentController;
use App\Services\Session;


if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once dirname(__DIR__) . '/vendor/autoload.php';


require_once dirname(__DIR__) . '/App/config/constants.php';
require_once dirname(__DIR__) . '/App/Helpers/helpers.php';
$conn = Database::getInstance()->getConnection();
$user = new UserController();
$student = new StudentController();

$uri = $_SERVER['REQUEST_URI'];

$uri = parse_url($uri, PHP_URL_PATH);

switch ($uri) {
  case '/':
    $user->login();
    break;

  case '/register':
    $user->register();
    break;

  case '/student-register':
    $user->store($_POST, $_FILES);
    break;

  case '/login':
    $user->attemptLogin($_POST);
    break;

  case '/student/dashboard':
    isLoggedin() && isStudent();
    $student->index();
    break;

  default:
    die("Sorry the Page you are looking for is not found!");
}
