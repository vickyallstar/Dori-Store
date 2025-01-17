<?php
// Pastikan data POST ada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data produk dan harga dari form
    $product = $_POST['product'];
    $price = $_POST['price'];

    // Validasi data produk dan harga
    if (empty($product) || empty($price)) {
        echo "Data produk atau harga tidak valid.";
        exit;
    }

    // Data untuk pembayaran
    $api_key = 'OktBXMgq95LA708F7N1XX9xcwg0HezeQbmfYRcJAmNkUkfQb68SZxJp7qm9V1v4fTlfN44UkzfDgNOniIt6P3OB2S3bO3eNhbmjq'; // Ganti dengan API Key Anda yang valid
    $api_url = 'https://api.atlantic-payment.com/v1/payment'; // Ganti dengan URL endpoint Atlantic API jika diperlukan

    // Data pembayaran yang akan dikirimkan
    $data = [
        'amount' => $price, // Harga dalam Rupiah
        'currency' => 'IDR', // Mata uang Rupiah
        'product' => $product,
        'api_key' => $api_key, // API key untuk autentikasi
        'callback_url' => 'https://dori-store.vercel.app/' // Ganti dengan URL sukses pembayaran yang sesuai
    ];

    // Kirim data ke API menggunakan cURL
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // Eksekusi request dan ambil respon
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode respon dari API
    $response_data = json_decode($response, true);

    // Proses berdasarkan respon API
    if (isset($response_data['status']) && $response_data['status'] == 'success') {
        echo "<h1>Pembayaran Berhasil</h1>";
        echo "<p>Terima kasih telah membeli {$product} seharga Rp {$price}.</p>";
        echo "<a href='index.html'>Kembali ke Toko</a>";
    } else {
        echo "<h1>Gagal Memproses Pembayaran</h1>";
        echo "<p>Terjadi kesalahan, coba lagi nanti.</p>";
        echo "<a href='index.html'>Kembali ke Toko</a>";
    }
}
?>
