<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'displayname',
        'email',
        'password',
        'number',
        'username',
        'email',
        'phone',
        'password',
        'type',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['clienttype'];


    public function getClientTypeAttribute()
    {

        $usertype = UserType::where('id', $this->type)->first();
        if ($usertype) {
            return  $usertype->title;
        }
        return '';
    }
}
