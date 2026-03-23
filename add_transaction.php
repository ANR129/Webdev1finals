<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['category_id']) || empty($_POST['category_id'])) {
        die("<p class='error'>Please select a category.</p>");
    }

    $category_id = (int) $_POST['category_id'];
    $amount = (float) $_POST['amount'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date = $_POST['date'];

    $cat_check = mysqli_query($conn, "SELECT id FROM categories WHERE id = $category_id AND user_id = $user_id");
    if (mysqli_num_rows($cat_check) == 0) {
        die("<p class='error'>Invalid category selected. Please add categories first.</p>");
    }

    $sql = "INSERT INTO transactions (user_id, category_id, amount, description, date)
            VALUES ($user_id, $category_id, $amount, '$description', '$date')";

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
  <title>Add Transaction</title>
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
  <h2>Add Transaction</h2>

  <form method="post">
    Amount: <input type="number" step="0.01" name="amount" required>
    Description: <input type="text" name="description">
    Date: <input type="date" name="date" required>

    Category:
    <select name="category_id" required>
      <option value="">-- Select Category --</option>
      <?php
      $result = mysqli_query($conn, "SELECT id, name FROM categories WHERE user_id=$user_id");
      if (mysqli_num_rows($result) == 0) {
          echo "<option disabled>No categories available</option>";
      }
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='{$row['id']}'>{$row['name']}</option>";
      }
      ?>
    </select>

    <button type="submit">Add</button>
  </form>

  <a href="manage_categories.php"> Manage Categories</a>
</div>
</body>
</html>

