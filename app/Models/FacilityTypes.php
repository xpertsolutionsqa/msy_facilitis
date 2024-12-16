<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FacilityTypes extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'facility_types';
    protected $fillable =  ["name", "status"];

    public $translatable = ['name'];

    public function Facilities()
    {
        return $this->hasMany(Facility::class, 'type');
    }
}
