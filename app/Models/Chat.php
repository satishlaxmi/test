<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table ="chat";

    protected $fillable =[
        'sender_id',
        'reciver_id',
        "confirmed",
        "reciver_msg",
        "reciver_msg"
    ];

    

}
