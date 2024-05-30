<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_status',
        'order_status',
        'payment_type',
        'total',
        'tnx_id',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class);
    }
}

?>