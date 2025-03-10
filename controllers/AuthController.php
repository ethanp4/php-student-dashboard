<?php

include "models/UserModel.php";

class AuthController {
  private $userModel;
  private $script_name;

  public function __construct($script_name, $conn) {
    $this -> script_name = $script_name;
    $this -> userModel = new UserModel($conn);
  }

  public function register() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $username = $_POST["username"];
      
      if ($this -> userModel -> register($email, $password, $username)) {
        $_SESSION["email"] = $email;
        header(sprintf("Location: %s/dashboard", $this -> script_name));
      } else {
        include "views/Register.php";
        echo "Registration failed";
      }
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      include "views/Register.php";
    }
  }

  public function login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];

      if ($this -> userModel -> login($email, $password)) {
        $_SESSION["email"] = $email;
        header(sprintf("Location: %s/dashboard", $this -> script_name));
      } else {
        include "views/Login.php";
        echo "Login failed";
      }
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      //if session has the username key set, then the user is logged in
      if (isset($_SESSION['email'])) {
        header(sprintf("Location: %s/dashboard", $this -> script_name));
      } else {
        include "views/Login.php";
      }
    }
  }

  public function logout() {
    session_destroy();
    header(sprintf("Location: %s/", $this -> script_name));
    exit();
  }

  public function index() {
    if (isset($_SESSION['email'])) {
      header(sprintf("Location: %s/dashboard", $this -> script_name));
    } else {
      header(sprintf("Location: %s/login", $this -> script_name));
    }
  }
}
?>