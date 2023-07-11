<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemCategory;
use DateTime;
use DateTimeZone;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_category';

    protected $fillable = ['id','category_id','name'];


    public function category()
    {
       return $this->belongsTo(ItemCategory::class,'category_id','id');
    }

    public function getCreatedAtAttribute($value)
    {
        $dt = new DateTime($value);
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        return date_format($dt, 'j F Y h:i:s A');
    }
}
