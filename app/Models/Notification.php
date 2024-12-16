<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Notification extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'notifications';
    protected $fillable =
    [
        "user_id",
        "title",
        "content",
        "url",
        "read",
        "deleted",
    ];

    public $translatable = ['title', 'content'];

    public function User()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
