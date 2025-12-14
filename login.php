<?php
session_start();

// Kalau sudah login, langsung ke home
if (isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

// Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $phone = $_POST['phone'];
  $password = $_POST['password'];

  if (file_exists("users.json")) {
    $users = json_decode(file_get_contents("users.json"), true);

    if (isset($users[$phone]) && password_verify($password, $users[$phone]['password'])) {
      $_SESSION['username'] = $users[$phone]['username'];
      header('Location: index.php');
      exit();
    } else {
      $error = "❌ Nomor HP atau password salah!";
    }
  } else {
    $error = "Belum ada akun terdaftar. Silakan daftar dulu.";
  }
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login - HerbaClick</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #b2f5ea, #c6f6d5);
    height: 100vh; display: flex; justify-content: center; align-items: center;
  }
  .login-box {
    background: rgba(255,255,255,0.9);
    padding: 40px; border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    text-align: center; width: 340px;
  }
  .login-box img { width: 80px; margin-bottom: 10px; }
  h2 { color: #22543d; }
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
  <div class="login-box">
    <img src="images/logoherbaclick.png" style= "width: 200px; height: auto;">
    <h2>🔐 Login HerbaClick</h2>
    <p style="color:#2f855a;">Sehat alamimu ada di genggamanmu 🌿</p>

    <?php if (isset($_GET['registered'])) echo "<p style='color:green;'>✅ Akun berhasil dibuat! Silakan login.</p>"; ?>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
      <input type="text" name="phone" placeholder="Nomor HP" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Masuk</button>
    </form>

    <p style="margin-top:12px;">Belum punya akun? <a href="sign in.php">Daftar di sini</a></p>
  </div>
</body>
</html>
