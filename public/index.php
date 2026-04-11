<?php

declare(strict_types=1);
error_reporting(E_ALL);

use App\Controllers\AdminController;
use App\Controllers\Database;
use App\Controllers\StudentController;
use App\Controllers\UserController;

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
    redirectIfAuthenticated() || redirectIfYouRemember();
    $user->login();
    break;

  case '/register':
    redirectIfAuthenticated();
    $user->register();
    break;

  case '/student-register':
    $user->store();
    break;

  case '/login':
    redirectIfAuthenticated();
    $user->attemptLogin();
    break;

  case '/student/dashboard':
    isLoggedin() && isStudent();
    $student->index();
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
    $student->updatePassword();
    break;

  case '/student/profile/update':
    isLoggedin() && isStudent();
    $student->updateProfile();
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
    break;

  case '/not-allowed':
    view('access-denied');
    break;

  case '/logout':
    isLoggedin();
    $user->logout();
    break;

  default:
    view('404');
    break;
}
