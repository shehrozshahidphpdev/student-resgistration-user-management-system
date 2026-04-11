<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Services\Session;

class AdminController
{
  public $db;
  public $student;
  public function __construct()
  {
    $this->db = new User();
    $this->student = new Student();
  }
  public function index()
  {
    return view('admin.dashboard');
  }

  public function students()
  {
    $search = isset($_GET['search']) ? $_GET['search'] : null;
    if ($search) {
      $students = $this->student->searchStudents($search);
    } else {
      $students = $this->student->getAllStudents();
    }
    return view('admin.students', [
      'students' => $students
    ]);
  }


  public function deleteStudent()
  {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $result = $this->student->deleteStudent($id);
    if ($result) {
      Session::put('success', "Student Profile Deleted Successfully");
      redirect('/admin/dashboard/students');
    }
  }

  public function updateStatus()
  {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;

    $result = $this->student->updateStatus($id, $status);
    if ($result) {
      Session::put('success', "Status changed successfully");
      redirect('/admin/dashboard/students');
    }
  }

  public function activityLogs()
  {
    $activities = $this->student->getAllstudentsActicities();
    // dd($activities);
    return view('admin.student-activities', [
      'activities' => $activities
    ]);
  }
}
