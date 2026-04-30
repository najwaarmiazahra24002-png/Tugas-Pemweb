<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Status Peminjaman Anggota</h1>
        
        <?php
        // Data Anggota
        $nama_anggota = "Budi Santoso";
        $total_pinjaman = 2;
        $buku_terlambat = 1;
        $hari_keterlambatan = 5;

        // aturan
        $max_pinjaman = 3;
        $denda_per_hari = 1000;
        $max_denda = 50000;

        // hitung denda
        $total_denda = $buku_terlambat * $hari_keterlambatan * $denda_per_hari;
        if ($total_denda > $max_denda) {
            $total_denda = $max_denda;
        }
        // IF-ELSEIF-ELSE
        if ($buku_terlambat > 0) {
            $status = "Tidak bisa meminjam";
            $alasan = "Masih ada buku terlambat";
            $badge = "danger";
        } elseif ($total_pinjaman >= $max_pinjaman) {
           $status = "Tidak bisa meminjam";
           $alasan = "Sudah mencapai batas maksimal";
           $badge = "warning"; 
        } else {
            $status = "Bisa meminjam";
            $alasan = "Tidak ada Kendala";
            $badge = "success";
        }

        // SWITCH level member
        switch (true) {
            case ($total_pinjaman >= 0 && $total_pinjaman <= 5):
                $level = "Bronze";
                break;
            case ($total_pinjaman >= 6 && $total_pinjaman <= 15):
                $level = "Silver";
                break;
            default:
                $level = "Gold";
                break;
        }
        ?>

        <!-- Card Info -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Nama Anggota</h5>
                    <p><?= $nama_anggota ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Total Pinjaman</h5>
                    <p><?= $total_pinjaman?> Buku</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Level Member</h5>
                    <p><?= $level ?></p>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="card mb-4 p-3">
            <h5>Status Peminjaman</h5>
            <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
            <p class="mt-2">Alasan: <?= $alasan ?></p>

            <?php if ($buku_terlambat > 0): ?>
                <p>Denda: Rp <?= number_format($total_denda, 0, ',', '.') ?></p>
                <div class="alert alert-danger">
                    Peringatan: Segera kembalikan buku yang terlambat!
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>