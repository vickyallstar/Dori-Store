<?php
// Ambil data produk dan harga dari form
$product = $_POST['product'];
$price = $_POST['price']; // Menggunakan harga dalam Rupiah

// Data yang dikirim ke Atlantic Payment Gateway
$api_key = 'oKTBXMgq95LA708F7N1XX9xcwg0HezeQbmfYRcJAmNkUkfQb68SZxJp7qm9V1v4fTlfN44UkzfDgNOniIt6P3OB2S3bO3eNhbmjq'; // Ganti dengan API Key Anda
$api_url = 'https://api.atlantic-payment.com/transaction';

// Data pembayaran yang akan dikirim ke API
$data = [
    'amount' => $price, // Harga dalam Rupiah
    'currency' => 'IDR', // Mata uang Rupiah
    'product' => $product,
    'api_key' => $api_key,
];

// Kirim data ke API
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);
curl_close($ch);

// Decode respon dari API
$response_data = json_decode($response, true);

// Proses berdasarkan respon API
if ($response_data['status'] == 'success') {
    echo "<h1>Pembayaran Berhasil</h1>";
    echo "<p>Terima kasih telah membeli {$product} seharga Rp {$price}.</p>";
    echo "<a href='index.html'>Kembali ke Toko</a>";
} else {
    echo "<h1>Gagal Memproses Pembayaran</h1>";
    echo "<p>Coba lagi nanti.</p>";
    echo "<a href='index.html'>Kembali ke Toko</a>";
}
?>
