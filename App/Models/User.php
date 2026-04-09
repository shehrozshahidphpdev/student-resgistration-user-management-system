<?php

namespace App\Models;

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
}
