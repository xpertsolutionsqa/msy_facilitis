<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubFacilityTypes extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'sub_facility_types';
    protected $fillable =  ["name", "status"];

    public $translatable = ['name'];

    public function SubFacilities()
    {
        return $this->hasMany(SubFacility::class, 'id');
    }
}
