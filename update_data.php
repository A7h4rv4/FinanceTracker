<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo "User not authenticated";
    exit;
}

// retrieve POST data
$data = json_decode(file_get_contents('php://input'), true);

// extract inc and exp data
$inc = $data['inc'];
$exp = $data['exp'];
$month = $data['month'];

// connect to database
$host = 'localhost';
$dbname = 'expense';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // update inc and exp for user ID
    $stmt = $db->prepare("UPDATE `months` SET `income` = :inc, `expense` = :exp WHERE `ID` = :user_id AND `mo_name` = :month");
    $stmt->bindParam(':user_id', $_SESSION["user_id"]);
    $stmt->bindParam(':inc', $inc);
    $stmt->bindParam(':exp', $exp);
    $stmt->bindParam(':month', $month);
    $stmt->execute();

    echo 'Data updated successfully';
} catch (PDOException $e) {
    echo 'Error updating data: ' . $e->getMessage();
}

?>