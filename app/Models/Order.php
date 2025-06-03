<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['user_id', 'discount', 'note','payment_status', 'payment_method', 'order_status', 'amount_paid', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class);
    }
}
