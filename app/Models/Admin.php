<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;

class Admin extends Authenticatable
{
    use HasFactory,HasApiTokens,HasRoles,HasPermissions;
   
    protected $guard = "admin";
    protected $table = "admins";

    protected $fillable = ['name','email','password'];
}
