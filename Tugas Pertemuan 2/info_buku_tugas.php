<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>
        
        <?php
        // buku ASLI
        $judul1 = "Laravel: From Beginner to Advanced";
        $pengarang1 = "Budi Raharjo";
        $penerbit1 = "Informatika";
        $tahun1 = 2023;
        $harga1 = 125000;
        $stok1 = 8;
        $isbn1 = "978-602-1234-56-7";
        $kategori1 = "Programming"; 
        $bahasa1 = "Indonesia";     
        $halaman1 = 320;            
        $berat1 = 500;              

        // buku tambahan
        $judul2 = "Mastering MySQL Database";
        $pengarang2 = "Andi Setiawan";
        $penerbit2 = "Elex Media";
        $tahun2 = 2022;
        $harga2 = 95000;
        $stok2 = 10;
        $isbn2 = "978-602-2222-11-3";
        $kategori2 = "Database";
        $bahasa2 = "Indonesia";
        $halaman2 = 250;
        $berat2 = 400;

        // buku tambahan
        $judul3 = "HTML & CSS Modern Design";
        $pengarang3 = "John Doe";
        $penerbit3 = "Tech Press";
        $tahun3 = 2021;
        $harga3 = 110000;
        $stok3 = 5;
        $isbn3 = "978-602-3333-44-5";
        $kategori3 = "Web Design";
        $bahasa3 = "Inggris";
        $halaman3 = 280;
        $berat3 = 450;

        // buku tambahan
        $judul4 = "Python for Data Science";
        $pengarang4 = "Jane Smith";
        $penerbit4 = "Data Press";
        $tahun4 = 2024;
        $harga4 = 150000;
        $stok4 = 12;
        $isbn4 = "978-602-4444-88-1";
        $kategori4 = "Programming";
        $bahasa4 = "Indonesia";
        $halaman4 = 400;
        $berat4 = 600;

        // Tambahan badge 
        function badgeKategori($kategori) {
            if ($kategori == "Programming") return "bg-success";
            if ($kategori == "Database") return "bg-warning";
            if ($kategori == "Web Design") return "bg-info";
            return "bg-secondary";
        }
        ?>
        
        <div class="row">
            <!-- card buku 1 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h5><?php echo $judul1; ?></h5>
                        <span class="badge <?php echo badgeKategori($kategori1); ?>">
                            <?php echo $kategori1; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr><th>Pengarang</th><td>: <?php echo $pengarang1; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit1; ?></td></tr>
                            <tr><th>Tahun</th><td>: <?php echo $tahun1; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn1; ?></td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga1,0,',','.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok1; ?> buku</td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa1; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman1; ?></td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat1; ?> gram</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- card buku 2 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h5><?php echo $judul2; ?></h5>
                        <span class="badge <?php echo badgeKategori($kategori2); ?>">
                            <?php echo $kategori2; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr><th>Pengarang</th><td>: <?php echo $pengarang2; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit2; ?></td></tr>
                            <tr><th>Tahun</th><td>: <?php echo $tahun2; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn2; ?></td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga2,0,',','.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok2; ?> buku</td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa2; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman2; ?></td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat2; ?> gram</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- card buku 3 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h5><?php echo $judul3; ?></h5>
                        <span class="badge <?php echo badgeKategori($kategori3); ?>">
                            <?php echo $kategori3; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr><th>Pengarang</th><td>: <?php echo $pengarang3; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit3; ?></td></tr>
                            <tr><th>Tahun</th><td>: <?php echo $tahun3; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn3; ?></td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga3,0,',','.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok3; ?> buku</td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa3; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman3; ?></td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat3; ?> gram</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- card buku 4 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h5><?php echo $judul4; ?></h5>
                        <span class="badge <?php echo badgeKategori($kategori4); ?>">
                            <?php echo $kategori4; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr><th>Pengarang</th><td>: <?php echo $pengarang4; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit4; ?></td></tr>
                            <tr><th>Tahun</th><td>: <?php echo $tahun4; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn4; ?></td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga4,0,',','.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok4; ?> buku</td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa4; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman4; ?></td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat4; ?> gram</td></tr>
                        </table>
                    </div>
                </div>
            </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>