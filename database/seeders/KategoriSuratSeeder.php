<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Undangan', 'keterangan' => 'Surat undangan resmi'],
            ['nama_kategori' => 'Pengumuman', 'keterangan' => 'Surat pengumuman kepada masyarakat'],
            ['nama_kategori' => 'Nota Dinas', 'keterangan' => 'Nota dinas internal'],
            ['nama_kategori' => 'Pemberitahuan', 'keterangan' => 'Surat pemberitahuan resmi'],
        ];

        foreach ($categories as $category) {
            DB::table('kategori_surat')->insert([
                'nama_kategori' => $category['nama_kategori'],
                'keterangan' => $category['keterangan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
