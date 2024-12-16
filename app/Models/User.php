<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "usernumber",
        "displayname",
        "username",
        "email",
        "phone",
        "locale",
        "level",
        "status",
        "club_id",
        "add_facility",
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

    protected $appends = ['usertype'];

    public function Notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }
    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')
            ->where('read', 0);
    }
    public function undeleteNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')
            ->where('deleted', 0);
    }
    


    public function getUserTypeAttribute()
    {

        if ($this->type == 0) {
            $level = '';

            $userlevel = UserLevel::find($this->level);
            if ($userlevel) {
                $level = $userlevel->name;
            }


            return  $level;
        } else {
            $usertype = UserType::where('id', $this->type)->first();
            if ($usertype) {
                return  $usertype->title;
            }
            return '';
        }
    }

    public function Bookings()
    {
        return $this->hasMany(Booking::class, 'UID', 'id');
    }
    public function UserLevel()
    {
        return $this->belongsTo(UserLevel::class, 'level');
    }
    public function BookingComments()
    {
        return $this->hasMany(BookingComment::class, 'userid', 'id');
    }
    public function Maintenances()
    {
        return $this->hasMany(Maintenance::class, 'requester', 'id');
    }


    public function inlevel($levels)
    {

        return in_array($this->level, $levels);
    }


    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }
}
