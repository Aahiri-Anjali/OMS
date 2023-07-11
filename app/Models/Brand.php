<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubBrand;
use DateTime;
use DateTimeZone;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = ['id','name'];

    public function subbrand()
    {
        return $this->hasMany(SubBrand::class);
    }


    public function getCreatedAtAttribute($value)
    {
        $dt = new DateTime($value);
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        return date_format($dt, 'j F Y h:i:s A');
    }
}
