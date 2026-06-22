<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organisasi extends Model
{
    protected $table = 'organisasi';

    protected $fillable = [
        'nama',
        'deskripsi',
        'alamat',
        'telepon',
        'email',
        'website',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'organisasi_id', 'id');
    }
}
