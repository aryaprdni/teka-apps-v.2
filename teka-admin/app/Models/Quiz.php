<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;



class Quiz extends Model
{
    protected $connection = 'mongodb';
    protected $table = "quiz";
    protected $primarykey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = ['question', 'answer', 'option1', 'option2', 'option3'];
}
