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

$sql = "SELECT `t_name` FROM `transactions` WHERE ID = $user_id and `month` = '$month'";
// Replace with your own query
$result = $conn->query($sql);

$t_names = array();
while ($row = $result->fetch_assoc()) {
    $t_names[] = $row["t_name"];
}

// Return data in JSON format
$response = array("t_names" => $t_names);
echo json_encode($response);

$conn->close();

?>