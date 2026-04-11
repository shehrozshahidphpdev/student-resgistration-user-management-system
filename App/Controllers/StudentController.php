<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Services\Session;

class StudentController
{
  public $errors;
  public $user;
  public $student;

  public function __construct()
  {
    $this->errors = [];
    $this->student = new Student();
    $this->user = new User();
  }

  public function index()
  {
    $user = Session::get('user');
    $user = $this->user->getUserData($user['id']);
    return view('student.dashboard', [
      'data' => $user,
    ]);
  }

  public function editProfile()
  {
    $csrf_token = generateCsrfToken();
    $user = Session::get('user');
    $user = $this->user->getUserData($user['id']);
    $data = [];
    $data = [
      'first_name' => $user['first_name'],
      'last_name' => $user['last_name'],
      'phone' => $user['phone']
    ];


    return view('student.edit', [
      'csrf_token' => $csrf_token,
      'data' => $data,
    ]);
  }

  public function changePassword()
  {
    $csrf_token = generateCsrfToken();

    return view('student.change-password', [
      'csrf_token' => $csrf_token
    ]);
  }

  public function updatePassword()
  {
    $request = $_POST;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

      if (!isset($request['csrf_token']) || $request['csrf_token'] !== Session::get('csrf_token')) {
        die("Cannot Proceed: CSRF token does not match");
      }

      $user = Session::get('user');
      $currentUser = $this->user->getUserData($user['id']);

      $oldHashedPassword = $currentUser['password'];

      $oldPassword = $request['old_password'];
      $newPassword = $request['new_password'];

      if (! $this->validateUpdatePasswords($oldPassword, $oldHashedPassword, $newPassword)) {
        Session::put('old', $request);
        redirect('/student/dashboard/password');
      }

      $updated = $this->student->updatePassword($currentUser['id'], $newPassword);

      if ($updated) {
        Session::put('success', "Password Updated successfully!");
        redirect('/student/dashboard/password');
      }
    }
  }

  public function updateProfile()
  {
    $request = $_POST;
    $profile = $_FILES;

    if (! isset($request['csrf_token']) || $request['csrf_token'] !== Session::get('csrf_token')) {
      die('sorry csrf token mismatch');
    }

    $user = Session::get('user');

    $first_name = $request['first_name'];
    $last_name = $request['last_name'];
    $phone = $request['phone'];
    $profile_name = $profile['profile']['name'];

    if (! $this->validateUpdateProfileRequest($first_name, $last_name, $phone, $profile)) {
      Session::put('old', $request);
      redirect('/student/dashboard/edit-profile');
    }

    try {
      if (isset($profile['profile']['name']) && $profile['profile']['error'] === UPLOAD_ERR_OK) {
        $image = $profile['profile'];
        $destination = 'uploads';
        $fileName = $destination . '/' .  basename($image['name']);
        move_uploaded_file($image['tmp_name'], $fileName);
      } else {
        $userData = $this->user->getUserData($user['id']);
        $fileName = $userData['profile'];
      }

      $data = [];

      $data = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'phone' => $phone,
        'profile' => $fileName
      ];

      $userId = $user['id'];

      if ($this->student->updateStudentProfile($data, $userId)) {

        $userData = $this->user->getUserData($user['id']);

        Session::put('user', [
          'id' => $userData['id'],
          'first_name' => $userData['first_name'],
          'last_name' => $userData['last_name'],
          'email' => $userData['email'],
          'role' => $userData['role'],
        ]);

        Session::put('success', "Profile Updated  successfully");
        redirect('/student/dashboard/edit-profile');
      }
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function validateUpdatePasswords($oldPassword, $oldHashedPassword, $newPassword)
  {
    if (empty($oldPassword)) {
      $this->errors['old_password'] = "The Password field is required";
    } else if (! password_verify($oldPassword, $oldHashedPassword)) {
      $this->errors['old_password'] = "The password do not match ur records";
    }
    if (empty($newPassword)) {
      $this->errors['new_password'] = "The password field is required";
    } else if (strlen($newPassword) < 8) {
      $this->errors['new_password'] = "Please password must be atleat 8 characters long";
    } else if (!preg_match('/[A-Z]/', $newPassword)) {
      $this->errors['new_password'] = "Password must contain at least one uppercase letter";
    } else if (!preg_match('/[a-z]/', $newPassword)) {
      $this->errors['new_password'] = "Password must contain at least one lowricase letter";
    } else if (!preg_match('/[0-9]/', $newPassword)) {
      $this->errors['new_password'] = "Password must contain at least one number";
    } else if (!preg_match('/[\W]/', $newPassword)) {
      $this->errors['new_password'] = "Password must contain a special character";
    }

    if (count($this->errors) > 0) {
      Session::put('errors', $this->errors);
      return false;
    }

    return true;
  }

  public function validateUpdateProfileRequest($first_name, $last_name, $phone, $profile)
  {
    if (empty($first_name)) {
      $this->errors['first_name'] = "The First  name field is required";
    } else if (strlen($first_name) < 3) {
      $this->errors['first_name'] = "The first name must atleast 3 characters long";
    }

    if (empty($last_name)) {
      $this->errors['last_name'] = "The last name field is required";
    } else if (strlen($last_name) < 3) {
      $this->errors['last_name'] = "The last  name must atleast 3 characters long";
    }

    if (empty($phone)) {
      $this->errors['phone'] = "The phone field is required";
    }

    if (isset($profile['profile']) && $profile['profile']['error'] === UPLOAD_ERR_OK) {
      $this->validateProfileImage($profile);
    }

    if (count($this->errors) > 0) {
      Session::put('errors', $this->errors);
      return false;
    }

    return true;
  }

  public function validateProfileImage(array $profile)
  {
    $alllowedMimes = ['jpg', 'png', 'webp'];
    $max_allowed_size = 5 * 1024 * 1024;
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
