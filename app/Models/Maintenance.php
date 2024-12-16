<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenance';
    protected $fillable =
    [
        "color",
        "number",
        "facility_id",
        "days",
        "startDate",
        "endDate",
        "description",
        "team",
        "requester",
        "request_status",
        "status",
    ];


    protected $appends = ['days'];

    public function getDaysAttribute()
    {
        if ($this->startDate && $this->endDate) {
            return Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate));
        }

        return 0;
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'requester', 'id');
    }
}
