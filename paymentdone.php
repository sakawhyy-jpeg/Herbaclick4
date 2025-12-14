<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['last_order'])) {
  header('Location: index.php');
  exit();
}

$order = $_SESSION['last_order'];
$order_id = 'HBC' . date('Ymd') . rand(1000, 9999);

$payment_methods = [
  'transfer' => 'Transfer Bank',
  'cod' => 'COD (Bayar di Tempat)',
  'ewallet' => 'E-Wallet'
];

$products = [
  1 => ["Wedang Uwuh", "images/uwuh.jpg"],
  2 => ["Teh Rosella", "images/teh.jpg"],
  3 => ["Jamu Kunyit Asam", "images/kunirasem.jpg"]
];
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pesanan Berhasil - HerbaClick</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(120deg, #e8f5e9, #f1fff7);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  .success-container {
    max-width: 700px;
    width: 100%;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12);
    animation: slideUp 0.6s ease;
  }
  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  .success-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #38a169, #2f855a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    animation: scaleIn 0.5s ease 0.2s backwards;
    box-shadow: 0 8px 20px rgba(56,161,105,0.3);
  }
  .success-icon::before {
    content: '✓';
    font-size: 60px;
    color: white;
    font-weight: bold;
  }
  @keyframes scaleIn {
    from { 
      transform: scale(0) rotate(-180deg);
      opacity: 0;
    }
    to { 
      transform: scale(1) rotate(0deg);
      opacity: 1;
    }
  }
  h1 {
    color: #2c7a7b;
    margin-bottom: 10px;
    font-size: 32px;
    text-align: center;
  }
  .subtitle {
    color: #718096;
    margin-bottom: 30px;
    text-align: center;
    font-size: 16px;
  }
  .order-id-box {
    background: linear-gradient(135deg, #e6fffa, #c6f6d5);
    padding: 20px;
    border-radius: 14px;
    text-align: center;
    margin: 25px 0;
    border: 2px dashed #2c7a7b;
  }
  .order-id-label {
    color: #2c5282;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .order-id-value {
    color: #2c7a7b;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 2px;
  }
  .info-section {
    background: #f7fafc;
    padding: 25px;
    border-radius: 14px;
    margin: 20px 0;
  }
  .section-title {
    color: #2c7a7b;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
  }
  .info-row:last-child {
    border-bottom: none;
  }
  .info-label {
    color: #718096;
    font-size: 14px;
    font-weight: 500;
  }
  .info-value {
    color: #2d3748;
    font-weight: 600;
    text-align: right;
    max-width: 60%;
  }
  .order-items {
    margin-top: 15px;
  }
  .order-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: white;
    border-radius: 10px;
    margin-bottom: 10px;
  }
  .order-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
  }
  .item-details {
    flex: 1;
  }
  .item-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 14px;
  }
  .item-qty {
    font-size: 12px;
    color: #718096;
  }
  .payment-info {
    background: #fffbeb;
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #f59e0b;
    margin: 20px 0;
  }
  .payment-info strong {
    color: #92400e;
    display: block;
    margin-bottom: 12px;
    font-size: 16px;
  }
  .payment-info ul {
    margin-left: 20px;
    color: #92400e;
    font-size: 14px;
    line-height: 1.8;
  }
  .payment-info li {
    margin: 6px 0;
  }
  .button-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-top: 30px;
  }
  .btn {
    padding: 15px 24px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 15px;
    text-align: center;
  }
  .btn-primary {
    background: linear-gradient(135deg, #2b6cb0, #2c7a7b);
    color: white;
    box-shadow: 0 4px 12px rgba(44,122,123,0.3);
  }
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44,122,123,0.4);
  }
  .btn-success {
    background: linear-gradient(135deg, #38a169, #2f855a);
    color: white;
    box-shadow: 0 4px 12px rgba(56,161,105,0.3);
  }
  .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(56,161,105,0.4);
  }
  .contact-info {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid #e2e8f0;
  }
  .contact-info p {
    color: #718096;
    font-size: 14px;
    line-height: 1.8;
  }
  .contact-info strong {
    color: #2c7a7b;
  }
  .total-highlight {
    background: #e6fffa;
    padding: 15px;
    border-radius: 10px;
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .total-highlight .label {
    color: #2c5282;
    font-weight: 600;
    font-size: 16px;
  }
  .total-highlight .value {
    color: #2c7a7b;
    font-weight: 700;
    font-size: 22px;
  }
  @media (max-width: 600px) {
    .button-group {
      grid-template-columns: 1fr;
    }
    .success-container {
      padding: 25px;
    }
    h1 {
      font-size: 26px;
    }
    .order-id-value {
      font-size: 22px;
    }
  }
</style>
</head>
<body>
<div class="success-container">
  <div class="success-icon"></div>
  
  <h1>🎉 Pesanan Berhasil!</h1>
  <p class="subtitle">Terima kasih telah berbelanja di HerbaClick. Pesanan Anda sedang diproses.</p>
  
  <div class="order-id-box">
    <div class="order-id-label">Nomor Pesanan</div>
    <div class="order-id-value"><?= $order_id ?></div>
  </div>
  
  <!-- Informasi Pengiriman -->
  <div class="info-section">
    <div class="section-title">📦 Informasi Pengiriman</div>
    <div class="info-row">
      <span class="info-label">Nama Penerima</span>
      <span class="info-value"><?= htmlspecialchars($order['nama']) ?></span>
    </div>
    <div class="info-row">
      <span class="info-label">No. Telepon</span>
      <span class="info-value"><?= htmlspecialchars($order['telepon']) ?></span>
    </div>
    <div class="info-row">
      <span class="info-label">Alamat Pengiriman</span>
      <span class="info-value"><?= htmlspecialchars($order['alamat']) ?></span>
    </div>
    <div class="info-row">
      <span class="info-label">Metode Pembayaran</span>
      <span class="info-value"><?= $payment_methods[$order['payment']] ?></span>
    </div>
  </div>
  
  <!-- Detail Pesanan -->
  <div class="info-section">
    <div class="section-title">🛍️ Detail Pesanan</div>
    <div class="order-items">
      <?php foreach ($order['items'] as $id => $qty): ?>
        <?php if (isset($products[$id])): ?>
          <div class="order-item">
            <img src="<?= $products[$id][1] ?>" alt="<?= $products[$id][0] ?>">
            <div class="item-details">
              <div class="item-name"><?= $products[$id][0] ?></div>
              <div class="item-qty">Jumlah: <?= $qty ?> pcs</div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
    
    <div class="total-highlight">
      <span class="label">Total Pembayaran</span>
      <span class="value">Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
    </div>
  </div>
  
  <!-- Instruksi Pembayaran -->
  <?php if ($order['payment'] === 'transfer'): ?>
  <div class="payment-info">
    <strong>📋 Instruksi Transfer Bank</strong>
    <ul>
      <li><strong>Bank BCA:</strong> 1234567890 a.n. HerbaClick</li>
      <li><strong>Bank Mandiri:</strong> 0987654321 a.n. HerbaClick</li>
      <li><strong>Bank BNI:</strong> 5678901234 a.n. HerbaClick</li>
      <li>Transfer sesuai nominal: <strong>Rp <?= number_format($order['total'], 0, ',', '.') ?></strong></li>
      <li>Konfirmasi pembayaran via WhatsApp: <strong>0812-3456-7890</strong></li>
    </ul>
  </div>
  <?php elseif ($order['payment'] === 'ewallet'): ?>
  <div class="payment-info">
    <strong>📱 Instruksi E-Wallet</strong>
    <ul>
      <li><strong>GoPay / OVO / DANA:</strong> 0812-3456-7890</li>
      <li><strong>ShopeePay:</strong> 0812-3456-7890</li>
      <li>Transfer sesuai nominal: <strong>Rp <?= number_format($order['total'], 0, ',', '.') ?></strong></li>
      <li>Konfirmasi pembayaran via WhatsApp: <strong>0812-3456-7890</strong></li>
      <li>Sertakan nomor pesanan: <strong><?= $order_id ?></strong></li>
    </ul>
  </div>
  <?php else: ?>
  <div class="payment-info">
    <strong>🚚 Informasi COD (Cash on Delivery)</strong>
    <ul>
      <li>Pesanan akan dikirim dalam <strong>1-2 hari kerja</strong></li>
      <li>Bayar langsung kepada kurir saat barang tiba</li>
      <li>Siapkan uang pas: <strong>Rp <?= number_format($order['total'], 0, ',', '.') ?></strong></li>
      <li>Pastikan ada yang menerima di alamat pengiriman</li>
      <li>Cek kondisi paket sebelum membayar</li>
    </ul>
  </div>
  <?php endif; ?>
  
  <!-- Tombol Aksi -->
  <div class="button-group">
    <a href="index.php" class="btn btn-primary">
      🏠 Kembali ke Home
    </a>
    <a href="shop.php" class="btn btn-success">
      🛍️ Belanja Lagi
    </a>
  </div>
  
  <!-- Informasi Kontak -->
  <div class="contact-info">
    <p>
      <strong>📞 Butuh Bantuan?</strong><br>
      WhatsApp: 0812-3456-7890<br>
      Email: cs@herbaclick.com<br>
      Jam Operasional: Senin - Sabtu, 08.00 - 17.00 WIB
    </p>
  </div>
</div>

<script>
// Konfetti animation (optional)
window.addEventListener('load', function() {
  console.log('✅ Order successfully placed: <?= $order_id ?>');
  
  // Auto-print option (optional)
  // window.print();
});
</script>
</body>
</html>