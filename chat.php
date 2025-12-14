
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Chat Konsultan - HerbaClick</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 50%, #a5d6a7 100%);
    background-attachment: fixed;
    margin: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
  }

  /* Animated background elements */
  body::before {
    content: '';
    position: fixed;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(76, 175, 80, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    top: -250px;
    right: -250px;
    animation: float 20s ease-in-out infinite;
    z-index: 0;
  }

  body::after {
    content: '';
    position: fixed;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(46, 125, 50, 0.08) 0%, transparent 70%);
    border-radius: 50%;
    bottom: -200px;
    left: -200px;
    animation: float 15s ease-in-out infinite reverse;
    z-index: 0;
  }

  @keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(5deg); }
    66% { transform: translate(-20px, 20px) rotate(-5deg); }
  }

  header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    padding: 20px 8%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 0;
    z-index: 100;
    animation: slideDown 0.5s ease-out;
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
    height: auto;
  }

  @keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }

  header .logo-area h2 {
    margin: 0;
    color: #1e4d2b;
    font-size: 1.4rem;
    font-weight: 700;
    background: linear-gradient(90deg, #1e4d2b, #2c7a7b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .home-link {
    color: #2c7a7b;
    font-weight: 600;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 12px;
    background: #e6fffa;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .home-link:hover {
    background: linear-gradient(135deg, #2c7a7b, #2b6cb0);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(44, 122, 123, 0.3);
  }

  .chat-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    position: relative;
    z-index: 1;
  }

  .chat-box {
    width: 95%;
    max-width: 900px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: zoomIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  @keyframes zoomIn {
    from {
      transform: scale(0.8);
      opacity: 0;
    }
    to {
      transform: scale(1);
      opacity: 1;
    }
  }

  /* Header dalam chat */
  .chat-header {
    display: flex;
    align-items: center;
    gap: 18px;
    background: linear-gradient(135deg, #2c7a7b 0%, #2b6cb0 100%);
    color: white;
    padding: 24px 30px;
    position: relative;
    overflow: hidden;
  }

  .chat-header::before {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    top: -50%;
    left: -50%;
    animation: shine 3s infinite;
  }


  .chat-header img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1;
  }

  @keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
  }

  .chat-header .info {
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 1;
  }

  .chat-header .info h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .chat-header .info span {
    font-size: 0.9rem;
    color: #d0f7ea;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 4px;
  }

  .status-dot {
    width: 8px;
    height: 8px;
    background: #4ade80;
    border-radius: 50%;
    display: inline-block;
  }

  @keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
  }

  /* Isi chat */
  .messages {
    flex: 1;
    overflow-y: auto;
    padding: 30px;
    background: linear-gradient(180deg, #f0f9ff 0%, #e0f2fe 100%);
    max-height: 500px;
    min-height: 400px;
    scroll-behavior: smooth;
  }

  .messages::-webkit-scrollbar {
    width: 8px;
  }

  .messages::-webkit-scrollbar-track {
    background: #e6fffa;
    border-radius: 10px;
  }

  .messages::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #2c7a7b, #2b6cb0);
    border-radius: 10px;
  }

  .msg-user, .msg-bot {
    margin: 15px 0;
    max-width: 75%;
    padding: 16px 20px;
    border-radius: 20px;
    animation: slideIn 0.4s ease;
    word-wrap: break-word;
    position: relative;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .msg-user {
    align-self: flex-end;
    background: linear-gradient(135deg, #2b6cb0 0%, #2c7a7b 100%);
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 5px;
    font-weight: 500;
  }

  .msg-user::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: -8px;
    width: 0;
    height: 0;
    border-left: 8px solid #2c7a7b;
    border-bottom: 8px solid transparent;
  }

  .msg-bot {
    align-self: flex-start;
    background: white;
    color: #1e4d2b;
    border: 2px solid #e6fffa;
    border-bottom-left-radius: 5px;
    font-weight: 500;
  }

  .msg-bot::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -10px;
    width: 0;
    height: 0;
    border-right: 10px solid white;
    border-bottom: 10px solid transparent;
  }

  /* Kartu Produk */
  .product-card {
    background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
    border-radius: 18px;
    padding: 20px;
    margin-top: 12px;
    box-shadow: 0 6px 20px rgba(44, 122, 123, 0.15);
    border-left: 5px solid #2c7a7b;
    max-width: 90%;
    animation: slideIn 0.5s ease 0.2s both;
    position: relative;
    overflow: hidden;
  }

  .product-card::before {
    content: '🌿';
    position: absolute;
    font-size: 120px;
    opacity: 0.05;
    right: -20px;
    top: -30px;
    transform: rotate(-15deg);
  }

  .product-card h5 {
    margin: 0 0 10px 0;
    color: #2c7a7b;
    font-size: 1.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .product-card p {
    margin: 10px 0;
    font-size: 0.95rem;
    color: #555;
    line-height: 1.7;
  }

  .product-actions {
    display: flex;
    gap: 10px;
    margin-top: 16px;
    flex-wrap: wrap;
  }

  .product-link {
    display: inline-block;
    background: linear-gradient(135deg, #2b6cb0, #2c7a7b);
    color: white;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    text-align: center;
    box-shadow: 0 4px 12px rgba(44, 122, 123, 0.3);
  }

  .product-link:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 20px rgba(44, 122, 123, 0.4);
  }

  .product-link.secondary {
    background: linear-gradient(135deg, #38a169, #2f855a);
  }

  /* Form input */
  form {
    display: flex;
    gap: 12px;
    padding: 24px;
    background: rgba(255, 255, 255, 0.98);
    border-top: 2px solid #e6fffa;
  }

  input {
    flex: 1;
    padding: 16px 20px;
    border-radius: 14px;
    border: 2px solid #bdecd6;
    outline: none;
    transition: all 0.3s ease;
    font-size: 15px;
    font-family: 'Poppins', sans-serif;
    background: #f8fffa;
  }

  input:focus {
    border-color: #2c7a7b;
    box-shadow: 0 0 0 4px rgba(44, 122, 123, 0.1);
    background: white;
  }

  button {
    padding: 16px 28px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #2c7a7b, #2b6cb0);
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 15px;
    box-shadow: 0 4px 15px rgba(44, 122, 123, 0.3);
  }

  button:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 8px 25px rgba(44, 122, 123, 0.4);
  }

  button:active {
    transform: translateY(0) scale(1);
  }

  footer {
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg, #2c7a7b, #2b6cb0);
    color: white;
    font-size: 14px;
    position: relative;
    z-index: 1;
  }

  /* Typing indicator */
  .typing-indicator {
    display: none;
    padding: 16px 20px;
    max-width: 75px;
    background: white;
    border: 2px solid #e6fffa;
    border-radius: 20px;
    margin: 15px 0;
    animation: slideIn 0.4s ease;
  }

  .typing-indicator span {
    height: 10px;
    width: 10px;
    background: #2c7a7b;
    border-radius: 50%;
    display: inline-block;
    margin: 0 2px;
    animation: typing 1.4s infinite;
  }

  .typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
  }

  .typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
  }

  @keyframes typing {
    0%, 60%, 100% {
      transform: translateY(0);
      opacity: 0.7;
    }
    30% {
      transform: translateY(-10px);
      opacity: 1;
    }
  }

  /* Responsive */
  @media (max-width: 768px) {
    header {
      padding: 15px 5%;
    }

    .chat-box {
      width: 100%;
      border-radius: 0;
    }

    .messages {
      padding: 20px;
      max-height: 400px;
    }

    .msg-user, .msg-bot {
      max-width: 85%;
    }

    form {
      padding: 16px;
    }
  }
</style>
</head>
<body>

<header>
  <div class="logo-area">
    <img src="images/logoherbaclick.png" alt="Logo HerbaClick">
    <h2>HerbaCheck</h2>
  </div>
  <a href="index.php" class="home-link">🏠 Home</a>
</header>

<div class="chat-container">
  <div class="chat-box">
    <!-- Profil konsultan -->
    <div class="chat-header">
      <img src="images/florin.jpg" alt="Konsultan Herbal">
      <div class="info">
        <h3>dr. Floryn, S.Herb</h3>
        <span><span class="status-dot"></span> Online • Konsultan Herbal</span>
      </div>
    </div>

    <!-- Area pesan -->
    <div class="messages" id="chatBox">
      <div class="msg-bot">Halo 🌿, saya <strong>dr. Floryn</strong>. Apa keluhan kesehatan yang ingin Anda konsultasikan hari ini?</div>
    </div>

    <!-- Typing indicator -->
    <div class="typing-indicator" id="typingIndicator">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!-- Input pesan -->
    <form onsubmit="sendMessage(event)">
      <input type="text" id="userInput" placeholder="Tulis pesan Anda..." required>
      <button type="submit">Kirim 📤</button>
    </form>
  </div>
</div>

<footer>
  &copy; <?php echo date('Y'); ?> HerbaClick • Sehat alamimu ada di genggamanmu 🌱
</footer>

<script>
// Database produk dengan keyword detection
const products = {
  wedang: {
    name: 'Wedang Uwuh',
    benefits: 'Menjaga sistem imun dan meredakan radang tenggorokan',
    id: 1,
    keywords: ['flu', 'batuk', 'pilek', 'demam', 'sakit tenggorokan', 'tenggorokan', 'imun', 'daya tahan', 'masuk angin', 'meriang', 'panas dingin', 'hidung tersumbat', 'bersin']
  },
  rosella: {
    name: 'Teh Rosella',
    benefits: 'Menurunkan tekanan darah dan memperlancar metabolisme tubuh',
    id: 2,
    keywords: ['darah tinggi', 'hipertensi', 'tekanan darah', 'tensi', 'kolesterol', 'metabolisme', 'diet', 'langsing', 'obesitas', 'gemuk', 'berat badan', 'kelebihan berat']
  },
  kunyit: {
    name: 'Jamu Kunyit Asam',
    benefits: 'Meningkatkan stamina dan menjaga kesehatan wanita',
    id: 3,
    keywords: ['haid', 'menstruasi', 'datang bulan', 'stamina', 'lelah', 'capek', 'nyeri haid', 'wanita', 'keputihan', 'pegal', 'lemas', 'tidak bertenaga', 'kram perut']
  }
};

// Fungsi untuk mendeteksi produk berdasarkan pesan
function detectProduct(message) {
  const msg = message.toLowerCase();
  
  for (const [key, product] of Object.entries(products)) {
    for (const keyword of product.keywords) {
      if (msg.includes(keyword)) {
        return product;
      }
    }
  }
  return null;
}

// Fungsi untuk membuat kartu produk
function createProductCard(product) {
  return `
    <div class="product-card">
      <h5>🌿 ${product.name}</h5>
      <p>${product.benefits}</p>
      <div class="product-actions">
        <a href="shop.php?add=${product.id}" class="product-link">🛒 Tambah ke Keranjang</a>
        <a href="shop.php" class="product-link secondary">👀 Lihat di Toko</a>
      </div>
    </div>
  `;
}

// Fungsi untuk mendapatkan response yang tepat
function getResponse(message) {
  const msg = message.toLowerCase();
  const product = detectProduct(msg);
  
  // Jika ada produk yang cocok
  if (product) {
    return {
      text: `Baik, untuk keluhan yang Anda alami, saya merekomendasikan <strong>${product.name}</strong>. ${product.benefits}. Produk ini sangat cocok untuk kondisi Anda! 💚`,
      product: product
    };
  }
  
  // Response untuk sapaan
  if (msg.includes('halo') || msg.includes('hai') || msg.includes('hello') || msg.includes('hi')) {
    return {
      text: 'Halo! 👋 Senang bisa membantu Anda hari ini. Silakan ceritakan keluhan kesehatan yang sedang Anda alami, saya akan membantu merekomendasikan produk herbal yang tepat.',
      product: null
    };
  }
  
  // Response untuk terima kasih
  if (msg.includes('terima kasih') || msg.includes('thanks') || msg.includes('makasih')) {
    return {
      text: 'Sama-sama! 🌿 Senang bisa membantu. Jangan ragu untuk berkonsultasi kembali kapan saja. Kesehatan Anda adalah prioritas kami!',
      product: null
    };
  }
  
  // Response untuk menanyakan produk
  if (msg.includes('produk') || msg.includes('jual') || msg.includes('beli') || msg.includes('toko')) {
    return {
      text: 'Kami memiliki 3 produk herbal unggulan: <strong>Wedang Uwuh</strong> (untuk imun & tenggorokan), <strong>Teh Rosella</strong> (untuk darah tinggi & metabolisme), dan <strong>Jamu Kunyit Asam</strong> (untuk stamina & kesehatan wanita). Ceritakan keluhan Anda, saya akan rekomendasikan yang paling sesuai! 🛍️',
      product: null
    };
  }
  
  // Default responses bervariasi
  const defaultResponses = [
    'Baik, bisa dijelaskan sejak kapan gejala itu muncul? 🌿',
    'Apakah ada gejala lain yang menyertai keluhan Anda?',
    'Terima kasih infonya. Untuk hasil yang lebih tepat, bisa sebutkan gejala spesifik yang Anda rasakan? Misalnya: batuk, demam, nyeri, dll.',
    'Saya akan bantu rekomendasikan produk herbal yang sesuai. Bisa ceritakan lebih detail keluhan Anda? 🌱'
  ];
  
  return {
    text: defaultResponses[Math.floor(Math.random() * defaultResponses.length)],
    product: null
  };
}

// Fungsi utama untuk mengirim pesan
function sendMessage(e) {
  e.preventDefault();
  const input = document.getElementById('userInput');
  const chat = document.getElementById('chatBox');
  const typingIndicator = document.getElementById('typingIndicator');
  const msg = input.value.trim();
  if (!msg) return;

  // Tampilkan pesan user
  chat.innerHTML += `<div class='msg-user'>${msg}</div>`;
  input.value = '';
  chat.scrollTop = chat.scrollHeight;

  // Tampilkan typing indicator
  typingIndicator.style.display = 'block';
  chat.scrollTop = chat.scrollHeight;

  // Response dari bot dengan delay
  setTimeout(() => {
    typingIndicator.style.display = 'none';
    const response = getResponse(msg);
    let botReply = `<div class='msg-bot'>${response.text}`;
    
    // Tambahkan kartu produk jika ada
    if (response.product) {
      botReply += createProductCard(response.product);
    }
    
    botReply += `</div>`;
    chat.innerHTML += botReply;
    chat.scrollTop = chat.scrollHeight;
  }, 1500);
}
</script>

</body>
</html>