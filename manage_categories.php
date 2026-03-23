<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = $_POST['type'];

    $sql = "INSERT INTO categories (user_id, name, type)
            VALUES ($user_id, '$name', '$type')";

    if (!mysqli_query($conn, $sql)) {
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
    } else {
        echo "<p class='success'>Category added successfully.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Categories</title>
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
  <h2>Manage Categories</h2>

  <form method="post">
    Name: <input type="text" name="name" required>
    Type:
    <select name="type" required>
      <option value="income">Income</option>
      <option value="expense">Expense</option>
    </select>
    <button type="submit">Add Category</button>
  </form>

  <h3>Your Categories</h3>
  <ul>
    <?php
    $result = mysqli_query($conn, "SELECT name, type FROM categories WHERE user_id=$user_id");
    if (mysqli_num_rows($result) == 0) {
        echo "<li class='error'>No categories found. Add some!</li>";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>{$row['name']} ({$row['type']})</li>";
    }
    ?>
  </ul>
  <a href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>

</ul>


