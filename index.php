<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

include "controllers/AuthController.php";
include "controllers/StudentController.php";
include "config/Database.php";

$script_name = dirname($_SERVER['SCRIPT_NAME']); 
$url = $_SERVER['REQUEST_URI'];
$request = explode("/", $url);
//get the last element 
$request = $request[count($request) - 1];

$db = new Database();
$conn = $db -> connect();
$studentController = new StudentController($script_name, $conn);
$controller = new AuthController($script_name, $conn);

// echo "url: " . $url . "<br>";
// echo "request: " . $request . "<br>";
// echo "script_name: " . $script_name . "<br>";

switch ($request) {
  case "register":
    $controller -> register();
    break;
  case "login":
    $controller -> login();
    break;
  case "logout":
    $controller -> logout();
    break;
  case "dashboard":
    $studentController -> dashboard();
    break;
  case "addStudent":
    $studentController -> addStudent();
    break;
  case "deleteStudent":
    $studentController -> deleteStudent();
    break;
  default:
    $controller -> index();
    break;
}

?>