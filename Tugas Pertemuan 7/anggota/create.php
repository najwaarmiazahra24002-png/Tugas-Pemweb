<?php
$page_title = "Tambah Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Inisialisasi variabel
$errors = [];
$kode_anggota = '';
$nama = '';
$email = '';
$telepon = '';
$alamat = '';
$tanggal_lahir = '';
$jenis_kelamin = '';
$pekerjaan = '';

// Proses form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_anggota = sanitize($_POST['kode_anggota']);
    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $telepon = sanitize($_POST['telepon']);
    $alamat = sanitize($_POST['alamat']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
    $pekerjaan = sanitize($_POST['pekerjaan']);
    $tanggal_daftar = date('Y-m-d');
    $status = 'Aktif';

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

    // Validasi umur minimal 10 tahun
    $umur = date_diff(
        date_create($tanggal_lahir),
        date_create('today')
        )->y;

    if ($umur < 10) {
        $errors[] = "Umur minimal 10 tahun";
    }

    // Cek kode anggota
    $cekKode = $conn->prepare("SELECT id_anggota FROM anggota WHERE kode_anggota=?");
    $cekKode->bind_param("s", $kode_anggota);
    $cekKode->execute();

    if ($cekKode->get_result()->num_rows > 0) {
        $errors[] = "Kode anggota sudah digunakan";
    }

    // Cek email
    $cekEmail = $conn->prepare("SELECT id_anggota FROM anggota WHERE email=?");
    $cekEmail->bind_param("s", $email);
    $cekEmail->execute();

    if ($cekEmail->get_result()->num_rows > 0) {
        $errors[] = "Email sudah digunakan";
    }

    // Upload foto
    $foto = '';
    if ($_FILES['foto']['name'] != '') {
        $foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            "uploads/" . $foto
        );
    }

    // Insert data
    if (count($errors) == 0) {
        $stmt = $conn->prepare("
            INSERT INTO anggota
            (
                kode_anggota,
                nama,
                email,
                telepon,
                alamat,
                tanggal_lahir,
                jenis_kelamin,
                pekerjaan,
                tanggal_daftar,
                status,
                foto
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssssssss",
            $kode_anggota,
            $nama,
            $email,
            $telepon,
            $alamat,
            $tanggal_lahir,
            $jenis_kelamin,
            $pekerjaan,
            $tanggal_daftar,
            $status,
            $foto
        );

        if ($stmt->execute()) {
            header("Location: index.php?success=Data berhasil ditambahkan");
            exit();
        } else {
            $errors[] = "Gagal menyimpan data";
        }
    }
}
?>

<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Tambah Anggota</h4>
        </div>
        <div class="card-body">

            <!-- Error -->
            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
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
                           value="<?= htmlspecialchars($kode_anggota); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="<?= htmlspecialchars($nama); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?= htmlspecialchars($email); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Telepon</label>
                    <input type="text"
                           name="telepon"
                           class="form-control"
                           value="<?= htmlspecialchars($telepon); ?>"
                           placeholder="08xxxxxxxxxx"
                           required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              required><?= htmlspecialchars($alamat); ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control"
                           value="<?= htmlspecialchars($tanggal_lahir); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                            class="form-select"
                            required>

                        <option value="">-- Pilih --</option>

                        <option value="Laki-laki"> Laki-laki
                        </option>

                        <option value="Perempuan"> Perempuan
                        </option>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>

                    <input type="text"
                           name="pekerjaan"
                           class="form-control"
                           value="<?= htmlspecialchars($pekerjaan); ?>">
                </div>

                <div class="mb-3">
                    <label>Foto</label>
                    <input type="file"
                           name="foto"
                           class="form-control">
                </div>
                <button type="submit" class="btn btn-primary"> Simpan
                </button>
                <a href="index.php" class="btn btn-secondary"> Batal
                </a>
            </form>
        </div>
    </div>
</div>

<?php
closeConnection();
?>