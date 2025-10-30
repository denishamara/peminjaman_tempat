<?php
$koneksi = new mysqli("localhost", "root", "", "peminjaman_ruang");

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT); // ⬅️ Ini penting
$role = 'administrator';

$sql = "INSERT INTO user (username, password, role) VALUES (?, ?, ?)";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    echo "Admin berhasil ditambahkan!";
} else {
    echo "Gagal: " . $stmt->error;
}
?>
