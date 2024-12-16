<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BookingComment extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'booking_comments';
    protected $fillable =
    [

        "booking_id",
        'usernumber',
        'userid',
        'username',
        'userlevel',
        'comment',
        'type',
    ];


    public $translatable = ['filename'];

    public function Booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
}
