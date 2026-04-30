<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Form Pendaftaran Anggota</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        // Variabel untuk menyimpan pesan
                        $success = '';
                        $errors = [];
                        
                        // Variabel untuk menyimpan input (untuk keep value)
                        $nama = '';
                        $email = '';
                        $telepon = '';
                        $alamat = '';
                        $jk = '';
                        $tanggal = '';
                        $pekerjaan = '';

                        // Proses form jika di-submit
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // Ambil dan sanitasi data
                            $nama = trim(htmlspecialchars($_POST['nama'] ?? ''));
                            $email = trim($_POST['email'] ?? '');
                            $telepon = trim(htmlspecialchars($_POST['telepon'] ?? ''));
                            $alamat = trim(htmlspecialchars($_POST['alamat'] ?? ''));
                            $jk = trim($_POST['jenis_kelamin'] ?? '');
                            $tanggal = trim($_POST['tanggal_lahir'] ?? '');
                            $pekerjaan = trim($_POST['pekerjaan'] ?? '');

                        // Nama
                        if (empty($nama)) {
                            $errors[] = "Nama wajib diisi";
                        } elseif (strlen($nama) < 3) {
                            $errors[] = "Nama minimal 3 karakter";
                        }

                        // Email
                        if (empty($email)) {
                            $errors[] = "Email wajib diisi";
                        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Format email tidak valid";
                        }

                        // Telepon
                        if (empty($telepon)) {
                            $errors[] = "Telepon wajib diisi";
                        } elseif (!is_numeric($telepon)) {
                            $errors[] = "Format telepon harus 08xxxxxxxxxx";
                        }

                        // Alamat
                        if (empty($alamat)) {
                            $errors[] = "Alamat wajib diisi";
                        } elseif (strlen($alamat) < 10) {
                            $errors[] = "Alamat minimal 10 karakter";
                        }

                        // Jenis Kelamin
                        if (empty($jk)) {
                            $errors[] = "Jenis kelamin wajib dipilih";
                        }

                        // Tanggal lahir
                        if (empty($tgl)) {
                            $errors[] = "Tanggal lahir wajib diisi";
                        } else {
                            $umur = date('Y') - date('Y', strtotime($tgl));
                            if ($umur < 10) {
                                $errors[] = "Umur minimal 10 tahun";
                            }
                        }

                        // Pekerjaan
                        if (empty($pekerjaan)) {
                            $errors[] = "Pekerjaan wajib dipilih";
                        }
                        
                        // Jika tidak ada error, proses data
                        if (count($errors) == 0) {
                            $success = "Data anggota berhasil disimpan!";

                            // Reset form
                                $nama = '';
                                $email = '';
                                $telepon = '';
                                $alamat = '';
                                $jk = '';
                                $tanggal = '';
                                $pekerjaan = '';
                        }
                    }
                    ?>

                    <!-- Tampilkan pesan sukses -->
                    <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle"></i> <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>
                        
                    <!-- Tampilkan error -->
                    <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <h6><i class="bi bi-exclamation-triangle"></i> Terdapat kesalahan:</h6>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="POST" action="">

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama"
                            class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($nama) ?>"
                            placeholder="Masukkan nama lengkap">
                        <div class="invalid-feedback"><?= $errors['nama'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                            class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($email) ?>"
                            placeholder="Masukkan email">
                        <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="telepon"
                            class="form-control <?= isset($errors['telepon']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($telepon) ?>"
                            placeholder="08xxxxxxxxxx"
                            maxlength="13"
                            pattern="08[0-9]{8,11}"
                            title="Format: 08xxxxxxxxxx (10-13 digit)"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <div class="invalid-feedback"><?= $errors['telepon'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat"
                            class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>"
                            placeholder="Masukkan alamat lengkap"
                            required
                            minleghth="10"><?= htmlspecialchars($alamat) ?></textarea>
                        <div class="invalid-feedback"><?= $errors['alamat'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label><br>
                        
                        <input type="radio" name="jk" value="Laki-laki"
                            <?= ($jk == "Laki-laki") ? 'checked' : '' ?>> Laki-laki
                        
                        <input type="radio" name="jk" value="Perempuan"
                            <?= ($jk == "Perempuan") ? 'checked' : '' ?>> Perempuan
                        
                        <div class="text-danger"><?= $errors['jk'] ?? '' ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tgl"
                                class="form-control <?= isset($errors['tgl']) ? 'is-invalid' : '' ?>"
                                value="<?= $tgl ?>">
                                max="<? $maxDate ?>"
                                required>
                            <div class="invalid-feedback"><?= $errors['tgl'] ?? '' ?></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                            <select class="form-select" id="pekerjaan" name="pekerjaan">
                                <option value="">-- Pilih Pekerjaan--</option>
                                <option value="Pelajar" <?= ($pekerjaan=="Pelajar")?'selected':'' ?>>Pelajar</option>
                                <option value="Mahasiswa" <?= ($pekerjaan=="Mahasiswa")?'selected':'' ?>>Mahasiswa</option>
                                <option value="Pegawai" <?= ($pekerjaan=="Pegawai")?'selected':'' ?>>Pegawai</option>
                                <option value="Lainnya" <?= ($pekerjaan=="Lainnya")?'selected':'' ?>>Lainnya</option>
                            </select>
                            <div class="invalid-feedback"><?= $errors['pekerjaan'] ?? '' ?></div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                                <small><i class="bi bi-info-circle"></i> <strong>Catatan:</strong> Field dengan tanda (*) wajib diisi</small>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Data Anggota
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Validasi -->
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-shield-check"></i> Aturan Validasi</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Nama lengkap minimal 3 karakter</li>
                            <li>Email harus format valid (contoh: nama@email.com)</li>
                            <li>Telepon harus format 08xxxxxxxxxx (10–13 digit)</li>
                            <li>Alamat minimal 10 karakter</li>
                            <li>Jenis kelamin wajib dipilih</li>
                            <li>Umur minimal 10 tahun (berdasarkan tanggal lahir)</li>
                            <li>Pekerjaan wajib dipilih</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                                        