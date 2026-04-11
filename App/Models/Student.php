<?php

namespace App\Models;

use App\Services\Session;
use PDO;

class Student
{
  public $conn;

  public function __construct()
  {
    $this->conn = $GLOBALS['conn'];
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

  public function updatePassword(int $id, string $newPassword)
  {
    $stmt = $this->conn->prepare("UPDATE users SET password = :newPassword");
    $result = $stmt->execute([
      ':newPassword' => password_hash($newPassword, PASSWORD_DEFAULT),
    ]);
    return $result;
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

  public function searchStudents($search)
  {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE role = :role AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search)");
    $stmt->execute([
      ':role' => 'student',
      ':search' => '%' . $search . '%'
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
    ORDER BY users.id DESC
");
    $stmt->execute([
      ':role' => 'student',
    ]);
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $activities;
  }
}
