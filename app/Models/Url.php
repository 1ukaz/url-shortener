<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'original_url',
        'shortened_url',
        'user_identifier',
    ];

    /**
     * El attribute must be unique.
     *
     * @var array
     */
    protected $unique = [
        'code',
    ];
}
