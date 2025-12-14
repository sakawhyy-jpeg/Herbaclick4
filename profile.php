<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

$username = $_SESSION['username'];
$usersFile = "users.json";
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

# Temukan data pengguna berdasarkan username
$foundUser = null;
foreach ($users as $phone => $data) {
  if ($data['username'] === $username) {
    $foundUser = &$users[$phone];
    $userPhone = $phone;
    break;
  }
}

if (!$foundUser) {
  echo "❌ Data pengguna tidak ditemukan.";
  exit();
}

# Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Upload foto profil
  if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir);

    $fileName = uniqid() . "_" . basename($_FILES["photo"]["name"]);
    $targetFile = $targetDir . $fileName;

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "gif"];

    if (in_array($fileType, $allowed)) {
      move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);
      $foundUser['photo'] = $targetFile;
    }
  }

  // Update lokasi
  if (!empty($_POST["location"])) {
    $foundUser['location'] = htmlspecialchars($_POST["location"]);
  }

  // Simpan kembali ke file users.json
  file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
  $success = "✅ Profil berhasil diperbarui!";
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Profil Saya - HerbaClick</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e8fff2, #b2f5ea);
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }

  .profile-box {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    text-align: center;
    width: 400px;
  }

  .profile-box img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #bdecd6;
    margin-bottom: 10px;
  }

  .profile-box h2 {
    color: #22543d;
    margin-bottom: 4px;
  }

  .profile-box p {
    color: #2c7a7b;
    margin-top: 0;
    margin-bottom: 20px;
  }

  input[type="file"], input[type="text"] {
    width: 90%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #bdecd6;
    margin: 10px 0;
    outline: none;
    font-family: inherit;
  }

  button {
    background: linear-gradient(90deg, #2b6cb0, #2c7a7b);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    width: 100%;
  }

  button:hover {
    transform: scale(1.05);
  }

  .success {
    color: green;
    font-size: 0.9em;
    margin-bottom: 10px;
  }

  .back {
    display: inline-block;
    margin-top: 20px;
    color: #2c7a7b;
    text-decoration: none;
    font-weight: 600;
  }
</style>
</head>

<body>
  <div class="profile-box">
    <?php if (!empty($foundUser['photo'])): ?>
      <img src="<?php echo htmlspecialchars($foundUser['photo']); ?>" alt="Foto Profil">
    <?php else: ?>
      <img src="https://cdn-icons-png.flaticon.com/512/1077/1077063.png" alt="Default Profile">
    <?php endif; ?>

    <h2><?php echo htmlspecialchars($username); ?></h2>
    <p>📱 <?php echo htmlspecialchars($userPhone); ?></p>
    <?php if (!empty($foundUser['location'])): ?>
      <p>📍 <?php echo htmlspecialchars($foundUser['location']); ?></p>
    <?php else: ?>
      <p style="color:#999;">Belum ada lokasi</p>
    <?php endif; ?>

    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="photo" accept="image/*"><br>
      <input type="text" name="location" placeholder="Masukkan lokasi kamu (contoh: Yogyakarta)">
      <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="index.php" class="back">⬅️ Kembali ke Beranda</a>
  </div>
</body>
</html>
