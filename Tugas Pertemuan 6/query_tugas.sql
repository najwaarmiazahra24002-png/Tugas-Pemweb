-- ========= STATISTIK BUKU ==========

-- 1. Total buku seluruhnya : Menghitung total seluruh buku dalam tabel
SELECT COUNT(*) AS total_buku FROM buku;

-- 2. Total nilai inventaris (harga × stok) : Menghitung total nilai inventaris (harga dikali stok semua buku)
SELECT SUM(harga * stok) AS total_nilai_inventaris FROM buku;

-- 3. Rata-rata harga buku : Menghitung rata-rata harga buku
SELECT AVG(harga) AS rata_rata_harga FROM buku;

-- 4. Buku termahal (judul dan harga) : Menampilkan buku dengan harga paling mahal
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC 
LIMIT 1;

-- 5. Buku dengan stok terbanyak Menampilkan buku dengan jumlah stok terbanyak
SELECT judul, stok 
FROM buku 
ORDER BY stok DESC 
LIMIT 1;


-- ========= FILTER DAN PENCARIAN ==========

-- 1. Buku kategori Programming dengan harga < 100000 : Menampilkan buku kategori Programming dengan harga kurang dari 100.000
SELECT * 
FROM buku 
WHERE kategori = 'Programming' 
AND harga < 100000;

-- 2. Buku dengan judul mengandung "PHP" atau "MySQL" : Menampilkan buku yang judulnya mengandung kata PHP atau MySQL
SELECT * 
FROM buku 
WHERE judul LIKE '%PHP%' 
OR judul LIKE '%MySQL%';

-- 3. Buku terbit tahun 2024 : Menampilkan buku yang terbit pada tahun 2024
SELECT * 
FROM buku 
WHERE tahun_terbit = 2024;

-- 4. Buku dengan stok antara 5-10 : Menampilkan buku dengan stok antara 5 sampai 10
SELECT * 
FROM buku 
WHERE stok BETWEEN 5 AND 10;

-- 5. Buku dengan pengarang "Budi Raharjo" : Menampilkan buku dengan pengarang Budi Raharjo
SELECT * 
FROM buku 
WHERE pengarang = 'Budi Raharjo';


-- ========= GROUPING DAN AGREGASI ==========

-- 1. Jumlah buku & total stok per kategori : Mengelompokkan buku berdasarkan kategori dan menghitung jumlah buku serta total stok
SELECT kategori, COUNT(*) AS jumlah_buku, SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;

-- 2. Rata-rata harga per kategori : Menghitung rata-rata harga buku pada setiap kategori
SELECT kategori, AVG(harga) AS rata_rata_harga
FROM buku
GROUP BY kategori;

-- 3. Kategori dengan total nilai inventaris terbesar : Menampilkan kategori dengan total nilai inventaris terbesar
SELECT kategori, SUM(harga * stok) AS total_nilai
FROM buku
GROUP BY kategori
ORDER BY total_nilai DESC
LIMIT 1;


-- ========== UPDATE DATA========

-- 1. Naikkan harga buku kategori Programming 5% : Menaikkan harga semua buku kategori Programming sebesar 5%
UPDATE buku
SET harga = ROUND(harga * 1.05)
WHERE kategori = 'Programming';

-- 2. Tambah stok 10 untuk buku dengan stok < 5 : Menambahkan stok sebanyak 10 untuk buku yang stoknya kurang dari 5
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;


-- ========= LAPORAN KHUSUS ==========

-- 1. Buku yang perlu restocking (stok < 5) : Menampilkan daftar buku yang perlu restocking (stok kurang dari 5)
SELECT * 
FROM buku 
WHERE stok < 5;

-- 2. Top 5 buku termahal : Menampilkan 5 buku dengan harga paling mahal
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC
LIMIT 5;