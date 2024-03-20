<?php

namespace App\Models;

// use MongoDB\Laravel\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $connection = 'mongodb';
    protected $table = "admin";
    protected $primarykey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;
    
    protected $guard = 'admin';
    protected $fillable = ['email', 'password', 'image', 'name'];
    protected $hidden = ['password'];
}

