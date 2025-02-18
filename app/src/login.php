<?php
ob_start();
session_start();
include 'header.php';
include "static/html/login.html";
if (isset($_SESSION["username"])){
  $username = $_SESSION["username"];
  header("Location:/index.php");
}

if (isset($_POST["username"]) && isset($_POST["password"])) {
  try {
    include "db.php";
    $username =  $_POST["username"];
    $password =  $_POST["password"];
    // $sql = "SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'"; // not secure
    // $db_result=$database->query($sql);
    $sql = "SELECT * FROM users WHERE username =? AND password = ?"; // more secure, prevent sql injection
    $prepare = $database->prepare($sql);
    $prepare->bind_param('ss', $username, $password);
    $prepare->execute();
    $db_result = $prepare->get_result(); 
    
    if ($db_result->num_rows > 0) {
      $row = $db_result->fetch_assoc  (); // Get the first row
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['address'] = $row['address'];
      $_SESSION['phone'] = $row['phone'];
      $_SESSION['money'] = $row['money'];
      header("Location: index.php");
    } else {
      $message = "Wrong username or password";
    }
  } catch (mysqli_sql_exception $e) {
    $message = $e->getMessage();
  }
}
