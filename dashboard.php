<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$income = 0;
$expense = 0;
$goal = 0;

$result = mysqli_query($conn, "SELECT SUM(amount) AS total FROM transactions WHERE user_id=$user_id AND category_id IN (SELECT id FROM categories WHERE type='income')");
if ($row = mysqli_fetch_assoc($result)) {
    $income = $row['total'] ?? 0;
}

$result = mysqli_query($conn, "SELECT SUM(amount) AS total FROM transactions WHERE user_id=$user_id AND category_id IN (SELECT id FROM categories WHERE type='expense')");
if ($row = mysqli_fetch_assoc($result)) {
    $expense = $row['total'] ?? 0;
}

$month = date('Y-m');
$result = mysqli_query($conn, "SELECT goal_amount FROM savings_goals WHERE user_id=$user_id AND month_year='$month'");
if ($row = mysqli_fetch_assoc($result)) {
    $goal = $row['goal_amount'] ?? 0;
}

$net = $income - $expense;
$remaining = $goal - $net;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <style>
body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f4f6f9;
  margin: 0;
  padding: 0;
}
.container {
  max-width: 500px;
  margin: 40px auto;
  background-color: #ffffff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
}
h2, h3 {
  text-align: center;
  color: #2c3e50;
  margin-bottom: 20px;
}
label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}
input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"],
input[type="date"],
select,
textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  box-sizing: border-box;
}
button {
  background-color: #3498db;
  color: white;
  padding: 12px;
  width: 100%;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
}
button:hover {
  background-color: #2980b9;
}
a {
  color: #2980b9;
  text-decoration: none;
  display: inline-block;
  margin-top: 10px;
  margin-right: 15px;
}
a:hover {
  text-decoration: underline;
}
.error {
  color: #e74c3c;
  background-color: #ffe0e0;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 5px;
  font-weight: bold;
}
.success {
  color: #27ae60;
  background-color: #e0ffe0;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 5px;
}
ul {
  list-style-type: none;
  padding: 0;
}
ul li {
  padding: 10px;
  background-color: #f1f1f1;
  border-radius: 5px;
  margin-bottom: 8px;
}
</style>
</head>
<body>
<div class="container">
  <h2>Dashboard</h2>
  <p>Total Income: ₱<?= number_format($income, 2) ?></p>
  <p>Total Expenses: ₱<?= number_format($expense, 2) ?></p>
  <p>Net Savings: ₱<?= number_format($net, 2) ?></p>
  <p>Savings Goal: ₱<?= number_format($goal, 2) ?></p>
  <p>Remaining to Save: ₱<?= number_format($remaining, 2) ?></p>

  <a href="add_transaction.php"> Add Transaction</a><br>
  <a href="set_goal.php"> Set Monthly Goal</a><br>
  <a href="manage_categories.php">🗂️ Manage Categories</a><br>
  <a href="logout.php"> Logout</a>
</div>
</body>
</html>


