<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
  <h2>User Login</h2>

  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

  <form method="post">
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>

  <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</div>
</body>
</html>
