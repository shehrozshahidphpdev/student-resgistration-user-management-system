<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Session;

class UserController
{


  public $errors;
  public function __construct()
  {
    $this->errors = [];
  }

  public function login()
  {
    return view('login');
  }

  public function register()
  {
    $csrf_token = generateCsrfToken();

    return view('register', [
      'csrf_token' => $csrf_token
    ]);
  }

  public function store($request, $profile)
  {
    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register'])) {
      $firstName = $request['first_name'];
      $lastName = $request['last_name'];
      $email = $request['email'];
      $password = $request['password'];
      $phone = $request['phone'];
    }

    if (! $this->validateRegisterRequest($firstName, $lastName, $email, $password, $phone, $profile)) {
      Session::put('old', $request);
      header('Location: /register');
      exit();
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


      $user = new User();
      if ($user->insert($data)) {
        Session::put('success', "Registration successfull!");
        header('Location: /');
        exit();
      };
    } catch (\Exception) {
      die('Data not created successfully');
    }
  }

  public function validateRegisterRequest(string $firstName, string $lastName, string $email, string $password, string $phone, $profile)
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
    $alllowedMimes = ['jpg', 'png', 'webp'];
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
}
