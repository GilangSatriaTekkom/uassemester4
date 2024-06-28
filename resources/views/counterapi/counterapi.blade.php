<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
$dbname = "uassemester4";  // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memeriksa apakah parameter yang diperlukan ada
if(isset($_GET['jenis_koin'])) {
    $jenis_koin = $_GET['jenis_koin'];
    $tanggal_jam = date("Y-m-d H:i:s");  // Waktu saat ini

    // Menyimpan data ke tabel counter
    $sql = "INSERT INTO counter (jenis_koin, tanggal_jam) VALUES ('$jenis_koin', '$tanggal_jam')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Missing parameters";
}

$conn->close();
?>
