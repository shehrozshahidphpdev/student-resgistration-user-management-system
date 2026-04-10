<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Session;

class AdminController
{
  public $db;
  public function __construct()
  {
    $this->db = new User();
  }
  public function index()
  {
    return view('admin.dashboard');
  }

  public function students()
  {
    $students = $this->db->getAllStudents();
    return view('admin.students', [
      'students' => $students
    ]);
  }

  public function deleteStudent()
  {
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    $result = $this->db->deleteStudent($id);

    if ($result) {
      Session::put('success', "Student Profile Deleted Successfully");
      header('Location: /admin/dashboard/students');
      exit();
    }
  }

  public function updateStatus()
  {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;

    $result = $this->db->updateStatus($id, $status);
    if ($result) {
      Session::put('success', "Status changed successfully");
      header('Location: /admin/dashboard/students');
      exit();
    }
  }

  public function activityLogs()
  {
    $activities = $this->db->getAllstudentsActicities();
    // dd($activities);
    return view('admin.student-activities', [
      'activities' => $activities
    ]);
  }
}
