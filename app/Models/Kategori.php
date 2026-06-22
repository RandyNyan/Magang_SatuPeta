<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Maps;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['nama_kategori'];

    public function maps(): HasMany
    {
        return $this->hasMany(Maps::class, 'kategori_id');
    }
}
