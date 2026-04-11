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


}
