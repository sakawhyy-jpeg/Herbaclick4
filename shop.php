<?php
session_start();

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_GET['add'])) {
  $id = $_GET['add'];
  $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
  header('Location: shop.php');
  exit();
}

$count = array_sum($_SESSION['cart']);
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Toko Herbal - HerbaClick</title>
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
    overflow-x: hidden;
  }
  
  /* Header Modern */
  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 8%;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
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
  
  header .logo-area {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  
  header .logo-area img {
    width: 45px;
    height: 45px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    transition: transform 0.3s;
  }
  
  header .logo-area img:hover {
    transform: rotate(360deg) scale(1.1);
  }
  
  header .logo-area h2 {
    margin: 0;
    color: #1e4d2b;
    font-size: 26px;
    font-weight: 800;
    background: linear-gradient(135deg, #2c7a7b, #38a169);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  
  nav {
    display: flex;
    gap: 25px;
    align-items: center;
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
  
  nav a:after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 50%;
    background: #2c7a7b;
    transition: all 0.3s;
  }
  
  nav a:hover:after {
    width: 100%;
    left: 0;
  }
  
  /* Banner Menarik dengan Gradient */
  .banner {
    text-align: center;
    padding: 80px 8% 60px;
    background: linear-gradient(135deg, #38a169 0%, #2c7a7b 100%);
    color: white;
    position: relative;
    overflow: hidden;
  }
  
  .banner:before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
  }
  
  .banner:after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite reverse;
  }
  
  @keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
  }
  
  .banner-content {
    position: relative;
    z-index: 1;
    animation: fadeInUp 0.8s ease;
  }
  
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
  
  .banner h3 {
    margin-bottom: 15px;
    font-size: 38px;
    font-weight: 800;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    letter-spacing: -0.5px;
  }
  
  .banner p {
    font-size: 18px;
    line-height: 1.6;
    max-width: 700px;
    margin: 0 auto;
    text-shadow: 0 1px 3px rgba(0,0,0,0.1);
    font-weight: 300;
  }
  
  .banner .promo-badge {
    display: inline-block;
    background: #fbbf24;
    color: #92400e;
    padding: 8px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    margin-top: 20px;
    box-shadow: 0 4px 15px rgba(251,191,36,0.4);
  }
  
  @keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
  }
  
  /* Section Title */
  .section-header {
    text-align: center;
    padding: 50px 8% 30px;
  }
  
  .section-header h3 {
    color: #2c7a7b;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
  }
  
  .section-header p {
    color: #718096;
    font-size: 16px;
  }
  
  /* Products Grid Modern */
  .products {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 35px;
    padding: 0 8% 80px;
    max-width: 1400px;
    margin: 0 auto;
  }
  
  .product {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    text-align: center;
    position: relative;
    animation: fadeIn 0.6s ease backwards;
  }
  
  .product:nth-child(1) { animation-delay: 0.1s; }
  .product:nth-child(2) { animation-delay: 0.2s; }
  .product:nth-child(3) { animation-delay: 0.3s; }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .product:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 15px 40px rgba(44,122,123,0.2);
  }
  
  .product-image {
    position: relative;
    overflow: hidden;
    height: 220px;
  }
  
  .product img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .product:hover img {
    transform: scale(1.15) rotate(2deg);
  }
  
  .product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    color: white;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(239,68,68,0.4);
    animation: bounce 2s infinite;
  }
  
  
  
  .product-content {
    padding: 25px 20px;
  }
  
  .product h4 {
    color: #2c7a7b;
    margin: 0 0 10px 0;
    font-size: 22px;
    font-weight: 700;
  }
  
  .product .price {
    color: #38a169;
    font-weight: 800;
    font-size: 24px;
    margin: 10px 0;
    display: block;
  }
  
  .product p {
    color: #718096;
    font-size: 14px;
    line-height: 1.6;
    margin: 12px 0 20px;
    min-height: 60px;
  }
  
  .btn {
    display: inline-block;
    background: linear-gradient(135deg, #2b6cb0, #2c7a7b);
    color: white;
    padding: 12px 28px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(44,122,123,0.3);
    position: relative;
    overflow: hidden;
  }
  
  .btn:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }
  
  .btn:hover:before {
    width: 300px;
    height: 300px;
  }
  
  .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(44,122,123,0.4);
  }
  
  .btn span {
    position: relative;
    z-index: 1;
  }
  
  /* Footer Modern */
  footer {
    text-align: center;
    padding: 40px 8%;
    background: linear-gradient(135deg, #2c7a7b, #22543d);
    color: white;
    position: relative;
    overflow: hidden;
  }
  
  footer:before {
    content: '🌿';
    position: absolute;
    font-size: 200px;
    opacity: 0.05;
    top: -50px;
    right: -30px;
   
  }
  
  @keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
  
  footer p {
    margin: 0;
    font-size: 15px;
    position: relative;
    z-index: 1;
  }
  
  footer a {
    color: #a7f3d0;
    text-decoration: none;
    font-weight: 600;
  }
  
  footer a:hover {
    color: white;
    text-decoration: underline;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .banner h3 {
      font-size: 28px;
    }
    .banner p {
      font-size: 16px;
    }
    .products {
      grid-template-columns: 1fr;
      padding: 0 5% 50px;
      gap: 25px;
    }
    header {
      padding: 15px 5%;
    }
    nav {
      gap: 15px;
    }
    nav a {
      font-size: 13px;
      padding: 6px 12px;
    }
  }
</style>
</head>
<body>
<header>
  <div class="logo-area">
    <img src="images/logoherbaclick.png" alt="Logo HerbaClick">
    <h2>HerbaShop</h2>
  </div>
  <nav>
    <a href="index.php">🏠 Home</a>
    <a href="chat.php">💬 Chat</a>
    <a href="chart.php">🛒 Keranjang (<?php echo $count; ?>)</a>
  </nav>
</header>

<section class="banner">
  <div class="banner-content">
    <h3>✨ Minuman Herbal Alami – Sehat dari Alam ✨</h3>
    <p>Rasakan kehangatan rempah dan manfaat alami untuk tubuhmu.</p>
    <span class="promo-badge">🔥 Promo Spesial: Beli 2 Gratis 1!</span>
  </div>
</section>

<div class="section-header">
  <h3>Produk Unggulan Kami</h3>
  <p>Dipilih dengan teliti untuk kesehatan dan kesejahteraan Anda</p>
</div>

<div class="products">
  <div class="product">
    <div class="product-image">
      <img src="images/uwuh.jpg" alt="Wedang Uwuh">
      <div class="product-badge">BEST SELLER</div>
    </div>
    <div class="product-content">
      <h4>Wedang Uwuh</h4>
      <span class="price">Rp 25.000</span>
      <p>Menjaga sistem imun dan meredakan radang tenggorokan dengan kehangatan rempah alami.</p>
      <a href="?add=1" class="btn"><span>🛒 Tambah ke Keranjang</span></a>
    </div>
  </div>

  <div class="product">
    <div class="product-image">
      <img src="images/teh.jpg" alt="Teh Rosella">
      <div class="product-badge">POPULER</div>
    </div>
    <div class="product-content">
      <h4>Teh Rosella</h4>
      <span class="price">Rp 30.000</span>
      <p>Menurunkan tekanan darah dan memperlancar metabolisme tubuh secara alami.</p>
      <a href="?add=2" class="btn"><span>🛒 Tambah ke Keranjang</span></a>
    </div>
  </div>

  <div class="product">
    <div class="product-image">
      <img src="images/kunirasem.jpg" alt="Jamu Kunyit Asam">
      <div class="product-badge">REKOMENDASI</div>
    </div>
    <div class="product-content">
      <h4>Jamu Kunyit Asam</h4>
      <span class="price">Rp 28.000</span>
      <p>Meningkatkan stamina dan menjaga kesehatan wanita dengan resep tradisional.</p>
      <a href="?add=3" class="btn"><span>🛒 Tambah ke Keranjang</span></a>
    </div>
  </div>
</div>

<footer>
  <p>&copy; 2025 <a href="index.php">Toko HerbaClick</a> | Diracik dengan cinta dan rempah alami 🌿</p>
</footer>
</body>
</html>