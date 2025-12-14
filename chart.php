<?php
session_start();

// Debug: Uncomment baris ini untuk cek session
// echo "<pre>"; print_r($_SESSION); echo "</pre>";

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

$products = [
  1 => ["Wedang Uwuh", "Menjaga sistem imun dan meredakan radang tenggorokan.", "images/uwuh.jpg", 25000],
  2 => ["Teh Rosella", "Menurunkan tekanan darah dan memperlancar metabolisme tubuh.", "images/teh.jpg", 30000],
  3 => ["Jamu Kunyit Asam", "Meningkatkan stamina dan menjaga kesehatan wanita.", "images/kunirasem.jpg", 28000]
];

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Hapus item
if (isset($_GET['remove'])) {
  $id = intval($_GET['remove']);
  unset($_SESSION['cart'][$id]);
  header('Location: chart.php');
  exit();
}

// Kosongkan keranjang
if (isset($_GET['clear'])) {
  $_SESSION['cart'] = [];
  header('Location: chart.php');
  exit();
}

// Hitung total
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
  if (isset($products[$id])) {
    $total += $products[$id][3] * $qty;
  }
}

$count = array_sum($_SESSION['cart']);
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Keranjang - HerbaClick</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: linear-gradient(120deg, #e8f5e9, #f1fff7);
    min-height: 100vh;
  }
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

  .cart-container {
    padding: 50px 8%;
    max-width: 1400px;
    margin: 0 auto;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border-radius: 12px;
    overflow: hidden;
  }
  th, td {
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid #f1f1f1;
  }
  th { 
    background: #2c7a7b; 
    color: white;
    font-weight: 600;
  }
  img {
    width: 80px; 
    height: 80px; 
    object-fit: cover; 
    border-radius: 10px;
  }
  .btn {
    padding: 10px 18px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
    display: inline-block;
    cursor: pointer;
    border: none;
    font-size: 14px;
  }
  .btn-danger {
    background: #e53e3e; 
    color: white;
  }
  .btn-danger:hover {
    background: #c53030;
    transform: scale(1.05);
  }
  .btn-primary {
    background: linear-gradient(90deg, #2b6cb0, #2c7a7b);
    color: white;
  }
  .btn-primary:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(44,122,123,0.3);
  }
  .btn-success {
    background: linear-gradient(90deg, #38a169, #2f855a);
    color: white;
    font-size: 16px;
    padding: 14px 28px;
  }
  .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(56,161,105,0.3);
  }
  .actions {
    display: flex; 
    justify-content: space-between; 
    margin-top: 20px;
    flex-wrap: wrap;
    gap: 10px;
  }
  .total-section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    margin-top: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    text-align: right;
  }
  .total-section h3 {
    color: #2c7a7b;
    margin: 0 0 15px 0;
  }
  .total-amount {
    font-size: 32px;
    font-weight: 700;
    color: #22543d;
    margin-bottom: 15px;
  }
  .empty-cart {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  }
  .empty-cart h3 {
    color: #2c7a7b;
    font-size: 24px;
    margin-bottom: 20px;
  }
</style>
</head>
<body>
<header>
  <h2>🛒 Keranjang HerbaShop</h2>
  <nav>
    <a href="index.php">🏠Home</a> |
    <a href="shop.php">🛍️Toko</a> |
    <a href="chat.php">💬Chat</a> |
  </nav>
</header>

<div class="cart-container">
  <?php if (empty($_SESSION['cart'])): ?>
    <div class="empty-cart">
      <h3>🛒 Keranjang Anda Kosong</h3>
      <p style="color: #666; margin-bottom: 20px;">Yuk, mulai belanja produk herbal berkualitas!</p>
      <a href="shop.php" class="btn btn-primary">🛍️ Mulai Belanja</a>
    </div>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Produk</th>
          <th>Nama</th>
          <th>Deskripsi</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
          <?php if (isset($products[$id])): ?>
            <?php $subtotal = $products[$id][3] * $qty; ?>
            <tr>
              <td><img src="<?= $products[$id][2] ?>" alt="<?= $products[$id][0] ?>"></td>
              <td><b><?= $products[$id][0] ?></b></td>
              <td><?= $products[$id][1] ?></td>
              <td>Rp <?= number_format($products[$id][3], 0, ',', '.') ?></td>
              <td><?= $qty ?></td>
              <td><b>Rp <?= number_format($subtotal, 0, ',', '.') ?></b></td>
              <td><a href="?remove=<?= $id ?>" class="btn btn-danger" onclick="return confirm('Hapus produk ini dari keranjang?')">Hapus</a></td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
    
    <div class="total-section">
      <h3>💰 Total Belanja</h3>
      <div class="total-amount">Rp <?= number_format($total, 0, ',', '.') ?></div>
      <a href="payment.php" class="btn btn-success">✅ Lanjut ke Pembayaran</a>
    </div>

    <div class="actions">
      <a href="shop.php" class="btn btn-primary">⬅️ Lanjut Belanja</a>
      <a href="?clear=1" class="btn btn-danger" onclick="return confirm('Kosongkan seluruh keranjang?')">🗑️ Kosongkan Keranjang</a>
    </div>
  <?php endif; ?>
</div>

<script>
// Debug: Tampilkan jika ada error
window.addEventListener('error', function(e) {
  console.error('Error:', e.message);
});
</script>
</body>
</html>