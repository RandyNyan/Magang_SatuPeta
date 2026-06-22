<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenLayer extends Model
{
    use HasFactory;

    // Force connection to PostgreSQL
    protected $connection = 'pgsql';

    protected $table = 'open_layers';

    protected $guarded = ['id'];

    // Automatically serialize/deserialize geojson
    protected $casts = [
        'geojson' => 'array',
    ];
}
