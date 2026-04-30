-- ========= TABEL KATEGORI ==========
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========== TABEL PENERBIT =========
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========= MODIFIKASI BUKU ==========
-- Tambah kolom baru (jika belum ada)
ALTER TABLE buku 
ADD COLUMN id_kategori INT,
ADD COLUMN id_penerbit INT;

-- Tambahkan foreign key
ALTER TABLE buku 
ADD CONSTRAINT fk_kategori 
FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori);

ALTER TABLE buku 
ADD CONSTRAINT fk_penerbit 
FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit);


-- ========= INSERT DATA KATEGORI (5) ==========
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Programming', 'Buku tentang pemrograman'),
('Database', 'Buku tentang basis data'),
('Jaringan', 'Buku tentang jaringan komputer'),
('AI', 'Buku tentang kecerdasan buatan'),
('Web Development', 'Buku tentang pengembangan web');


-- ========== INSERT DATA PENERBIT (5) =========
INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Informatika', 'Bandung', '0811111111', 'info@informatika.com'),
('Elex Media', 'Jakarta', '0822222222', 'info@elex.com'),
('Gramedia', 'Jakarta', '0833333333', 'info@gramedia.com'),
('Andi Offset', 'Yogyakarta', '0844444444', 'info@andi.com'),
('Deepublish', 'Yogyakarta', '0855555555', 'info@deepublish.com');


-- ========= INSERT DATA BUKU (15) ==========
INSERT INTO buku (kode_buku, judul, pengarang, tahun_terbit, harga, stok, id_kategori, id_penerbit) VALUES
('BK-101','Belajar Python', 'Budi Raharjo', 2023, 90000, 10, 1, 1),
('BK-102','Mastering Java', 'Andi Setiawan', 2022, 120000, 5, 1, 2),
('BK-103','Dasar Database', 'Rina Sari', 2024, 80000, 8, 2, 3),
('BK-104','MySQL Lanjut', 'Budi Raharjo', 2023, 95000, 3, 2, 2),
('BK-105','Jaringan Komputer', 'Agus Salim', 2021, 100000, 7, 3, 4),
('BK-106','AI untuk Pemula', 'Dewi Lestari', 2024, 110000, 6, 4, 5),
('BK-107','Machine Learning', 'Andi Setiawan', 2023, 130000, 4, 4, 1),
('BK-108','HTML & CSS', 'Rina Sari', 2022, 70000, 12, 5, 3),
('BK-109','JavaScript Dasar', 'Budi Raharjo', 2023, 85000, 9, 5, 2),
('BK-110','PHP & MySQL', 'Agus Salim', 2024, 95000, 2, 5, 4),
('BK-111','Laravel Framework', 'Dewi Lestari', 2023, 105000, 6, 5, 5),
('BK-112','Cisco Networking', 'Andi Setiawan', 2022, 125000, 5, 3, 1),
('BK-113','Data Science', 'Rina Sari', 2024, 115000, 7, 4, 2),
('BK-114','Algoritma Dasar', 'Budi Raharjo', 2021, 75000, 11, 1, 3),
('BK-115','React JS', 'Agus Salim', 2023, 98000, 8, 5, 4);


-- ========= QUERY JOIN ==========

-- 1. Tampilkan buku + kategori + penerbit
SELECT b.judul, b.pengarang, k.nama_kategori, p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;


-- 2. Jumlah buku per kategori
SELECT k.nama_kategori, COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
GROUP BY k.nama_kategori;


-- 3. Jumlah buku per penerbit
SELECT p.nama_penerbit, COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
GROUP BY p.nama_penerbit;


-- 4. Detail lengkap buku
SELECT 
    b.judul,
    b.pengarang,
    b.tahun_terbit,
    b.harga,
    b.stok,
    k.nama_kategori,
    p.nama_penerbit,
    p.alamat
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;