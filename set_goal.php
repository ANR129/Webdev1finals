<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$month = date('Y-m');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goal = (float) $_POST['goal_amount'];

    $check = mysqli_query($conn, "SELECT id FROM savings_goals WHERE user_id = $user_id AND month_year = '$month'");
    if (mysqli_num_rows($check) > 0) {
        $sql = "UPDATE savings_goals SET goal_amount = $goal WHERE user_id = $user_id AND month_year = '$month'";
    } else {
        $sql = "INSERT INTO savings_goals (user_id, month_year, goal_amount)
                VALUES ($user_id, '$month', $goal)";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Set Monthly Goal</title>
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
  <h2>Set Monthly Savings Goal</h2>

  <form method="post">
    Goal Amount (₱): <input type="number" name="goal_amount" step="0.01" required>
    <button type="submit">Save Goal</button>
  </form>

  <a href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>


