<?php

namespace App\Models\Market;

use App\Models\Market\Order;
use App\Models\Market\Product;
use App\Models\Market\Guarantee;
use App\Models\Market\AmazingSale;
use App\Models\Market\ProductColor;
use Illuminate\Database\Eloquent\Model;
use App\Models\Market\OrderItemSelectedAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function singleProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function amazingSale()
    {
        return $this->belongsTo(AmazingSale::class);
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }

    public function orderItemAttributes()
    {
        return $this->hasMany(OrderItemSelectedAttribute::class);
    }
}