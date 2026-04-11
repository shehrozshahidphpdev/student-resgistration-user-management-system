<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Session;

class UserController
{


  public $errors;
  public $user;
  public function __construct()
  {
    $this->errors = [];
    $this->user = new User();
  }

  public function login()
  {
    $csrf_token = generateCsrfToken();
    return view('login', [
      'csrf_token' => $csrf_token
    ]);
  }

  public function register()
  {
    $csrf_token = generateCsrfToken();

    return view('register', [
      'csrf_token' => $csrf_token
    ]);
  }

  public function store()
  {
    $request = $_POST;
    $profile = $_FILES;

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($request['register'])) {
      if (! isset($request['csrf_token']) ||  $request['csrf_token'] !== Session::get('csrf_token')) {
        die('csrf token dont match');
      }

      $firstName = $request['first_name'];
      $lastName = $request['last_name'];
      $email = $request['email'];
      $password = $request['password'];
      $phone = $request['phone'];
    }

    $users = $this->user->getAllUsers();

    if (! $this->validateRegisterRequest($firstName, $lastName, $email, $password, $phone, $profile, $users)) {
      Session::put('old', $request);
      redirect('/register');
    }

    try {
      $image = $profile['profile'];
      $destination = 'uploads';
      $fileName = $destination . '/' .  basename($image['name']);
      move_uploaded_file($image['tmp_name'], $fileName);

      $data = [];
      $data = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'phone' => $phone,
        'profile' => $fileName
      ];

      if ($this->user->insert($data)) {
        Session::put('success', "Registration successfull!");
        redirect('/');
      };
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function attemptLogin()
  {
    $request = $_POST;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($request['login'])) {
      if (! isset($request['csrf_token']) ||  $request['csrf_token'] !== Session::get('csrf_token')) {
        die('cannot proceed csrf token does not mtach');
      }

      $email = $request['email'];
      $password = $request['password'];

      if (! $this->validateLoginRequest($email, $password)) {
        Session::put('old', $request);
        redirect('/');
      }

      $users = $this->user->getAllUsers();

      foreach ($users as $user) {
        if ($email == $user['email'] && password_verify($password, $user['password'])) {

          // check if the user is blocked or not 
          if ($user['status'] == 'blocked') {
            redirect('/not-allowed');
          }

          $user = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'role' => $user['role'],
          ];

          Session::put('user', $user);

          if (isset($request['remember'])) {
            $token = bin2hex(random_bytes(32));

            setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60));

            $this->user->insertRememberToken($user['id'], $token);
          }
          Session::put('user', $user);
          if ($user['role'] == 'student') {
            redirect('/student/dashboard');
          } else {
            redirect('/admin/dashboard');
          }
        }
      }
      Session::put('error', 'Invalid credebtials');
      redirect('/');
    }
  }

  public function logout()
  {
    $request = $_POST;
    if (! isset($request['csrf_token']) ||  $request['csrf_token'] !== Session::get('csrf_token')) {
      die('cannot proceed csrf token does not mtach');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = Session::get('user');

      if (isset($user)) {
        setcookie('remember_me', "", time() - 3600);
        unset($_COOKIE['remember_me']);
        Session::destroy();
        redirect('/');
      }
    } else {
      die("Something went wrong");
    }
  }

  public function validateRegisterRequest(string $firstName, string $lastName, string $email, string $password, string $phone, $profile, $users)
  {
    if (empty($firstName)) {
      $this->errors['first_name'] = "The first name field is required";
    } else if (strlen($firstName) < 3) {
      $this->errors['first_name'] = "The first name must contain atleast 3 characters";
    }

    if (empty($lastName)) {
      $this->errors['last_name'] = "The last name field is required";
    } else if (strlen($lastName) < 3) {
      $this->errors['last_name'] = "The last name field must contain atleast 3 characters";
    }

    if (empty($email)) {
      $this->errors['email'] = "The email flied cannot be empty";
    } else if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->errors['email'] = "Please Enter correct email format";
    }

    foreach ($users as $user) {
      if ($email == $user['email']) {
        $this->errors['email'] =  "The email has already been taken";
      }
    }

    if (empty($password)) {
      $this->errors['password'] = "The password field cannot be empty";
    } else if (strlen($password) < 8) {
      $this->errors['password'] = "Please password must be atleat 8 characters long";
    } else if (!preg_match('/[A-Z]/', $password)) {
      $this->errors['password'] = "Password must contain at least one uppercase letter";
    } else if (!preg_match('/[a-z]/', $password)) {
      $this->errors['password'] = "Password must contain at least one lowricase letter";
    } else if (!preg_match('/[0-9]/', $password)) {
      $this->errors['password'] = "Password must contain at least one number";
    } else if (!preg_match('/[\W]/', $password)) {
      $this->errors['password'] = "Password must contain a special character";
    }

    if (empty($phone)) {
      $this->errors['phone'] = "The Phone Field Cannot be empty";
    }
    $this->validateProfileImage($profile);

    if (count($this->errors) > 0) {
      Session::put('errors', $this->errors);
      return false;
    }
    return true;
  }

  public function validateProfileImage(array $profile)
  {
    $alllowedMimes = ['jpg', 'png', 'webp', 'JPG, WEBP', 'PNG'];
    $max_allowed_size = 10000;
    $profileName = $profile['profile']['name'];
    $profileMimeType = pathinfo($profileName, PATHINFO_EXTENSION);
    if (empty($profileName)) {
      $this->errors['profile'] = "The profile is required";
    } else if (! in_array($profileMimeType, $alllowedMimes)) {
      $this->errors['profile'] = "Only Webp, png and jpg are allowed";
    } else if ($profile['profile']['size'] > $max_allowed_size) {
      $this->errors['profile'] = "The profile size cannot be greater than 5 MB";
    }
  }

  public function validateLoginRequest(string $email, string $password)
  {
    if (empty($email)) {
      $this->errors['email'] = "The email field is required";
    } else if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->errors['email'] = "Please Enter correct email format";
    }
    if (empty($password)) {
      $this->errors['password'] = "The password Field is required";
    }
    if (count($this->errors) > 0) {
      Session::put('errors', $this->errors);
      return false;
    }
    return true;
  }
}
