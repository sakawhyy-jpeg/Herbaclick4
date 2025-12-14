<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (!file_exists("users.json")) {
    file_put_contents("users.json", json_encode([]));
  }

  $users = json_decode(file_get_contents("users.json"), true);

  if (isset($users[$phone])) {
    $error = "Nomor ini sudah terdaftar!";
  } else {
    $users[$phone] = [
      'username' => $username,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
    header("Location: login.php?registered=true");
    exit();
  }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Sign In - HerbaClick</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #b2f5ea, #c6f6d5);
    height: 100vh; display: flex; justify-content: center; align-items: center;
  }
  .box {
    background: rgba(255,255,255,0.9);
    padding: 40px; border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    text-align: center; width: 350px;
  }
  input {
    width: 90%; padding: 12px; border-radius: 10px;
    border: 1px solid #bdecd6; margin: 8px 0; outline: none;
  }
  button {
    width: 100%; padding: 12px; border: none; border-radius: 10px;
    background: linear-gradient(90deg, #2b6cb0, #2c7a7b);
    color: white; font-weight: 600; cursor: pointer;
  }
  button:hover { transform: scale(1.05); }
  .error { color: red; font-size: 0.9em; }
  a { color:#2c7a7b; text-decoration:none; font-weight:600; }
</style>
</head>
<body>
<div class="box">
  <img src="images/logoherbaclick.png" style= "width: 200px; height: auto;"><br>
  <h2> Daftar HerbaClick</h2>
  <p style="color:#2f855a;">Sehat alamimu dimulai di sini</p>

  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

  <form method="POST">
    <input type="text" name="phone" placeholder="Nomor HP" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Daftar Sekarang</button>
  </form>

  <p style="margin-top:12px;">Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</body>
</html>
