<?php 

include "models/StudentModel.php";

class StudentController {
  private $studentModel;
  private $script_name;
  
  public function __construct($script_name, $conn) {
    $this -> script_name = $script_name;
    $this -> studentModel = new StudentModel($conn);
  }
  
  public function dashboard() {
    if (!isset($_SESSION['email'])) {
      header(sprintf("Location: %s/login", $this -> script_name));
    } else {
      $students = $this -> getAllStudents();
      include "views/Dashboard.php";
    }
  }

  public function deleteStudent() {
    $id = $_POST["id"];
    $this -> studentModel -> delete_student($id);
    header(sprintf("Location: %s/dashboard", $this -> script_name));
  }

  private function getAllStudents() {
    if (!isset($_SESSION['email'])) {
      header(sprintf("Location: %s/login", $this -> script_name));
    } else {
      $students = $this -> studentModel -> get_all_students();
      return $students;
    }
  }

  public function addStudent() {
    if (!isset($_SESSION['email'])) {
      header(sprintf("Location: %s/login", $this -> script_name));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $_POST['name'];
      $email = $_POST['email'];

      if ($this -> studentModel -> add_student($name, $email)) {
        header(sprintf("Location: %s/dashboard", $this -> script_name));
      }
    } else {
      header(sprintf("Location: %s/dashboard", $this -> script_name));
    }
  }
}

?>