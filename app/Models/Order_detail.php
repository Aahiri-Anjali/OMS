<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order_detail extends Model
{
    use HasFactory;

    protected $table = "order_details";
    protected $fillable = ['order_uid','customer_id','item_id','date','price','amount','quantity'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function item()
    {
        return $this->belongsTo(ItemMaster::class);
    }

    public function orderMaster()
    {
        return $this->hasOne(OrderMaster::class,'order_detail_id','id');
    }

}
