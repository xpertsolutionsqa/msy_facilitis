<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BookingFile extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'booking_files';
    protected $fillable =
    [
 
        "booking_id",
        "attachId",
        "filename",
        "url",
    ];


    public $translatable = ['filename'];

    public function Booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
