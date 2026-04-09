<?php

namespace App\Services;

class Session
{

  public function __construct()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }
  public static function put($key, $value)
  {
    if (! isset($_SESSION[$key])) {
      $_SESSION[$key] = $value;
    }

    return true;
  }

  public static function get($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }

    echo "the key $key does not exists in the session";
  }

  public static function flash($key, $value)
  {
    if (! isset($_SESSION[$key])) {
      $_SESSION[$key] = $value;
    }

    unset($_SESSION[$key]);
  }

  public static function destroy()
  {
    session_unset();

    session_destroy();

    return true;
  }
}

$session = new Session();
