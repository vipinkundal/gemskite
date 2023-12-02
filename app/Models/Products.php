<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
        'stone_name',
        'shape',
        'size',
        'piece',
        'gross_weight',
        's_w',
        'line',
        'net_weight',
        'price',
        'color',
        'description',
    ];
}
