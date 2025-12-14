<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

// Redirect jika keranjang kosong
if (empty($_SESSION['cart'])) {
  header('Location: chart.php');
  exit();
}

$products = [
  1 => ["Wedang Uwuh", "Menjaga sistem imun dan meredakan radang tenggorokan.", "images/uwuh.jpg", 25000],
  2 => ["Teh Rosella", "Menurunkan tekanan darah dan memperlancar metabolisme tubuh.", "images/teh.jpg", 30000],
  3 => ["Jamu Kunyit Asam", "Meningkatkan stamina dan menjaga kesehatan wanita.", "images/kunirasem.jpg", 28000]
];

// Hitung total
$subtotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
  if (isset($products[$id])) {
    $subtotal += $products[$id][3] * $qty;
  }
}

$ongkir = 10000; // Ongkos kirim flat
$total = $subtotal + $ongkir;

// Proses pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = htmlspecialchars(trim($_POST['nama']));
  $alamat = htmlspecialchars(trim($_POST['alamat']));
  $telepon = htmlspecialchars(trim($_POST['telepon']));
  $payment = htmlspecialchars($_POST['payment']);
  
  // Simpan order
  $_SESSION['last_order'] = [
    'nama' => $nama,
    'alamat' => $alamat,
    'telepon' => $telepon,
    'payment' => $payment,
    'total' => $total,
    'subtotal' => $subtotal,
    'ongkir' => $ongkir,
    'items' => $_SESSION['cart'],
    'tanggal' => date('Y-m-d H:i:s')
  ];
  
  // Kosongkan keranjang
  $_SESSION['cart'] = [];
  
  // Redirect ke halaman sukses
  header('Location: paymentdone.php');
  exit();
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran - HerbaClick</title>
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
  }
  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 8%;
    background: rgba(255,255,255,0.95);
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
  }
  header h2 { 
    color: #2c7a7b; 
    margin: 0;
  }
  header a {
    color: #2c7a7b;
    text-decoration: none;
    font-weight: 600;
  }
  header a:hover {
    color: #22543d;
  }
  .container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 30px;
  }
  .section {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  }
  h3 {
    color: #2c7a7b;
    margin-bottom: 20px;
    font-size: 22px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e6fffa;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .form-group {
    margin-bottom: 20px;
  }
  label {
    display: block;
    margin-bottom: 8px;
    color: #2c5282;
    font-weight: 600;
    font-size: 14px;
  }
  label .required {
    color: #e53e3e;
  }
  input, textarea, select {
    width: 100%;
    padding: 12px 14px;
    border: 2px solid #bdecd6;
    border-radius: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    transition: all 0.3s;
  }
  input:focus, textarea:focus, select:focus {
    outline: none;
    border-color: #2c7a7b;
    box-shadow: 0 0 0 3px rgba(44,122,123,0.1);
  }
  textarea {
    resize: vertical;
    min-height: 100px;
  }
  .order-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f7fafc;
    border-radius: 10px;
    margin-bottom: 12px;
  }
  .order-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
  }
  .item-info {
    flex: 1;
  }
  .item-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
  }
  .item-qty {
    font-size: 13px;
    color: #718096;
  }
  .item-price {
    font-weight: 700;
    color: #2c7a7b;
    font-size: 15px;
  }
  .summary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    font-size: 15px;
    color: #4a5568;
  }
  .summary-row.total {
    border-top: 2px solid #2c7a7b;
    margin-top: 15px;
    padding-top: 15px;
    font-size: 22px;
    font-weight: 700;
    color: #2c7a7b;
  }
  .payment-options {
    display: grid;
    gap: 12px;
    margin-top: 15px;
  }
  .payment-option {
    border: 2px solid #cbd5e0;
    border-radius: 12px;
    padding: 16px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
  }
  .payment-option:hover {
    border-color: #2c7a7b;
    background: #f0fdf4;
    transform: translateY(-2px);
  }
  .payment-option input[type="radio"] {
    width: 20px;
    height: 20px;
    margin: 0;
    cursor: pointer;
  }
  .payment-option.selected {
    border-color: #2c7a7b;
    background: #e6fffa;
    box-shadow: 0 4px 12px rgba(44,122,123,0.15);
  }
  .payment-label {
    flex: 1;
  }
  .payment-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
  }
  .payment-desc {
    font-size: 13px;
    color: #718096;
  }
  .btn {
    padding: 14px 24px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-block;
    text-align: center;
    cursor: pointer;
    border: none;
    font-size: 16px;
    font-family: 'Poppins', sans-serif;
  }
  .btn-primary {
    background: linear-gradient(135deg, #2b6cb0, #2c7a7b);
    color: white;
    width: 100%;
    margin-top: 20px;
    box-shadow: 0 4px 12px rgba(44,122,123,0.3);
  }
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44,122,123,0.4);
  }
  .btn-primary:active {
    transform: translateY(0);
  }
  .alert {
    padding: 15px;
    border-radius: 10px;
    margin-top: 20px;
    font-size: 13px;
    line-height: 1.6;
  }
  .alert-warning {
    background: #fffbeb;
    border-left: 4px solid #f59e0b;
    color: #92400e;
  }
  @media (max-width: 968px) {
    .container {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>
<header>
  <h2>💳 Pembayaran</h2>
  <a href="chart.php">🛒 Kembali ke Keranjang</a>
</header>

<form method="POST" id="checkoutForm">
  <div class="container">
    <!-- Form Kiri: Data Pengiriman & Pembayaran -->
    <div>
      <!-- Informasi Pengiriman -->
      <div class="section">
        <h3>📦 Informasi Pengiriman</h3>
        
        <div class="form-group">
          <label>Nama Lengkap <span class="required">*</span></label>
          <input type="text" name="nama" placeholder="Contoh: Budi Santoso" required>
        </div>
        
        <div class="form-group">
          <label>Nomor Telepon <span class="required">*</span></label>
          <input type="tel" name="telepon" placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}" required>
        </div>
        
        <div class="form-group">
          <label>Alamat Lengkap <span class="required">*</span></label>
          <textarea name="alamat" placeholder="Jl. Contoh No. 123, RT/RW 01/02&#10;Kelurahan, Kecamatan&#10;Kota, Provinsi, Kode Pos" required></textarea>
        </div>
      </div>
      
      <!-- Metode Pembayaran -->
      <div class="section" style="margin-top: 20px;">
        <h3>💳 Metode Pembayaran</h3>
        
        <div class="payment-options">
          <label class="payment-option">
            <input type="radio" name="payment" value="transfer" required>
            <div class="payment-label">
              <div class="payment-name">🏦 Transfer Bank</div>
              <div class="payment-desc">BCA, BNI, Mandiri</div>
            </div>
          </label>
          
          <label class="payment-option">
            <input type="radio" name="payment" value="cod" required>
            <div class="payment-label">
              <div class="payment-name">🚚 COD (Bayar di Tempat)</div>
              <div class="payment-desc">Bayar saat barang tiba</div>
            </div>
          </label>
          
          <label class="payment-option">
            <input type="radio" name="payment" value="ewallet" required>
            <div class="payment-label">
              <div class="payment-name">📱 E-Wallet</div>
              <div class="payment-desc">GoPay, OVO, DANA, ShopeePay</div>
            </div>
          </label>
        </div>
      </div>
    </div>
    
    <!-- Sidebar Kanan: Ringkasan Pesanan -->
    <div>
      <div class="section">
        <h3>📋 Ringkasan Pesanan</h3>
        
        <div style="margin-bottom: 20px;">
          <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
            <?php if (isset($products[$id])): ?>
              <div class="order-item">
                <img src="<?= $products[$id][2] ?>" alt="<?= $products[$id][0] ?>">
                <div class="item-info">
                  <div class="item-name"><?= $products[$id][0] ?></div>
                  <div class="item-qty"><?= $qty ?> x Rp <?= number_format($products[$id][3], 0, ',', '.') ?></div>
                </div>
                <div class="item-price">Rp <?= number_format($products[$id][3] * $qty, 0, ',', '.') ?></div>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        
        <div style="border-top: 2px solid #e6fffa; padding-top: 15px;">
          <div class="summary-row">
            <span>Subtotal</span>
            <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
          </div>
          <div class="summary-row">
            <span>Ongkos Kirim</span>
            <span>Rp <?= number_format($ongkir, 0, ',', '.') ?></span>
          </div>
          <div class="summary-row total">
            <span>Total Bayar</span>
            <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
          </div>
        </div>
        
        <button type="submit" class="btn btn-primary">
             <a href="paymentdone.php"></a>
          ✅ Proses Pembayaran</a>
        </button>
        
        <div class="alert alert-warning">
          <strong>📌 Catatan:</strong><br>
          • Pastikan data yang Anda masukkan sudah benar<br>
          • Pesanan akan diproses setelah pembayaran dikonfirmasi<br>
          • Estimasi pengiriman 2-3 hari kerja
        </div>
      </div>
    </div>
  </div>
</form>

<script>
// Highlight payment option saat dipilih
document.querySelectorAll('.payment-option').forEach(option => {
  option.addEventListener('click', function() {
    document.querySelectorAll('.payment-option').forEach(opt => {
      opt.classList.remove('selected');
    });
    this.classList.add('selected');
    this.querySelector('input[type="radio"]').checked = true;
  });
});

// Validasi form sebelum submit
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
  const paymentSelected = document.querySelector('input[name="payment"]:checked');
  if (!paymentSelected) {
    e.preventDefault();
    alert('Silakan pilih metode pembayaran!');
    return false;
  }
});
</script>
</body>
</html>