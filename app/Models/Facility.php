<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Facility extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'facilities';
    protected $fillable =
    [
        "clubId",
        "number",
        "title",
        "zone",
        "street",
        "building",
        "location",
        "space",
        "capacity",
        "type",
        "owner",
        "status"
    ];

    public $translatable = ['title'];
    public $appends = ['fulladdress'];

    public function getFullAddressAttribute()
    {

        return __('Zone') . " " . $this->zone . " | " . __('Street No') . " " . $this->street . " | " . __("Building No") . " " . $this->building;
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'clubId');
    }
    public function FacilitiyType()
    {
        return $this->belongsTo(FacilityTypes::class, 'type');
    }
    public function SubFacilities()
    {
        return $this->hasMany(SubFacility::class, 'facility_id');
    }
    public function Images()
    {
        return $this->hasMany(FacilityImage::class, 'facility_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'facility_id');
    }
    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'facility_id');
    }
}
