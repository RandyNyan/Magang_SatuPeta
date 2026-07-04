<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Kategori;
use App\Models\Organisasi;
use App\Models\OpenLayer;

class Maps extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit
    protected $table = 'maps';

    // Supaya semua kolom bisa diisi (Mass Assignment)
    protected $guarded = ['id'];

    // Cast attributes
    protected $casts = [
        'style_rules' => 'array',
    ];

    // Relasi ke tabel Kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi ke tabel Organisasi
    public function organisasi(): BelongsTo
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }

    // Relasi ke tabel Open Layer
    public function openLayer(): BelongsTo
    {
        return $this->belongsTo(OpenLayer::class, 'open_layer_id');
    }
}
