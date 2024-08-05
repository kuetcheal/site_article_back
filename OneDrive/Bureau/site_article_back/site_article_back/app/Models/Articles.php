<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'imagearticle',
    ];

    /**
     * Les attributs qui devraient être castés en types natifs.
     *
     * @var array
     */
    protected $casts = [
        'prix' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}