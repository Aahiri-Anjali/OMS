<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory,HasApiTokens;

    public $table = 'customers';

    public $fillable = ['id','name','contact_no','VATNO','email','password'];

    public function getCreatedAtAttribute($value)
    {
        $dt = new DateTime($value);
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        return date_format($dt, 'j F Y h:i:s A');
    }

}
