<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
<<<<<<< HEAD
        'slug',
=======
>>>>>>> abf70130a6b3add7269e80a3c226d04f2f7bf96d
        'price',
        'images',
        'description',
    ];
}
