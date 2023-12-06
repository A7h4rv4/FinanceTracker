<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WiseWalletHome</title>
  <link rel="stylesheet" href="./css/style2.css">
  <link rel="stylesheet" href="./css/styles.css">
  <style>
    .main {
      position: relative;
    }
  </style>
</head>

<body>
  <?php if (isset($_SESSION["user_id"])): ?>
    <header class="header">
      <div class="logo">
        <a href="#">
          <h2>WISE<span>WALLET</span></h2>
        </a></a>
      </div>
      <div class="navigation">
        <ul>
          <li><button class="navbtn"><a href="#">Home</a></button></li>
          <li><button class="navbtn"><a href="./analysis.php">Analysis</a></button></li>
          <li><button class="navbtn"><a href="./recom.php">Recomm..</a></button></li>
        </ul>
      </div>
      <div class="account">
        <ul>
          <li><button class="navbtn"><a href="logout.php">Log-Out</a></button></li>
        </ul>
      </div>
    </header>
    <div class="monthselect">
      <select name="months" id="months">
        <option value="--Select-Month--">Select-Month</option>
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
      </select>
      <button type="submit" id="sub">Submit</button>
    </div>
    <div class="main">
      <div class="container">
        <h4>Your Balance</h4>
        <h1 id="balance">$0.00</h1>
        <div class="inc-exp-container">
          <div>
            <h4>Income</h4>
            <p id="money-plus" class="money-plus">
              +$0.00
            </p>
          </div>
          <div>
            <h4>Expense</h4>
            <p id="money-minus" class="money-minus">
              -$0.00
            </p>
          </div>
        </div>
        <div class="hist">
          <h3>History</h3>
          <ul id="list" class="list">
          </ul>
        </div>
        <h3>Add New Transaction</h3>
        <form id="form">
          <div class="form-control">
            <label for="text">Text</label>
            <input type="text" id="text" placeholder="Enter Text...." />
          </div>
          <div class="form-control">
            <label for="amount">Amount <br> (negative - expense ,positive - income )</label>
            <input type="number" id="amount" placeholder="Enter amount...">
          </div>
          <button class="sub">Submit Transaction</button>
        </form>
      </div>
      <div class="chart"></div>
    </div>
  <?php else: ?>
    <?php

    header("Location: login.php");
    ?>
  <?php endif; ?>
  <script src="./js/chart.js"></script>
  <script src="./js/bud.js"></script>
</body>

</html>