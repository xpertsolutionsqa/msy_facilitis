<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubFacility extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'sub_facilities';
    protected $fillable =
    [

        "facility_id",
        "title",
        "description",
        "size",
        "type",
        "status",
    ];


    public $translatable = ['title'];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->getTranslation('title', $locale);
    }

    public function Facilitiy()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function Images()
    {
        return $this->hasMany(SubFacilityImage::class,  'sfacility_id');
    }
    public function Types()
    {
        return $this->belongsTo(SubFacilityTypes::class,  'type');
    }
}
