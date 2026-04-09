<?php

use App\Services\Session;

require_once dirname(__DIR__, 2) . '/App/config/constants.php';

if (! function_exists('dump')) {
  function dump(mixed $data): void
  {
    echo "<pre>";
    var_dump($data);
  }
}

if (! function_exists('dd')) {
  function dd(mixed $data): void
  {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
  }
}

if (! function_exists('view')) {
  function view(string $fileName, mixed $data = []): void
  {
    $fileName = str_replace('.', '/', $fileName);

    $path = VIEWS_PATH . $fileName . '.php';

    if (file_exists($path)) {
      extract($data);
      include_once $path;
    } else {
      echo "Sorry The $path does not exists";
    }
  }
}

if (! function_exists('assets')) {
  function assets(string $file)
  {

    $path = ASSETS_PATH . $file;

    if (file_exists($path)) {
      return $path;
    } else {
      echo "Sorry The $path does not exists";
    }
  }
}

if (! function_exists('generateCsrfToken')) {
  function generateCsrfToken()
  {
    $csrf_token = bin2hex(random_bytes(32));
    Session::put('csrf_token', $csrf_token);
    return $csrf_token;
  }
}
