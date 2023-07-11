<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    use HasFactory;

    public  $table = 'item_master';
    public $fillable = ['id','brand_id','sub_brand_id','category_id','subcategory_id','item_name','item_code','sellprice'];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subbrand()
    {
        return $this->belongsTo(SubBrand::class,'sub_brand_id','id');
    }

    public function getCreatedAtAttribute($value)
    {
        $dt = new DateTime($value);
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        return date_format($dt, 'j F Y h:i:s A');
    }

}
