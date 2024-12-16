<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserLevel extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'users_levels';
    protected $fillable = ['name', 'status'];

    public $translatable = ['name'];

    public function Users()
    {
        return $this->hasMany(User::class, 'id');
    }
}
