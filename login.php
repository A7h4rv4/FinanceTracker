<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("select * from userlogin where email = '%s'", $mysqli->real_escape_string($_POST["email"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();
            $_SESSION["user_id"] = $user["ID"];
            header("Location: index.php");
            exit;
        }
    }
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiseWallet-LogIn</title>
    <link rel="stylesheet" href="./css/style1.css">
</head>

<body>
    <div class="container">
        <div class="logo">
            <a href="#">
                <h2>WISE<span>WALLET</span></h2>
            </a></a>
        </div>
        <h3>Log-In</h3>
        <form method="post">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <Button class="getin">Log-In</Button>
        </form>
        <p>Don't have an account?<a href="register.html">register now</a>.</p>
    </div>
</body>

</html>