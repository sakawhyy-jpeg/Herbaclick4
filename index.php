<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

$username = $_SESSION['username'];
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HerbaClick - Konsultasi & Toko Obat Tradisional</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e8f5e9 0%, #f1fff7 50%, #d4f4dd 100%);
      background-attachment: fixed;
      color: #333;
      overflow-x: hidden;
    }

    /* Animated Background Elements */
    .bg-decoration {
      position: fixed;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 0;
      pointer-events: none;
    }

    .leaf {
      position: absolute;
      opacity: 0.15;
      animation: float 20s infinite ease-in-out;
    }

    .leaf1 {
      top: 10%;
      left: 5%;
      font-size: 80px;
      animation-delay: 0s;
    }

    .leaf2 {
      top: 60%;
      right: 8%;
      font-size: 100px;
      animation-delay: 5s;
    }

    .leaf3 {
      bottom: 15%;
      left: 15%;
      font-size: 60px;
      animation-delay: 10s;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) rotate(0deg);
      }
      50% {
        transform: translateY(-30px) rotate(10deg);
      }
    }

    /* Header Modern & Sticky */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 8%;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(15px);
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      position: sticky;
      top: 0;
      z-index: 1000;
      animation: slideDown 0.6s ease;
    }

    @keyframes slideDown {
      from {
        transform: translateY(-100%);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .logo-area {
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
    }

    .logo-area img.logo-img {
      width: 50px;
      height: 50px;
      filter: drop-shadow(0 2px 8px rgba(44,122,123,0.3));
      transition: transform 0.4s ease;
    }

    .logo-area:hover img.logo-img {
      transform: rotate(360deg) scale(1.1);
    }

    .logo-area h1 {
      color: #2c7a7b;
      font-size: 28px;
      margin: 0;
      font-weight: 800;
      background: linear-gradient(135deg, #2c7a7b, #38a169);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 25px;
      position: relative;
    }

    nav a {
      color: #2c7a7b;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      padding: 8px 16px;
      border-radius: 8px;
      transition: all 0.3s;
      position: relative;
    }

    nav a:hover {
      background: #e6fffa;
      color: #22543d;
      transform: translateY(-2px);
    }

    /* Profile Dropdown */
    .profile {
      position: relative;
      cursor: pointer;
    }

    .profile-icon {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #2c7a7b;
      font-weight: 600;
      border: 2px solid #bdecd6;
      padding: 8px 16px;
      border-radius: 25px;
      background: #e6fffa;
      transition: all 0.3s;
      font-size: 14px;
    }

    .profile-icon:hover {
      background: linear-gradient(135deg, #c6f6d5, #b2f5ea);
      border-color: #2c7a7b;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(44,122,123,0.2);
    }

    .profile-icon img {
      width: 24px;
      height: 24px;
      border-radius: 50%;
    }

    .dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 55px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      min-width: 180px;
      overflow: hidden;
      animation: fadeInDropdown 0.3s ease;
    }

    @keyframes fadeInDropdown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .dropdown a {
      display: block;
      padding: 12px 18px;
      color: #2c7a7b;
      text-decoration: none;
      transition: 0.3s;
      font-size: 14px;
    }

    .dropdown a:hover {
      background: #e6fffa;
      padding-left: 25px;
    }

    /* Hero Section */
    .hero {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      padding: 80px 8% 60px;
      gap: 50px;
      position: relative;
      z-index: 1;
    }

    .hero-text {
      flex: 1 1 450px;
      animation: fadeInLeft 0.8s ease;
    }

    @keyframes fadeInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .hero-text h2 {
      font-size: 48px;
      color: #1e4d2b;
      line-height: 1.2;
      margin-bottom: 20px;
      font-weight: 800;
    }

    .hero-text h2 .wave {
      display: inline-block;
      animation: wave 2s infinite;
    }


    .hero-text p {
      line-height: 1.8;
      color: #555;
      margin: 20px 0 30px;
      font-size: 17px;
    }

    .hero-text p b {
      color: #2c7a7b;
      font-weight: 700;
    }

    .hero-buttons {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .hero-buttons a {
      padding: 14px 28px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #2b6cb0, #2c7a7b);
      color: #fff;
      box-shadow: 0 6px 20px rgba(44,122,123,0.35);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(44,122,123,0.45);
    }

    .btn-secondary {
      background: white;
      color: #2c7a7b;
      border: 2px solid #2c7a7b;
    }

    .btn-secondary:hover {
      background: #2c7a7b;
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(44,122,123,0.3);
    }

    .hero-image {
      flex: 1 1 400px;
      position: relative;
      animation: fadeInRight 0.8s ease;
    }

    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .hero-image img {
      width: 100%;
      max-width: 450px;
      border-radius: 30px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    @keyframes floatImage {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }

    /* Stats Section */
    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      padding: 0 8% 60px;
      position: relative;
      z-index: 1;
    }

    .stat-card {
      background: white;
      padding: 25px;
      border-radius: 16px;
      text-align: center;
      box-shadow: 0 5px 20px rgba(0,0,0,0.06);
      transition: all 0.3s;
      animation: fadeInUp 0.6s ease backwards;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .stat-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 30px rgba(44,122,123,0.15);
    }

    .stat-card .icon {
      font-size: 40px;
      margin-bottom: 10px;
    }

    .stat-card h3 {
      font-size: 32px;
      color: #2c7a7b;
      margin: 10px 0 5px;
      font-weight: 800;
    }

    .stat-card p {
      color: #718096;
      font-size: 14px;
    }

    /* Features Section */
    .features {
      padding: 80px 8%;
      background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(230,255,250,0.8));
      backdrop-filter: blur(10px);
      position: relative;
      z-index: 1;
    }

    .features h3 {
      font-size: 38px;
      color: #1e4d2b;
      margin-bottom: 15px;
      text-align: center;
      font-weight: 800;
    }

    .features .subtitle {
      text-align: center;
      color: #718096;
      font-size: 17px;
      margin-bottom: 50px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 30px;
    }

    .card {
      background: white;
      padding: 35px 25px;
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.06);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      text-align: center;
      position: relative;
      overflow: hidden;
    }


    .card:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, #2c7a7b, #38a169);
      transform: scaleX(0);
      transition: transform 0.3s;
    }

    .card:hover:before {
      transform: scaleX(1);
    }

    .card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 15px 40px rgba(44,122,123,0.2);
    }

    .card h4 {
      margin: 20px 0 15px;
      color: #2c7a7b;
      font-size: 22px;
      font-weight: 700;
    }

    .card p {
      color: #718096;
      line-height: 1.7;
      font-size: 14px;
    }

    .card-icon {
      font-size: 50px;
      filter: drop-shadow(0 4px 8px rgba(44,122,123,0.2));
    }

    /* Footer Modern */
    footer {
      text-align: center;
      padding: 40px 8%;
      background: linear-gradient(135deg, #2c7a7b, #22543d);
      color: white;
      font-size: 15px;
      position: relative;
      overflow: hidden;
    }

    footer:before {
      content: '🌿';
      position: absolute;
      font-size: 250px;
      opacity: 0.05;
      top: -80px;
      right: -50px;
      animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    footer p {
      margin: 0;
      position: relative;
      z-index: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
      header {
        padding: 15px 5%;
      }

      .hero {
        padding: 50px 5% 40px;
      }

      .hero-text h2 {
        font-size: 32px;
      }

      .hero-text p {
        font-size: 15px;
      }

      .features h3 {
        font-size: 28px;
      }

      .stats, .grid {
        grid-template-columns: 1fr;
      }

      nav {
        gap: 15px;
      }

      nav a {
        font-size: 13px;
        padding: 6px 12px;
      }

      .hero-buttons {
        flex-direction: column;
      }

      .hero-buttons a {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
<!-- Animated Background -->
<div class="bg-decoration">
  <div class="leaf leaf1">🌿</div>
  <div class="leaf leaf2">🍃</div>
  <div class="leaf leaf3">🌱</div>
</div>

<header>
  <div class="logo-area">
    <img src="images/logoherbaclick.png" alt="Logo HerbaClick" class="logo-img">
    <h1>HerbaClick!</h1>
  </div>
  <nav>
    <a href="index.php">🏠 Home</a>
    <a href="shop.php">🛍️ Toko</a>
    <a href="chat.php">💬 Chat</a>
    <div class="profile" id="profileMenu">
      <div class="profile-icon">
        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077063.png" alt="User Icon">
        <?php echo htmlspecialchars($username); ?>
      </div>
      <div class="dropdown" id="dropdownMenu">
        <a href="profile.php">👤 Profil Saya</a>
        <a href="logout.php" style="color:#e53e3e;">🚪 Logout</a>
      </div>
    </div>
  </nav>
</header>

<section class="hero">
  <div class="hero-text">
    <h2>Halo, <?php echo htmlspecialchars($username); ?>! <span class="wave">👋</span></h2>
    <p>Selamat datang kembali di <b>HerbaClick!</b> — tempat terbaik untuk konsultasi herbal dan belanja produk alami terpercaya. Dapatkan solusi kesehatan alami hanya dalam satu klik!</p>
    <div class="hero-buttons">
      <a href="chat.php" class="btn-primary">
        💬 Mulai Konsultasi
      </a>
      <a href="shop.php" class="btn-secondary">
        🛒 Kunjungi Toko
      </a>
    </div>
  </div>
  <div class="hero-image">
    <img src="images/logoherbaclick.png" alt="Herbal Illustration">
  </div>
</section>

<!-- Stats Section -->
<section class="stats">
  <div class="stat-card">
    <div class="icon">👥</div>
    <h3>5000+</h3>
    <p>Pengguna Aktif</p>
  </div>
  <div class="stat-card">
    <div class="icon">💬</div>
    <h3>10K+</h3>
    <p>Konsultasi Selesai</p>
  </div>
  <div class="stat-card">
    <div class="icon">🌿</div>
    <h3>50+</h3>
    <p>Produk Herbal</p>
  </div>
  <div class="stat-card">
    <div class="icon">⭐</div>
    <h3>4.9</h3>
    <p>Rating Kepuasan</p>
  </div>
</section>

<section class="features">
  <h3>Mengapa Memilih HerbaClick?</h3>
  <p class="subtitle">Solusi kesehatan alami terpercaya di ujung jari Anda</p>
  <div class="grid">
    <div class="card">
      <div class="card-icon">🌱</div>
      <h4>Konsultasi Instan</h4>
      <p>Konsultasi langsung dengan ahli herbal tanpa antri. Jawaban cepat dan solusi alami untuk keluhan Anda kapan saja, di mana saja.</p>
    </div>
    <div class="card">
      <div class="card-icon">🛍️</div>
      <h4>Belanja Aman</h4>
      <p>Produk herbal terjamin dan terpercaya. Setiap produk melalui proses kurasi ketat oleh tenaga ahli untuk kualitas terbaik.</p>
    </div>
    <div class="card">
      <div class="card-icon">📦</div>
      <h4>Pengiriman Cepat</h4>
      <p>Pesanan dikirim langsung dari toko mitra terdekat agar sampai lebih cepat, aman, dan produk tetap segar.</p>
    </div>
    <div class="card">
      <div class="card-icon">🎓</div>
      <h4>Edukasi Herbal</h4>
      <p>Tonton video dan artikel edukatif tentang pengolahan jamu, manfaat rempah, dan kesehatan tradisional Indonesia.</p>
    </div>
  </div>
</section>

<footer>
  <p>&copy; <?php echo date('Y'); ?> HerbaClick • Sehat alamimu ada di genggamanmu 🌱</p>
</footer>

<script>
  const profileMenu = document.getElementById('profileMenu');
  const dropdown = document.getElementById('dropdownMenu');

  profileMenu.addEventListener('click', (e) => {
    e.stopPropagation();
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', (e) => {
    if (!profileMenu.contains(e.target)) {
      dropdown.style.display = 'none';
    }
  });
</script>
</body>
</html>