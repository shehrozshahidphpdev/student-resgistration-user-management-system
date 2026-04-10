<?php

namespace App\Services;

class Session
{
  public static function put($key, $value): void
  {
    $_SESSION[$key] = $value;
  }

  public static function get($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }

    return null;
  }

  public static function destroy()
  {
    session_unset();
    session_destroy();
  }

  public static function unset($key)
  {
    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
    }
  }

  public static function flash($key)
  {
    if (isset($_SESSION[$key])) {
      $value = $_SESSION[$key];
      unset($_SESSION[$key]);
      return $value;
    }
  }
}
