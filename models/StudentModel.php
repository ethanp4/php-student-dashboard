<?php 

class StudentModel {
  private $conn;

  public function __construct($conn) {
    $this -> conn = $conn;
  }

  public function delete_student($id) {
    $query = "DELETE FROM student WHERE id = ?";
    $stmt = $this -> conn -> prepare($query);
    $stmt -> bind_param("i", $id);
    $stmt -> execute();
    $stmt -> close();
  }

  public function add_student($name, $email) {
    $query = "INSERT INTO student (name, email) VALUES (?, ?)";
    $stmt = $this -> conn -> prepare($query);
    $stmt -> bind_param("ss", $name, $email);
    try {
      $stmt -> execute();
    } catch (Exception $e) {
      $stmt -> close();
      return false;
    }

    if ($stmt -> affected_rows > 0) {
      $stmt -> close();
      return true;
    }
  }

  public function get_all_students() {
    $query = "SELECT * FROM student";
    $stmt = $this -> conn -> prepare($query);
    $stmt -> execute();
    $students = $stmt -> get_result();
    $stmt -> close();

    if ($students -> num_rows == 0) {
      return [];
    } else {
      return $students -> fetch_all(MYSQLI_ASSOC);
    }
  }
}
?>