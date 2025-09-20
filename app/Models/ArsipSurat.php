<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipSurat extends Model
{
    use HasFactory;

    protected $table = 'arsip_surat';

    protected $fillable = [
        'nomor_surat',
        'judul_surat',
        'kategori_id',
        'tanggal_surat',
        'file_path',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }
}
