<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'firstname',
        'email',
        'address',
        'city',
        'state',
        'zip'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
