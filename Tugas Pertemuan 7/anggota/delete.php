<?php
require_once '../../config/database.php';

// Cek apakah ada ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=ID anggota tidak valid");
    exit();
}

$id_anggota = (int) $_GET['id'];

// Ambil data anggota
$stmt = $conn->prepare("SELECT nama, foto FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ada
if ($result->num_rows == 0) {
    $stmt->close();
    header("Location: index.php?error=Data anggota tidak ditemukan");
    exit();
}

$anggota = $result->fetch_assoc();
$nama_anggota = $anggota['nama'];
$foto = $anggota['foto'];
$stmt->close();

// Hapus foto jika ada
if (!empty($foto) && file_exists("uploads/" . $foto)) {
    unlink("uploads/" . $foto);
}

// Proses delete data
$stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        header("Location: index.php?success=" . urlencode("Data anggota '$nama_anggota' berhasil dihapus"));
        exit();
    } else {
        $stmt->close();
        header("Location: index.php?error=Gagal menghapus data");
        exit();
    }
} else {
    $error = $stmt->error;
    $stmt->close();
    header("Location: index.php?error=" . urlencode("Error database: $error"));
    exit();
}
?>