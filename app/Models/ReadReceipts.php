<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadReceipts extends Model
{
    use HasFactory;

    protected $fillable=[
        'message_id',
        'user_id',
        'delivered',
        'read_at',
    ];

    public function message(){
        return $this-> belongsTo(message::class);
    }

    public function user(){
        return $this-> belongsTo(user::class);
    }
}
