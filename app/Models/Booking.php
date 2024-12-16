<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $fillable =
    [
        "color",
        "number",
        "facility_id",
        "sub_facility_ids",
        "days",
        "start_date",
        "end_date",
        "start_time",
        "end_time",
        "UID",
        "uNo",
        "event_name",
        "particpations",
        "cname",
        "cphone",
        "cemail",
        "notes",
        "status",
        "level2commented",
        "level3commented",
        "reject_comment",
        "approval_date",
        "rejection_date",
        "status",
    ];

    protected $appends = ['fullstart', 'fullend', 'htmlstatus', 'fullhtmlstatus'];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'usernumber', 'UID');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'number', 'UID');
    }
    public function Files()
    {
        return $this->hasMany(BookingFile::class, 'booking_id');
    }
    public function Comments()
    {
        return $this->hasMany(BookingComment::class, 'booking_id');
    }

    public function UserOrClient()
    {

        $client = Client::where('number', $this->UID)->first();

        if ($client) {
            return $client;
        }

        $user = User::where('usernumber', $this->UID)->first();

        if ($user) {
            return $user;
        }
        return null;
    }


    public function getFullstartAttribute()
    {
        return $this->start_date . " " . $this->start_time;
    }
    public function getFullendAttribute()
    {
        return $this->end_date . " " . $this->end_time;
    }
    public function getsubsAttribute()
    {
        $subfacilityIds = explode(',', $this->sub_facility_ids);
        return SubFacility::whereIn('id', $subfacilityIds)->get();
    }
    public function CanAct()
    {
        $result = false;
        if (Auth::check()) {
            $level = auth()->user()->level;
            if ($level == '1' && $this->status == '1') {
                $result = true;
            }
            if ($level == '4' && $this->status == '2') {
                $result = true;
            }
            if ($level == '5' && $this->status == '3') {
                $result = true;
            }
        }

        return $result;
    }
    public function CanComment()
    {
        $result = false;
        if (Auth::check()) {
            $level = auth()->user()->level;
            if ($level == '2' && $this->level2commented == '0') {
                $result = true;
            }
            if ($level == '3' && $this->level3commented == '0') {
                $result = true;
            }
            // if ($level == '3' && $this->status == '2') {
            //     $result = true;
            // }
        }

        return $result;
    }
    public function getHtmlstatusAttribute()
    {
        if (Auth::check()) {

            $html = "";


            switch ($this->status) {
                case '0':

                    return '<span class="badge badge-secondary">' . __('Retreuned For Edit') . '</span>' . $html;
                    break;
                case '1':
                    return '<span class="badge badge-info">' . __('New') . '</span>' . $html;
                    break;
                case '2':
                    return '<span class="badge badge-warning">' . __('Div Manger Approval') . '</span>' . $html;
                    break;
                case '3':
                    return '<span class="badge badge-warning">' . __('Dep Manger Approval') . '</span>' . $html;
                    break;
                case '4':
                    return '<span class="badge badge-success">' . __('Approved') . '</span>' . $html;
                    break;
                case '5':
                    return '<span class="badge badge-danger">' . __('Rejected') . '</span>' . $html;
                    break;
                case '7':
                    return '<span class="badge badge-danger">' . __('Canceld') . '</span>' . $html;
                    break;

                default:
                    return '<span class="badge badge-warning">' . __('Pending') . '</span>' . $html;
                    break;
            }
        } elseif (Auth::guard('client')->check()) {
            switch ($this->status) {
                case '0':
                    return '<span class="badge badge-secondary">' . __('Retreuned For Edit') . '</span>';
                    break;
                case '1':
                    return '<span class="badge badge-info">' . __('New') . '</span>';
                    break;
                case '1':
                    return '<span class="badge badge-warning">' . __('Pending') . '</span>';
                    break;
                case '4':
                    return '<span class="badge badge-success">' . __('Approved') . '</span>';
                    break;
                case '5':
                    return '<span class="badge badge-danger">' . __('Rejected') . '</span>';
                    break;
                case '6':
                    return '<span class="badge badge-danger">' . __('Canceled') . '</span>';
                    break;

                default:
                    return '<span class="badge badge-warning">' . __('Pending') . '</span>';
                    break;
            }
        } else {
            return '';
        }
    }
    public function getFullHtmlstatusAttribute()
    {
        if (Auth::check()) {

            $html = "";
            if ($this->level2commented != '0') {
                $title1 = '';
                $comment1 = BookingComment::where('booking_id', $this->id)->where('userlevel', '2')->first();
                if ($comment1) {
                    $title1 = $comment1->comment;
                }
                $html = $html . "<br><small title='" . $title1 . "' class='badge badge-light hidewhenexport'>" . __("messages.Asset Commented") . "</small> ";
            }
            if ($this->level3commented != '0') {
                $title2 = '';
                $comment2 = BookingComment::where('booking_id', $this->id)->where('userlevel', '3')->first();
                if ($comment2) {
                    $title2 = $comment2->comment;
                }

                $html = $html . "<br><small title='" . $title2 . "' class='badge badge-light hidewhenexport'>" . __("messages.Facility Commented") . "</small>";
            }
            switch ($this->status) {
                case '0':

                    return '<span class="badge badge-secondary">' . __('Retreuned For Edit') . '</span>' . $html;
                    break;
                case '1':
                    return '<span class="badge badge-info">' . __('New') . '</span>' . $html;
                    break;
                case '2':
                    return '<span class="badge badge-warning">' . __('Div Manger Approval') . '</span>' . $html;
                    break;
                case '3':
                    return '<span class="badge badge-warning">' . __('Dep Manger Approval') . '</span>' . $html;
                    break;
                case '4':
                    return '<span class="badge badge-success">' . __('Approved') . "<br> " . $this->approval_date . '</span>' . $html;
                    break;
                case '5':
                    return '<span class="badge badge-danger">' . __('Rejected') . "<br> " . $this->rejection_date . '</span>' . $html;
                    break;
                case '7':
                    return '<span class="badge badge-danger">' . __('Canceld') . '</span>' . $html;
                    break;

                default:
                    return '<span class="badge badge-warning">' . __('Pending') . '</span>' . $html;
                    break;
            }
        } elseif (Auth::guard('client')->check()) {
            switch ($this->status) {
                case '0':
                    return '<span class="badge badge-secondary">' . __('Retreuned For Edit') . '</span>';
                    break;
                case '1':
                    return '<span class="badge badge-info">' . __('New') . '</span>';
                    break;
                case '2':
                    return '<span class="badge badge-warning">' . __('Pending') . '</span>';
                    break;
                case '4':
                    return '<span class="badge badge-success">' . __('Approved') . '</span>';
                    break;
                case '5':
                    return '<span class="badge badge-danger">' . __('Rejected') . '</span>';
                    break;
                case '6':
                    return '<span class="badge badge-danger">' . __('Canceled') . '</span>';
                    break;

                default:
                    return '<span class="badge badge-warning">' . __('Pending') . '</span>';
                    break;
            }
        } else {
            return '';
        }
    }
}
