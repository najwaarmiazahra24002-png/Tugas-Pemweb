<?php
$page_title = "Edit Data Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Cek apakah ada ID di URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_anggota = (int)$_GET['id'];
$errors = [];

// Ambil data anggota
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
    $stmt->bind_param("i", $id_anggota);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        header("Location: index.php");
        exit();
    }

    $anggota = $result->fetch_assoc();
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_anggota = sanitize($_POST['kode_anggota']);
    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $telepon = sanitize($_POST['telepon']);
    $alamat = sanitize($_POST['alamat']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pekerjaan = sanitize($_POST['pekerjaan']);
    $status = $_POST['status'];

    // Validasi
    if (empty($kode_anggota)) {
        $errors[] = "Kode anggota wajib diisi";
    }

    if (empty($nama)) {
        $errors[] = "Nama wajib diisi";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }

    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors[] = "Format telepon salah";
    }

    $umur = date_diff(date_create($tanggal_lahir), date_create('today'))->y;
    if ($umur < 10) {
        $errors[] = "Umur minimal 10 tahun";
    }

    // Cek email unik
    $cek = $conn->prepare("SELECT id_anggota FROM anggota WHERE email = ? AND id_anggota != ?");
    $cek->bind_param("si", $email, $id_anggota);
    $cek->execute();
    if ($cek->get_result()->num_rows > 0) {
        $errors[] = "Email sudah digunakan";
    }

    // Upload foto
    $foto = $anggota['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            "uploads/" . $foto
        );
    }

    // Update
    if (count($errors) == 0) {
        $stmt = $conn->prepare("UPDATE anggota SET
            kode_anggota=?,
            nama=?,
            email=?,
            telepon=?,
            alamat=?,
            tanggal_lahir=?,
            jenis_kelamin=?,
            pekerjaan=?,
            status=?,
            foto=?
            WHERE id_anggota=?");

        $stmt->bind_param(
            "ssssssssssi",
            $kode_anggota,
            $nama,
            $email,
            $telepon,
            $alamat,
            $tanggal_lahir,
            $jenis_kelamin,
            $pekerjaan,
            $status,
            $foto,
            $id_anggota
        );

        if ($stmt->execute()) {
            header("Location: index.php?success=Data berhasil diupdate");
            exit();
        }
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning">
            <h4>Edit Data Anggota</h4>
        </div>
        <div class="card-body">
            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Kode Anggota</label>
                    <input type="text"
                           name="kode_anggota"
                           class="form-control"
                           value="<?= $anggota['kode_anggota']; ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="<?= $anggota['nama']; ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?= $anggota['email']; ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label>Telepon</label>
                    <input type="text"
                           name="telepon"
                           class="form-control"
                           value="<?= $anggota['telepon']; ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              required><?= $anggota['alamat']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control"
                           value="<?= $anggota['tanggal_lahir']; ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                            class="form-select"
                            required>
                        <option value="Laki-laki"
                            <?= ($anggota['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>> Laki-laki
                        </option>

                        <option value="Perempuan"
                            <?= ($anggota['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>> Perempuan
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <input type="text"
                           name="pekerjaan"
                           class="form-control"
                           value="<?= $anggota['pekerjaan']; ?>">
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="Aktif"
                            <?= ($anggota['status'] == 'Aktif') ? 'selected' : ''; ?>>
                            Aktif
                        </option>
                        <option value="Nonaktif"
                            <?= ($anggota['status'] == 'Nonaktif') ? 'selected' : ''; ?>>
                            Nonaktif
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Foto</label>
                    <input type="file"
                           name="foto"
                           class="form-control">
                </div>
                <button type="submit"
                        class="btn btn-warning">
                    Update
                </button>
                <a href="index.php"
                   class="btn btn-secondary"> Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<?php
closeConnection();
?>