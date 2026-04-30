<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>
        
        <?php
        // data pembeli dan buku
        $nama_pembeli = "Hafiz Ayusman";
        $judul_buku = "Python for Data Science";
        $harga_satuan = 150000;
        $jumlah_beli = 3;
        $is_member = true; // true atau false
        
        // Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli;
        
        // diskon berdasarkan jumlah
        if ($jumlah_beli <= 2) {
            $persentase_diskon = 0;
        } elseif ($jumlah_beli <= 5) {
            $persentase_diskon = 10;
        } elseif ($jumlah_beli <= 10) {
            $persentase_diskon = 15;
        } else {
            $persentase_diskon = 20;
        }
        
        // diskon utama
        $diskon = $subtotal * ($persentase_diskon / 100);
        
        // total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon;
        
        // diskon member 
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $subtotal * 0.05;
        }
        
        // total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;
        
        // PPN 11%
        $ppn = $total_setelah_diskon * 0.11;
        
        // total akhir
        $total_akhir = $total_setelah_diskon + $ppn;
        
        // total penghematan
        $total_hemat = $diskon + $diskon_member;

        // format rupiah
        function rupiah($angka) {
            return "Rp" . number_format($angka, 0, ',', '.');
        }
        ?>
        
        <div class ="card">
            <div class="card-header bg-primary text-white">
                Hasil Perhitungan
            </div>
            <div class="card-body">
                <h5>Data Pembeli</h5>
                <p>Nama: <strong><?= $nama_pembeli ?></strong></p>

                <h5>Detail Buku</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Judul Buku</th>
                        <td><?= $judul_buku ?></td>
                    </tr>
                    <tr>
                        <th>Harga Satuan</th>
                        <td><?= rupiah($harga_satuan) ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td><?= $jumlah_beli ?></td>
                    </tr>
                </table>
                <h5>Perhitungan</h5>
                <table class="table table-striped">
                    <tr>
                        <th>Subtotal</th>
                        <td><?= rupiah($subtotal) ?></td>
                    </tr>
                    <tr>
                        <th>Diskon (<?= $persentase_diskon ?>%)</th>
                        <td><?= rupiah($diskon) ?></td>
                    </tr>

                    <?php if ($is_member): ?>
                    <tr>
                        <th>Diskon Member (5%)</th>
                        <td><?= rupiah($diskon_member) ?></td>
                    </tr>
                    <?php endif; ?>
                    
                    <tr>
                        <th>Total Setelah Diskon</th>
                        <td><?= rupiah($total_setelah_diskon) ?></td>
                    </tr>
                    <tr>
                        <th>PPN (11%)</th>
                        <td><?= rupiah($ppn) ?></td>
                    </tr>
                    <tr class="table-success">
                        <th>Total Akhir</th>
                        <td><strong><?= rupiah($total_akhir) ?></strong></td>
                    </tr>
                    <tr class="table-warning">
                        <th>Total Penghematan</th>
                        <td><?= rupiah($total_hemat) ?></td>
                    </tr>
                </table>
                
                <span class="badge bg-<?= $is_member ? 'success' : 'secondary' ?>">
                    <?= $is_member ? 'Member' : 'Non Member' ?>
                </span>
            
            </div>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>