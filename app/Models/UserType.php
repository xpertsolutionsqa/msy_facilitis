<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserType extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'users_types';
    protected $fillable = ['title', 'status'];

    public $translatable = ['title'];
}
