<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubFacilityImage extends Model
{
    use HasFactory;

    protected $table = 'sub_facility_images';
    protected $fillable =
    [

        "sfacility_id",
        "url",
    ];




    public function SubFacility()
    {
        return $this->belongsTo(SubFacility::class, 'sfacility_id');
    }
}
