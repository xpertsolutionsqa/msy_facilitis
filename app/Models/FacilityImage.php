<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FacilityImage extends Model
{
    use HasFactory;

    protected $table = 'facility_images';
    protected $fillable =
    [
        "facility_id",
        "url",
    ];




    public function Facilitiy()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}
