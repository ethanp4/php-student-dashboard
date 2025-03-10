<?php

class UserModel {
  private $conn;

  public function __construct($conn) {
    $this -> conn = $conn;
  }

  public function register($email, $password) {
    //insert the new user into the db
    $query = "INSERT INTO user (email, password) VALUES (?, ?)";
    $stmt = $this -> conn -> prepare($query);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt -> bind_param("ss", $email, $password_hash);
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
    // if ($stmt -> errno == 1062) {
    //   // echo "Email already in use";
    //   $stmt -> close();
    //   return false;
    // }
  }

  public function login($email, $password) {
    //query for the requested user
    $query = "SELECT * FROM user WHERE email = ?";
    $stmt = $this -> conn -> prepare($query);
    $stmt -> bind_param("s", $email);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $user = $result -> fetch_assoc();
    $stmt -> close();

    //if there was a user and the password matches, return the user
    if ($user && password_verify($password, $user['password'])) {
      return $user;
    }

    //otherwise return false
    return false;
  }
}

?>