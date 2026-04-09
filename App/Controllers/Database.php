<?php

namespace App\Controllers;

use Dba\Connection;
use PDO;

class Database
{

  private $host;
  private $user_name;
  private $password;
  private $db_name;

  public static ?Database $instance = null;

  private PDO $conn;

  public function __construct(string $host, string $user_name, string $password, string $db_name)
  {
    $this->host = $host;
    $this->user_name = $user_name;
    $this->password = $password;
    $this->db_name = $db_name;

    $this->makeConnection();
  }

  private function makeConnection(): void
  {
    try {
      $dsn = "mysql:host=$this->host;dbname=$this->db_name";

      $this->conn = new PDO($dsn, $this->user_name, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $e) {
      die("Conneciton Failed: " . $e->getMessage());
    }
  }

  public static function getInstance(): object
  {
    if (self::$instance == null) {
      self::$instance = new self(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    }
    return self::$instance;
  }


  public function getConnection()
  {
    return $this->conn;
  }
}
