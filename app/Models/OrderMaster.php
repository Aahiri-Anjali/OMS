<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    use HasFactory;

    public $table = 'order_masters';
    public $fillable =['order_detail_id','date','status'];

    public function order_detail()
    {
        return $this->belongsTo(Order_detail::class);
    }
}
