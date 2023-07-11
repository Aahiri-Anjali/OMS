<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use DateTime;
use DateTimeZone;

class SubBrand extends Model
{
    use HasFactory;

    protected $table = 'sub_brand';

    protected $fillable = ['id','brand_id','name'];

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

    public function getCreatedAtAttribute($value)
    {
        $dt = new DateTime($value);
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        return date_format($dt, 'j F Y h:i:s A');
    }
}
