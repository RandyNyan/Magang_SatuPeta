<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpenLayer extends Model
{
    use HasFactory;

    protected $table = 'open_layers';

    protected $guarded = ['id'];

    protected $casts = [
        'style_rules' => 'array',
    ];

    public function maps(): HasMany
    {
        return $this->hasMany(Maps::class, 'open_layer_id');
    }
}
