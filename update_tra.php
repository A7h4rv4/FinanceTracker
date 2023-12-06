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
$id = $data['t_id'];
$txt = $data['txt'];
$amt = $data['amt'];
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
    $stmt = $db->prepare("INSERT INTO `transactions`(`ID`, `month`, `t_id`, `t_name`, `t_amount`) VALUES (:user_id, :mont, :id, :txt, :amt)");
    $stmt->bindParam(':user_id', $_SESSION["user_id"]);
    $stmt->bindParam(':txt', $txt);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':amt', $amt);
    $stmt->bindParam(':mont', $month);
    $stmt->execute();

    echo 'Data updated successfully';
} catch (PDOException $e) {
    echo 'Error updating data: ' . $e->getMessage();
}

?>