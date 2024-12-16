<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Club extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'clubs';

    public $fillable = ['name'];
    public $translatable = ['name'];



    public function facilities()
    {
        return $this->hasMany(Facility::class, 'clubId');
    }
    public function manager()
    {
        return $this->hasMany(User::class, 'club_id');
    }
}
