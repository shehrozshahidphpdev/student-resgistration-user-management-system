<?php

namespace App\Controllers;

use App\Services\Session;

class UserController
{


  public function login()
  {
    return view('login');
  }

  public function register()
  {
    $csrf_token = bin2hex(random_bytes(32));
    Session::put('csrf_token', $csrf_token);

    return view('register', [
      'csrf_token' => $csrf_token
    ]);
  }

  public function attempRegistration($request)
  {
    dd($request);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
      $firstName = $request['first_name'];
      $lastName = $request['last_name'];
      $email = $request['email'];
      $phone = $request['phone'];
    }
  }
}
