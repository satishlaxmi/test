<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friends extends Model
{
    use HasFactory;

    protected $table ="friends";

    protected $fillable =[
        
        'my_id',
    'friend_id',
       'ny_messgae',
       
    ];
}
