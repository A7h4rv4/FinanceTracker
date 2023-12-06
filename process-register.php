<?php

if (empty($_POST["name"])) {
    die("Name is Required.");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Enter valid E-mail");
}

if (strlen($_POST["password"] < 8)) {
    die("Password should be atleast 8 characters.");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password should be atleast 1 letter.");
}

if (!preg_match("/[0-9]/i", $_POST["password"])) {
    die("Password should be atleast 1 digit.");
}

if ($_POST["password"] !== $_POST["password_confirm"]) {
    die("passwords must match.");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "insert into userlogin (name, email, password_hash) values(?, ?, ?);";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

if ($stmt->execute()) {
    $user_id = $mysqli->insert_id; // get the auto-generated ID of the inserted user
    $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $sql = "INSERT INTO months (ID, mo_name, income, expense) VALUES (?, ?, 0, 0)";
    $stmt = $mysqli->prepare($sql);
    foreach ($months as $month) {
        $stmt->bind_param("is", $user_id, $month);
        $stmt->execute();
    }
    header("Location: login.php");
    exit;
} else {
    die($mysqli->error . " " . $mysqli->errno);
}


?>