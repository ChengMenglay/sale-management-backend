<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','category_id','barcode','detail','stock','tax','image','status'];

    protected $table='product';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }   

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }}
