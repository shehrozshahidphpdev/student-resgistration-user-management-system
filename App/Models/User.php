<?php

namespace App\Models;

use App\Services\Session;
use PDO;

class User
{
  public $conn;
  public function __construct()
  {
    $this->conn = $GLOBALS['conn'];
  }
  public function insert($data)
  {
    $query = "INSERT INTO users (first_name, last_name, email, password, role, status, phone, profile)
      VALUES(:first_name, :last_name, :email, :password, :role, :status, :phone, :profile)";

    $stmt = $this->conn->prepare($query);

    $result = $stmt->execute([
      ':first_name' => $data['first_name'],
      ':last_name' => $data['last_name'],
      ':email' => $data['email'],
      ':password' => $data['password'],
      ':role' => 'student',
      ':status' => 'active',
      ':phone' => $data['phone'],
      ':profile' => $data['profile']
    ]);

    return $data;
  }

  public function getAllUsers()
  {
    $stmt = $this->conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }

  public function insertRememberToken(int $user_id, string $token)
  {
    $stmt = $this->conn->prepare("INSERT INTO remember_tokens (user_id, token, token_expiration_date)
    VALUES(:user_id, :token, :token_expiration_date);
    ");

    $stmt->execute([
      ':user_id' => $user_id,
      ':token' => $token,
      ':token_expiration_date' => date('Y-m-d H:i:s', time() + 30 * 24 * 60 * 60)
    ]);

    return true;
  }


  public function getUserData(int $id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([
      ':id' => $id
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  public function updatePassword(int $id, string $newPassword)
  {
    $stmt = $this->conn->prepare("UPDATE users SET password = :newPassword");
    $result = $stmt->execute([
      ':newPassword' => password_hash($newPassword, PASSWORD_DEFAULT),
    ]);
    return $result;
  }

  public function updateStudentProfile($data, $userId)
  {
    try {
      $this->conn->beginTransaction();
      $stmt = $this->conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, phone = :phone, profile = :profile
      WHERE id = :user_id
      ");

      $stmt->execute([
        ':first_name' => $data['first_name'],
        ':last_name' => $data['last_name'],
        ':phone' => $data['phone'],
        ':profile' => $data['profile'],
        ':user_id' => $userId
      ]);

      $stmt = $this->conn->prepare("INSERT INTO activity_logs (user_id, action, message) VALUES(:user_id, :action, :message)");

      $stmt->execute([
        ':user_id' => $userId,
        ':action' => "update profile",
        ':message' => "Profile Updated",
      ]);
      $this->conn->commit();
    } catch (\Exception $e) {
      $this->conn->rollback();
      dd($e->getMessage());
    }

    return true;
  }

  public function getAllstudents()
  {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE role = :role");
    $stmt->execute([
      ':role' => 'student',
    ]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $students;
  }

  public function deleteStudent($id)
  {
    $user = Session::get('user');
    try {
      $this->conn->beginTransaction();

      $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");

      $stmt->execute([
        ':id' => $id
      ]);

      $stmt = $this->conn->prepare("INSERT INTO activity_logs (user_id, action, message) VALUES(:user_id, :action, :message)");

      $stmt->execute([
        ':user_id' => $user['id'],
        ':action' => "delete student",
        ':message' => "Student Profile Deleted",
      ]);

      $this->conn->commit();
    } catch (\Exception $e) {
      $this->conn->rollback();
      dd($e->getMessage());
    }
    return true;
  }

  public function updateStatus($id, $status)
  {
    $user = Session::get('user');
    try {
      $this->conn->beginTransaction();

      $stmt = $this->conn->prepare("UPDATE users SET status = :status WHERE id = :id");

      $stmt->execute([
        ':status' => $status == 'active' ? 'blocked' : 'active',
        ':id' => $id,

      ]);

      $stmt = $this->conn->prepare("INSERT INTO activity_logs (user_id, action, message) VALUES(:user_id, :action, :message)");

      $stmt->execute([
        ':user_id' => $user['id'],
        ':action' => "change sttaus",
        ':message' => "Profile Status Changed",
      ]);

      $this->conn->commit();
    } catch (\Exception $e) {
      $this->conn->rollback();
      dd($e->getMessage());
    }
    return true;
  }

  public function getAllstudentsActicities()
  {
    $stmt = $this->conn->prepare("
    SELECT * FROM 
    activity_logs 
     INNER JOIN users
      ON
       activity_logs.user_id = users.id 
       WHERE role = :role
       ");
    $stmt->execute([
      ':role' => 'student',
    ]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $students;
  }
}
