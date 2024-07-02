<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class message extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'conversation_id', 'user_id', 'message', 'file_path','type'
    ];

    public function conversation(){
        return $this->belongsTo(conversation::class);
    }

    public function user(){
        return $this->belongsTo(user::class);
    }


    public function react(){
        return $this->hasMany(reaction::class);
    }


}
