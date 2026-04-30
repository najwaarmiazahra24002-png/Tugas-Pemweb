<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><i class="bi bi-book"></i> Array Anggota Perpustakaan</h1>

        <?php
        // Data Anggota (multidimensional array)
        $anggota_list = [
            [
                "id" => "AGT-001",
                "nama" => "Budi Santoso",
                "email" => "budi@email.com",
                "telepon" => "081234567890",
                "alamat" => "Jakarta",
                "tanggal_daftar" => "2024-01-15",
                "status" => "Aktif",
                "total_pinjaman" => 5
            ],
            [
                "id" => "AGT-002",
                "nama" => "Najwa Armia",
                "email" => "najwa@email.com",
                "telepon" => "082345678901",
                "alamat" => "Pekalongan",
                "tanggal_daftar" => "2024-04-15",
                "status" => "Non-Aktif",
                "total_pinjaman" => 8
            ],
            [
                "id" => "AGT-003",
                "nama" => "Dewi Lestari",
                "email" => "dewi@email.com",
                "telepon" => "084567890123",
                "alamat" => "Yogyakarta",
                "tanggal_daftar" => "2024-01-20",
                "status" => "Aktif",
                "total_pinjaman" => 12
            ],
            [ 
                "id" => "AGT-004",
                "nama" => "Andi Wijaya",
                "email" => "andi@email.com",
                "telepon" => "083456789012",
                "alamat" => "Surabaya",
                "tanggal_daftar" => "2024-03-05",
                "status" => "Aktif",
                "total_pinjaman" => 2
            ],
            [
                "id" => "AGT-005",
                "nama" => "Siti Aminah",
                "email" => "siti@email.com",
                "telepon" => "085678901234",
                "alamat" => "Semarang",
                "tanggal_daftar" => "2024-02-25",
                "status" => "Non-Aktif",
                "total_pinjaman" => 4
            ]
        ];

        // hitung statistik
        $total_anggota = count($anggota_list);
        $aktif = 0;
        $nonaktif = 0;
        $total_pinjaman_semua = 0;

        $anggota_teraktif = $anggota_list[0];

        foreach ($anggota_list as $agt) {
            if ($agt['status'] == "Aktif") {
                $aktif++;
            } else {
                $nonaktif++;
            }

            $total_pinjaman_semua += $agt['total_pinjaman'];

            // cari paling banyak pinjam
            if ($agt['total_pinjaman'] > $anggota_teraktif['total_pinjaman']) {
                $anggota_teraktif = $agt;
            }
        }

        $persen_aktif = ($aktif / $total_anggota) * 100;
        $persen_nonaktif = ($nonaktif / $total_anggota) * 100;
        $rata_pinjaman = $total_pinjaman_semua / $total_anggota;
        ?>

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <h6>Total Anggota</h6>
                        <h3><?php echo $total_anggota; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-success">
                    <div class="card-body">
                        <h6>Aktif (%)</h6>
                        <h3><?php echo number_format($persen_aktif, 0); ?>%</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-danger">
                    <div class="card-body">
                        <h6>Non-Aktif (%)</h6>
                        <h3><?php echo number_format($persen_nonaktif, 0); ?>%</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-warning">
                    <div class="card-body">
                        <h6>Rata-rata Pinjaman</h6>
                        <h3><?php echo number_format($rata_pinjaman, 1); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota Teraktif -->
        <div class="alert alert-info">
            <b>Anggota Teraktif:</b> <?php echo $anggota_teraktif['nama']; ?> 
            (<?php echo $anggota_teraktif['total_pinjaman']; ?> pinjaman)
        </div>

        <!-- Filter (contoh: hanya aktif) -->
        <h5>Data Anggota Aktif</h5>

        <!-- Tabel -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Tgl Daftar</th>
                    <th>Status</th>
                    <th>Total Pinjaman</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($anggota_list as $agt) { 
                    if ($agt['status'] != "Aktif") continue; // filter aktif
                ?>
                <tr>
                    <td><?php echo $agt['id']; ?></td>
                    <td><?php echo $agt['nama']; ?></td>
                    <td><?php echo $agt['email']; ?></td>
                    <td><?php echo $agt['telepon']; ?></td>
                    <td><?php echo $agt['alamat']; ?></td>
                    <td><?php echo $agt['tanggal_daftar']; ?></td>
                    <td>
                        <?php if ($agt['status'] == "Aktif") { ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php } else { ?>
                            <span class="badge bg-secondary">Non-Aktif</span>
                        <?php } ?>
                    </td>
                    <td><?php echo $agt['total_pinjaman']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>