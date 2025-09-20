<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArsipSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arsipSurat = [
            [
                'nomor_surat' => '2022/PD3/TU/001',
                'judul_surat' => 'Nota Dinas WFH',
                'kategori_id' => 3, // Nota Dinas
                'tanggal_surat' => '2023-06-21',
                'file_path' => 'surat/sample1.pdf',
                'keterangan' => 'Nota dinas tentang Work From Home',
                'created_at' => '2023-06-21 17:23:00',
                'updated_at' => '2023-06-21 17:23:00',
            ],
            [
                'nomor_surat' => '2022/PD2/TU/022',
                'judul_surat' => 'Undangan Halal Bi Halal',
                'kategori_id' => 1, // Undangan
                'tanggal_surat' => '2023-04-21',
                'file_path' => 'surat/sample2.pdf',
                'keterangan' => 'Undangan acara halal bi halal',
                'created_at' => '2023-04-21 18:23:00',
                'updated_at' => '2023-04-21 18:23:00',
            ],
        ];

        foreach ($arsipSurat as $surat) {
            DB::table('arsip_surat')->insert($surat);
        }
    }
}
