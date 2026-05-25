<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataList = [
            [
                'nama_kategori' => 'Programming',
                'deskripsi' => 'Kategori buku programming',
                'icon' => 'code-slash',
                'warna' => 'primary'
            ],
            [
                'nama_kategori' => 'Database',
                'deskripsi' => 'Kategori buku database',
                'icon' => 'database',
                'warna' => 'success'
            ],
            [
                'nama_kategori' => 'Web Design',
                'deskripsi' => 'Kategori buku web design',
                'icon' => 'palette',
                'warna' => 'info'
            ],
            [
                'nama_kategori' => 'Networking',
                'deskripsi' => 'Kategori buku networking',
                'icon' => 'wifi',
                'warna' => 'warning'
            ],
            [
                'nama_kategori' => 'Data Science',
                'deskripsi' => 'Kategori buku data science',
                'icon' => 'graph-up',
                'warna' => 'danger'
            ],
        ];

        foreach ($dataList as $item) {
            Kategori::create($item);
        }
    }
}
