<?php

session_start();

$host = "localhost"; // Replace with your database host
$user = "root"; // Replace with your database username
$pass = ""; // Replace with your database password
$dbname = "expense"; // Replace with your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];
$month = $_GET["month"];

$sql = "SELECT `income`, `expense` FROM `months` WHERE ID = $user_id and mo_name = '$month'";
// Replace with your own query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $data = $result->fetch_assoc();
  $income = floatval($data["income"]);
  $expense = floatval($data["expense"]);

  // Return data in JSON format
  $response = array("income" => $income, "expense" => $expense);
  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  // Return empty data if no records found
  $response = array("income" => 0, "expense" => 0);
  header('Content-Type: application/json');
  echo json_encode($response);
}

$conn->close();

?>