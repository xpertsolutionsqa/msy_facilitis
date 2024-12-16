<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Attachment extends Model
{
    use HasFactory,HasTranslations;

    protected $table = 'attachment';
    protected $fillable =
    [
        "name",
        "accept",
        "max",
        "required",
        "status",
    ];

    public $translatable = ['name'];
}
