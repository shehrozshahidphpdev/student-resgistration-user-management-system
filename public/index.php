<?php

declare(strict_types=1);
error_reporting(E_ALL);

use App\Controllers\AdminController;
use App\Controllers\DashboardController;



use App\Controllers\Database;
use App\Controllers\StudentController;
use App\Controllers\UserController;
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
$admin = new AdminController();
$uri = $_SERVER['REQUEST_URI'];

$uri = parse_url($uri, PHP_URL_PATH);

switch ($uri) {
  case '/':
    redirectIfAuthenticated();
    redirectIfYouRemember($conn);
    $user->login();
    break;

  case '/register':
    redirectIfAuthenticated();
    $user->register();
    break;

  case '/student-register':
    $user->store($_POST, $_FILES);
    break;

  case '/login':
    redirectIfAuthenticated();
    $user->attemptLogin($_POST);
    break;

  case '/student/dashboard':
    isLoggedin() && isStudent();
    $student->index();
    break;

  case '/student/dashboard/profile':
    isLoggedin() && isStudent();
    $student->profile();
    break;

  case '/student/dashboard/edit-profile':
    isLoggedin() && isStudent();
    $student->editProfile();
    break;

  case '/student/dashboard/password':
    isLoggedin() && isStudent();
    $student->changePassword();
    break;

  case '/student/update-password':
    isLoggedin() && isStudent();
    $student->updatePassword($_POST);
    break;

  case '/student/profile/update':
    isLoggedin() && isStudent();
    $student->updateProfile($_POST, $_FILES);
    break;


  case '/admin/dashboard':
    isLoggedin() && isAdmin();
    $admin->index();
    break;

  case '/admin/dashboard/students':
    isLoggedin() && isAdmin();
    $admin->students();
    break;

  case '/student/delete':
    isLoggedin() && isAdmin();
    $admin->deleteStudent();
    break;

  case '/student/status/update':
    isLoggedin() && isAdmin();
    $admin->updateStatus();
    break;

  case '/admin/dashboard/students/activities':
    isLoggedin() && isAdmin();
    $admin->activityLogs();

  case '/logout':
    isLoggedin();
    $user->logout();
    break;

  default:
    die("Sorry the Page you are looking for is not found!");
}
