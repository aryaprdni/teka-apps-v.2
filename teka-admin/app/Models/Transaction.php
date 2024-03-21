<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;



class Transaction extends Model
{
    protected $connection = 'mongodb';
    protected $table = "transaction";
    protected $primarykey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = ['status', 'pending', 'sub_amount', 'user_id', 'diamond_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    public function diamond()
    {
        return $this->belongsTo(Diamond::class, 'diamond_id', '_id');
    }
}
