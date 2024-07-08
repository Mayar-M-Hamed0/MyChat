<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversation extends Model
{
    use HasFactory;

        protected $fillable =[
            'name',
            'type',
            'created_by'
        ];
    public function participants(){
        return $this->belongsToMany(User::class,'participants');
    }

    public function messages(){
        return $this->hasMany(message::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}
