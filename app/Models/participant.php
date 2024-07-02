<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participant extends Model
{
    use HasFactory;
    protected $fillable=[
        'conversations_id',
        'user_id',
        'role',
        'joined_at'
    ];
    public function conversation(){
        return $this->belongsTo(conversation::class);
    }

    public function member(){
        return $this->belongsTo(user::class);
    }
}
