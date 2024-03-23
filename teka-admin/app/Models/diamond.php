<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Diamond extends Model
{
    protected $connection = 'mongodb';
    protected $collection = "diamond";
    protected $primaryKey = "_id";
    protected $keyType = "string";

    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['image', 'quantity', 'price'];

    // Accessor untuk mengonversi quantity dari string ke integer saat diakses
    public function getQuantityAttribute($value)
    {
        return (int) $value;
    }

    // Accessor untuk mengonversi price dari string ke integer saat diakses
    public function getPriceAttribute($value)
    {
        return (int) $value;
    }

    // Definisikan relasi jika diperlukan
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'diamond_id', '_id');
    }
}
