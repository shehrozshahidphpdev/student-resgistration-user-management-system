<?php

use App\Controllers\Database;
use App\Controllers\UserController;

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once dirname(__DIR__) . '/vendor/autoload.php';


require_once dirname(__DIR__) . '/App/config/constants.php';
require_once dirname(__DIR__) . '/App/Helpers/helpers.php';
$conn = Database::getInstance()->getConnection();
$user = new UserController();

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
}
