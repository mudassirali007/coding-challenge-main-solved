<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function sentRequests(){
        // Relationship with Request Table based on sender_id
        return $this->hasMany(Request::class, 'sender_id')->where('accepted', 0);
    }

    public function receivedRequests(){
        // Relationship with Request Table based on receiver_id
        return $this->hasMany(Request::class, 'receiver_id')->where('accepted', 0);
    }

    // All Requests Merge (Both Sent and Received)
    public function allRequests(){
        return $this->sentRequests->merge($this->receivedRequests);
    }

    // First getting the both connections that are through Sent Request and Received Request then Merging them Together
    public function sentConnections(){
        return $this->hasMany(Request::class, 'sender_id')->where('accepted', 1);
    }

    public function receivedConnections(){
        return $this->hasMany(Request::class, 'receiver_id')->where('accepted', 1);
    }

    public function connections(){
        return $this->sentConnections->merge($this->receivedConnections);
    }

    // All users that are neither in Requests nor in Connections
    public function suggestions(){

        $allConnections = $this->allRequests()->merge($this->connections());
        $excludedUsers = $allConnections->map->only('sender_id','receiver_id')->flatten()->unique();
    
        return User::whereNotIn('id', $excludedUsers)->get();
    }


}
