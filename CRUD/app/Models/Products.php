<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Products extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'products'; 
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];
}
