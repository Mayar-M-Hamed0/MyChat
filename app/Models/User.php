<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'status',
        'Bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

public function message(){
    return $this->hasMany(message::class);
}

public function conversation(){
    return $this->belongsToMany(conversation::class,'participants')->latest('last_message_id')->withPivot('role');
}

public function reactions(){
    return $this->hasMany(reaction::class);
}

public function received(){
    return $this->belongsToMany(message::class,'ReadReceipts')->withPivot('read_at','delivered','delted_at');
}


public function friends()
{
    return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                ->withPivot('status')
                ->wherePivot('status', 'accepted');
}

public function friendRequests()
{
    return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                ->withPivot('status')
                ->wherePivot('status', 'pending');
}

}
