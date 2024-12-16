<?php

namespace App\Http\Controllers;

use App\Providers\NotificationService;
use App\Models\Ad;
use App\Models\Attachment;
use App\Models\Booking;
use App\Models\BookingComment;
use App\Models\BookingFile;
use App\Models\Facility;
use App\Models\Maintenance;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingsController extends Controller
{

    public function show(Request $request)
    {

        $number = $request->input('fa') ?? "";
        $query = Booking::with(['files']);
        if ($number != '') {

            $query->whereIn('facility_id', function ($query) use ($number) {
                $query->select('id')
                    ->from('facilities')
                    ->where('number', $number);
            });
        }

        if (Auth::check()) {
            $user = Auth::user();
            switch ($user->level) {
                case '1':

                    break;
                case '2':
                    // $query->whereIn('status', ['1','2', '3']);
                    break;
                case '3':
                    $clubId = $user->club_id;
                    //$query->whereIn('status', ['1','2', '3']);
                    $query->whereIn('facility_id', function ($query) use ($clubId) {
                        $query->select('id')
                            ->from('facilities')
                            ->where('clubId', $clubId);
                    });
                    break;
                case '4':
                    $query->where('status', '>', '1');
                    break;
                case '5':
                    $query->where('status', '>', '2');
                    break;

                default:
                    break;
            }
        } elseif (Auth::guard('client')->check()) {

            $user = Auth::guard('client')->user();

            $query->where('UID', $user->number);
        }

        $bookings = $query->get();

        return view('pages.bookings.index')->with([
            'bookings' => $bookings,
            'gridactive' => $request->gridactive,
            'listactive' => $request->listactive,
        ]);
    }

    public function EmployeeCreate(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back();
        }
        if ($user->level != '1') {
            return back();
        }

        $attachemnts = Attachment::where('status', '1')->get();

        foreach ($attachemnts as $key => $value) {
            if ($value->required == '1' &&   !$request->hasFile('attach_file' . $value->id)) {
                return back()->with(
                    [
                        'Responseerror' => "1",
                        'responseTxt' =>  $value->name . " " . __("File is required")
                    ]

                );
            }
            $fileSize = $request->file('attach_file' . $value->id)->getSize();
            $fileSizeInMB = $fileSize / 1048576;
            if ($fileSizeInMB > $value->max) {
                return back()->with([
                    'Responseerror' => "1",
                    'responseTxt' => $value->name . " " . __("File size exceeds the limit"),
                ]);
            }
        }

        $UID = $user->usernumber;
        $FaId = $request->input('FaId');
        $FaNum = $request->input('FaNum');
        $facility = Facility::where('id', $FaId)->where('number', $FaNum)->first();

        if (!$facility) {
            return back()->with(['Responseerror' => '1', 'responseTxt' => __('Coludnt find facility')]);
        }

        $from_date = $request->input('from_date') ?? "";
        $to_date = $request->input('to_date') ?? "";
        $from_time = $request->input('from_time');
        $to_time = $request->input('to_time');
        $booking_date = $request->input('booking_date') ?? "";
        $booking_type = $request->input('booking_type');
        $startDate = '';
        $endDate = '';


        if ($booking_type == '1') {
            $datetime1 = DateTime::createFromFormat('H:i', $from_time);
            $datetime2 = DateTime::createFromFormat('H:i', $to_time);
            $startDate = $booking_date;
            $endDate = $booking_date;

            if (!($datetime1 < $datetime2)) {

                dd($datetime2);
                return back()->with(['Responseerror' => '1', 'responseTxt' => __('Please Enter Correct Timming')]);
            }
        } else {
            $startDate = $from_date;
            $endDate = $to_date;
        }


        $number = $this->generateUniqueBookingNumber();

        $event_name = $request->input('event_name');
        $expected_number = $request->input('expected_number');

        $subs = $request->input('subs');
        $booking_days = $request->input('booking_days');
        $cname = $request->input('cname');
        $cphone = $request->input('cphone');
        $cemail = $request->input('cemail');
        $notes = $request->input('notes') ?? "";


        $sdate = DateTime::createFromFormat('n/j/Y', $startDate);
        $edate = DateTime::createFromFormat('n/j/Y', $endDate);
        $formattedsDate = $sdate->format('Y-m-d');
        $formattedeDate = $edate->format('Y-m-d');

        $booking = Booking::create([
            "number" => $number,
            "facility_id" => $FaId,
            "sub_facility_ids" => $subs,
            "days" => $booking_days,
            "start_date" => $formattedsDate,
            "end_date" => $formattedeDate,
            "start_time" => $from_time,
            "end_time" => $to_time,
            "UID" => $UID,
            "event_name" => $event_name,
            "particpations" => $expected_number,
            "cname" => $cname,
            "cphone" => $cphone,
            "cemail" => $cemail,
            "notes" => $notes,
            "color" => $this->randomHex(),
            "status" => '2',
        ]);

        foreach ($attachemnts as $key => $value) {
            if ($request->hasFile('attach_file' . $value->id)) {
                $file = $request->file('attach_file' . $value->id);
                $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $fileName = "MSY_" . $randomNumber . '_' . $number . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/bookingfiles/'), $fileName);

                BookingFile::create([
                    'filename' => [
                        'en' =>  $value->getTranslation('name', 'en'),
                        'ar' =>  $value->getTranslation('name', 'ar'),
                    ],
                    'attachId' => $value->id,
                    'booking_id' => $booking->id,
                    'url' => "uploads/bookingfiles/" . $fileName

                ]);
            }
        }


        $values = [
            "displayname" => $cname,
            'facilityname' => $facility->title,
            'bookingnumber' => $number,
            'startDate' => $formattedsDate . " " . $from_time,
            'endDate' => $formattedeDate . " " . $to_time,
            'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $number,

        ];
        $usersLv1 = User::where('level', '2')->where('status', '1')->get();
        foreach ($usersLv1 as $key => $userLv1) {
            $values2 = [
                "displayname" => $userLv1->displayname,
                'facilityname' => $facility->title,
                'bookingnumber' => $number,
                'startDate' => $formattedsDate . " " . $from_time,
                'endDate' => $formattedeDate . " " . $to_time,
                'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $number,

            ];
            Utility::SendEmail('new_booking_for_employee', $values2, 'Booking Order Received', $userLv1->email);
            Utility::createNotification($userLv1->id, 'طلب حجز جديد', 'New booking request', 'طلب حجز جديد للمنشأة ' . $facility->getTranslation('title', 'ar'), 'New booking request for ' . $facility->getTranslation('title', 'en'), "https://www.msy.gov.qa/sfb/public/booking-details/" . $number);

        }


        $clubId = $facility->clubId;
        $usersLv2 = User::where('level', '3')->where('club_id', $clubId)->get();
        foreach ($usersLv2 as $key => $user2) {
            $values3 = [
                "displayname" => $user2->displayname,
                'facilityname' => $facility->title,
                'bookingnumber' => $number,
                'startDate' => $formattedsDate . " " . $from_time,
                'endDate' => $formattedeDate . " " . $to_time,
                'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $number,

            ];
            Utility::SendEmail('new_booking_for_employee', $values3, 'Booking Order Received', $user2->email);
            Utility::createNotification($user2->id, 'طلب حجز جديد', 'New booking request', 'طلب حجز جديد للمنشأة ' . $facility->getTranslation('title', 'ar'), 'New booking request for ' . $facility->getTranslation('title', 'en'), "https://www.msy.gov.qa/sfb/public/booking-details/" . $number);

        }

        Utility::SendEmail('new_booking', $values, 'Booking Order Received', $cemail);

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Booking Request Sent")
            ]
        );
    }


    public function create(Request $request)
    {
        $client = Auth::guard('client')->user();
        if (!$client) {
            return back();
        }
        $attachemnts = Attachment::where('status', '1')->get();

        foreach ($attachemnts as $key => $value) {
            if ($value->required == '1' &&   !$request->hasFile('attach_file' . $value->id)) {
                return back()->with(
                    [
                        'Responseerror' => "1",
                        'responseTxt' =>  $value->name . " " . __("File is required")
                    ]

                );
            }
            $fileSize = $request->file('attach_file' . $value->id)->getSize();
            $fileSizeInMB = $fileSize / 1048576;
            if ($fileSizeInMB > $value->max) {
                return back()->with([
                    'Responseerror' => "1",
                    'responseTxt' => $value->name . " " . __("File size exceeds the limit"),
                ]);
            }
        }


        $UID =   $client->number;
        $FaId = $request->input('FaId');
        $FaNum = $request->input('FaNum');

        $facility = Facility::where('id', $FaId)->where('number', $FaNum)->first();

        if (!$facility) {
            return back()->with(['Responseerror' => '1', 'responseTxt' => __('Coludnt find facility')]);
        }

        $from_date = $request->input('from_date') ?? "";
        $to_date = $request->input('to_date') ?? "";
        $from_time = $request->input('from_time');
        $to_time = $request->input('to_time');
        $booking_date = $request->input('booking_date') ?? "";
        $booking_type = $request->input('booking_type');
        $startDate = '';
        $endDate = '';
        if ($booking_type == '1') {
            $datetime1 = DateTime::createFromFormat('H:i', $from_time);
            $datetime2 = DateTime::createFromFormat('H:i', $to_time);
            $startDate = $booking_date;
            $endDate = $booking_date;

            if (!($datetime1 < $datetime2)) {

                dd($datetime2);
                return back()->with(['Responseerror' => '1', 'responseTxt' => __('Please Enter Correct Timming')]);
            }
        } else {
            $startDate = $from_date;
            $endDate = $to_date;
        }


        $number = $this->generateUniqueBookingNumber();

        $event_name = $request->input('event_name');
        $expected_number = $request->input('expected_number');

        $subs = $request->input('subs');
        $booking_days = $request->input('booking_days');
        $cname = $request->input('cname');
        $cphone = $request->input('cphone');
        $cemail = $request->input('cemail');
        $notes = $request->input('notes') ?? "";


        $sdate = DateTime::createFromFormat('n/j/Y', $startDate);
        $edate = DateTime::createFromFormat('n/j/Y', $endDate);
        $formattedsDate = $sdate->format('Y-m-d');
        $formattedeDate = $edate->format('Y-m-d');

        $booking = Booking::create([

            "number" => $number,
            "facility_id" => $FaId,
            "sub_facility_ids" => $subs,
            "days" => $booking_days,
            "start_date" => $formattedsDate,
            "end_date" => $formattedeDate,
            "start_time" => $from_time,
            "end_time" => $to_time,
            "UID" => $UID,
            "event_name" => $event_name,
            "particpations" => $expected_number,
            "cname" => $cname,
            "cphone" => $cphone,
            "cemail" => $cemail,
            "notes" => $notes,
            "color" => $this->randomHex(),
            "status" => '1',
        ]);


        foreach ($attachemnts as $key => $value) {
            if ($request->hasFile('attach_file' . $value->id)) {
                $file = $request->file('attach_file' . $value->id);
                $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $fileName = "MSY_" . $randomNumber . '_' . $number . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/bookingfiles/'), $fileName);

                BookingFile::create([
                    'filename' => [
                        'en' =>  $value->getTranslation('name', 'en'),
                        'ar' =>  $value->getTranslation('name', 'ar'),
                    ],
                    'attachId' => $value->id,
                    'booking_id' => $booking->id,
                    'url' => "uploads/bookingfiles/" . $fileName

                ]);
            }
        }


        $values = [
            "displayname" => $cname,
            'facilityname' => $facility->title,
            'bookingnumber' => $number,
            'startDate' => $formattedsDate . " " . $from_time,
            'endDate' => $formattedeDate . " " . $to_time,
            'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $number,

        ];
        $usersLv1 = User::whereIn('level', ['1', '2'])->where('status', '1')->get();
        foreach ($usersLv1 as $key => $userLv1) {
            $values2 = [
                "displayname" => $userLv1->displayname,
                'facilityname' => $facility->title,
                'bookingnumber' => $number,
                'startDate' => $formattedsDate . " " . $from_time,
                'endDate' => $formattedeDate . " " . $to_time,
                'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $number,

            ];
            Utility::SendEmail('new_booking_for_employee', $values2, 'Booking Order Received', $userLv1->email);
            Utility::createNotification($userLv1->id, 'طلب حجز جديد', 'New booking request', 'طلب حجز جديد للمنشأة ' . $facility->getTranslation('title', 'ar'), 'New booking request for ' . $facility->getTranslation('title', 'en'), "https://www.msy.gov.qa/sfb/public/booking-details/" . $number);

        }


        $clubId = $facility->clubId;
        $usersLv2 = User::where('level', '3')->where('club_id', $clubId)->get();
        foreach ($usersLv2 as $key => $user2) {
            $values3 = [
                "displayname" => $user2->displayname,
                'facilityname' => $facility->title,
                'bookingnumber' => $number,
                'startDate' => $formattedsDate . " " . $from_time,
                'endDate' => $formattedeDate . " " . $to_time,
                'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $number,

            ];
            Utility::SendEmail('new_booking_for_employee', $values3, 'Booking Order Received', $user2->email);
            Utility::createNotification($user2->id, 'طلب حجز جديد', 'New booking request', 'طلب حجز جديد للمنشأة ' . $facility->getTranslation('title', 'ar'), 'New booking request for ' . $facility->getTranslation('title', 'en'), "https://www.msy.gov.qa/sfb/public/booking-details/" . $number);

        }

        Utility::SendEmail('new_booking', $values, 'Booking Order Received', $cemail);

        $values['displayname'] = $client->displayname;
        Utility::SendEmail('new_booking', $values, 'Booking Order Received', $client->email);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Booking Request Sent")
            ]
        );
    }

    public function showDetails($bookingNumber)
    {
        $client = false;
        $booking = Booking::with(['facility', 'files', 'comments.user', 'user'])->where('number', $bookingNumber)->first();

        if (!$booking) { 
            return back()->with(['Responseerror' => '1', 'responseTxt' => __("Couldnt find this booking")]);
        }

        $assetsComment =  BookingComment::where('booking_id', $booking->id)->where('userLevel', '2')->first();
        $facilityComment =  BookingComment::where('booking_id', $booking->id)->where('userLevel', '3')->first();


        if (Auth::check()) {
            $user = Auth::user();
        } elseif (Auth::guard('client')->check()) {
            $client = true;
            $user = Auth::guard('client')->user();
            if ($user->number != $booking->UID) {
                return redirect('403');
            }
        } else { 
            return redirect()->route('login')->withInput(['url' => route('booking.details', $bookingNumber)]);
        }


        $startDate = Carbon::parse($booking->start_date);
        $otherBookings = Booking::where('number', '!=', $bookingNumber)->where(
            'facility_id',
            $booking->facility_id,
        )
            ->whereMonth('start_date', $startDate->month)
            ->whereYear('start_date', $startDate->year)
            ->get();
        $otherMaintenance =  Maintenance::where(
            'facility_id',
            $booking->facility_id,
        )
            ->whereMonth('startDate', $startDate->month)
            ->whereYear('startDate', $startDate->year)
            ->get();



        return view($client ?   'pages.bookings.clientdetails' : 'pages.bookings.details')->with([
            "booking" => $booking,
            "otherBookings" => $otherBookings,
            "otherMaintenance" => $otherMaintenance,
            "assetsComment" => $assetsComment,
            "facilityComment" => $facilityComment,
        ]);
    }

    public function edit(Request $request)
    {
        $id  = $request->input('id');
        $number  = $request->input('number');
        $booking = Booking::with(['files'])->where('id', $id)->where('number', $number)->first();
        if (!$booking) {
            return back();
        }

        $start  = $request->input('start');
        list($sdate, $stime) = explode(' ', $start);
        $end  = $request->input('end');
        list($edate, $etime) = explode(' ', $end);

        $otherbookings = Booking::where('status', '5')->where('facility_id', $id)->where('id', '!=', $id)->where('start_date', '<=', $end)->where('end_date', '>=', $start)->count();

        if ($otherbookings > 0) {
            return back()->with([
                'Responsesuccess' => "1",
                'responseTxt' => __("Sorry there is event")
            ]);
        }

        $attachemnts = Attachment::where('status', '1')->get();
        $attids = $booking->files->pluck('attachId')->toArray();

        foreach ($attachemnts as $key => $value) {
            if (!in_array($value->id, $attids)  &&  $value->required == '1' &&   !$request->hasFile('attach_file' . $value->id)) {
                return back()->with(
                    [
                        'Responseerror' => "1",
                        'responseTxt' =>  $value->name . " " . __("File is required")
                    ]

                );
            }
            // $fileSize = $request->file('attach_file' . $value->id)->getSize();
            // $fileSizeInMB = $fileSize / 1048576;
            // if ($fileSizeInMB > $value->max) {
            //     return back()->with([
            //         'Responseerror' => "1",
            //         'responseTxt' => $value->name . " " . __("File size exceeds the limit"),
            //     ]);
            // }
        }
        foreach ($attachemnts as $key => $value) {
            if ($request->hasFile('attach_file' . $value->id)) {
                $file = $request->file('attach_file' . $value->id);
                $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $fileName = "MSY_" . $randomNumber . '_' . $number . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/bookingfiles/'), $fileName);

                BookingFile::updateOrCreate(
                    [

                        'attachId' => $value->id,
                        'booking_id' => $booking->id,
                    ],
                    [
                        'filename' => [
                            'en' =>  $value->getTranslation('name', 'en'),
                            'ar' =>  $value->getTranslation('name', 'ar'),
                        ],
                        'url' => "uploads/bookingfiles/" . $fileName

                    ]
                );
            }
        }

        $subs  = $request->input('subs');

        $event_name  = $request->input('event_name');
        $days  = $request->input('days');
        $particpations  = $request->input('particpations');

        $cname  = $request->input('cname');
        $cemail  = $request->input('cemail');
        $cphone  = $request->input('cphone');
        $notes  = $request->input('notes');



        $booking->update([


            "sub_facility_ids" => $subs,
            "days" => $days,
            "start_date" => $sdate,
            "end_date" => $edate,
            "start_time" => $stime,
            "end_time" => $etime,

            "event_name" => $event_name,
            "particpations" => $particpations,
            "cname" => $cname,
            "cemail" => $cemail,
            "cphone" => $cphone,
            "notes" => $notes,
            "status" => '1',
        ]);

        $values = [
            "displayname" => $booking->cname,
            'facilityname' => $booking->facility->title,
            'bookingnumber' => $booking->number,
            'startDate' => $booking->fullstart,
            'endDate' => $booking->fullend,
            'reject_comment' => $request->input('reject_reason'),
            'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number,

        ];

        $userslev2 = User::where('status', '1')->where('level', '1')->get();
        foreach ($userslev2 as $key => $userlev2) {
            $values['displayname'] =  $userlev2->displayname;
            $values['oldcomments'] =  $booking->reject_comment;
            Utility::SendEmail('booking_edited', $values, 'Booking has been updated', $userlev2->email);
            Utility::createNotification($userlev2->id, 'تعديل على بيانات الطلب ', 'Booking request updated', 'تم التعديل على بيانات الطلب رقم' . $booking->number, 'The request number' . $booking->number . " has been updated", "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number);

        }









        return redirect()->route('mybookings')->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' =>    __("Updated")
            ]

        );
    }


    public function approve(Request $request)
    {

        $booking = Booking::where("id", $request->input('id'))->where('number', $request->input('number'))->first();
        if (!$booking) {
            return back();
        }

        $user = Auth::user();
        if (!$user) {
            return back();
        }

        $comment = $request->input('comment') ?? '';

        $values = [
            "displayname" => $booking->cname,
            'facilityname' => $booking->facility->title,
            'bookingnumber' => $booking->number,
            'startDate' => $booking->fullstart,
            'endDate' => $booking->fullend,
            'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number,
        ];

        switch ($user->level) {
            case '1':
                $booking->update(['status' => '2']);
                if ($comment != '') {
                    BookingComment::create([
                        "booking_id" => $booking->id,
                        'usernumber' => $user->usernumber,
                        'userid' => $user->id,
                        'username' => $user->displayname,
                        'userlevel' => $user->level,
                        'comment' => $comment,
                    ]);
                }

                $values['currentuser'] = $user->displayname;
                $values['comment'] = $comment;
                $userslev2 = User::where('status', '1')->where('level', '4')->get();
                foreach ($userslev2 as $key => $userlev2) {
                    $values['displayname'] =  $userlev2->displayname;
                    Utility::SendEmail('booking_status_changed', $values, 'Booking Order Status Changed', $userlev2->email);
                    Utility::createNotification($userlev2->id, 'تغيير حالة الطلب', 'Request status update', 'تغيرت حالة الطلب رقم' . $booking->number, 'The request number' . $booking->number . " status has been changed", "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number);

                }

                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Approved")
                    ]

                );

                break;
            case '2':
                $type = $request->input('type');
                $booking->update(['level2commented' => '1']);
                if ($comment != '') {
                    BookingComment::create([
                        "booking_id" => $booking->id,
                        'usernumber' => $user->usernumber,
                        'userid' => $user->id,
                        'username' => $user->displayname,
                        'userlevel' => $user->level,
                        'comment' => $comment,
                        'type' => $type,
                    ]);
                }

                $values['currentuser'] = $user->displayname;
                $values['userlevel'] = $user->userLevel->name;
                $values['comment'] = $comment;
                $userslev1 = User::where('status', '1')->where('level', '1')->get();
                foreach ($userslev1 as $key => $userlev1) {
                    $values['displayname'] =  $userlev1->displayname;
                    Utility::SendEmail('booking_comment_added', $values, 'Booking Order Comment Added', $userlev1->email);
                    Utility::createNotification($userlev1->id, 'تمت إضافة تعليق', 'Booking Comment Added', 'تم إضافة تعليق للطلب رقم' . $booking->number, 'There is comment added for the request with the number' . $booking->number, "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number);

                }
                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Comment Added")
                    ]

                );

                break;
            case '3':
                $type = $request->input('type');
                $booking->update(['level3commented' => '1']);
                if ($comment != '') {
                    BookingComment::create([
                        "booking_id" => $booking->id,
                        'usernumber' => $user->usernumber,
                        'userid' => $user->id,
                        'username' => $user->displayname,
                        'userlevel' => $user->level,
                        'comment' => $comment,
                        'type' => $type,
                    ]);
                }
                $values['currentuser'] = $user->displayname;
                $values['userlevel'] = $user->userLevel->name;
                $values['comment'] = $comment;
                $userslev1 = User::where('status', '1')->where('level', '1')->get();
                foreach ($userslev1 as $key => $userlev1) {
                    $values['displayname'] =  $userlev1->displayname;
                    Utility::SendEmail('booking_comment_added', $values, 'Booking Order Comment Added', $userlev1->email);
                    Utility::createNotification($userlev1->id, 'تمت إضافة تعليق', 'Booking Comment Added', 'تم إضافة تعليق للطلب رقم' . $booking->number, 'There is comment added for the request with the number' . $booking->number, "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number);

                }
                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Comment Added")
                    ]

                );

                break;
            case '4':
                $booking->update(['status' => '3']);
                if ($comment != '') {
                    BookingComment::create([
                        "booking_id" => $booking->id,
                        'usernumber' => $user->usernumber,
                        'userid' => $user->id,
                        'username' => $user->displayname,
                        'userlevel' => $user->level,
                        'comment' => $comment,
                    ]);
                }

                $values['currentuser'] = $user->displayname;
                $values['comment'] = $comment;
                $userslev2 = User::where('status', '1')->where('level', '5')->get();
                foreach ($userslev2 as $key => $userlev2) {
                    $values['displayname'] =  $userlev2->displayname;
                    Utility::SendEmail('booking_status_changed', $values, 'Booking Order Status Changed', $userlev2->email);
                    Utility::createNotification($userlev2->id, 'تغيير حالة الطلب', 'Request status update', 'تغيرت حالة الطلب رقم' . $booking->number, 'The request number' . $booking->number . " status has been changed", "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number);

                }


                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Approved")
                    ]

                );

                break;
            case '5':

                $booking->update(['status' => '4', "approval_date" => today()]);

                BookingComment::create([
                    "booking_id" => $booking->id,
                    'usernumber' => $user->usernumber,
                    'userid' => $user->id,
                    'username' => $user->displayname,
                    'userlevel' => $user->level,
                    'comment' => $request->input('comment'),
                ]);


                $values = [
                    "displayname" => $booking->cname,
                    'facilityname' => $booking->facility->title,
                    'bookingnumber' => $booking->number,
                    'startDate' => $booking->fullstart,
                    'endDate' => $booking->fullend,
                    'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number,

                ];


                $req = $booking->UserOrClient();
                if ($req) {
                    $values['displayname'] = $req->displayname;
                    Utility::SendEmail('booking_approved', $values, 'Booking Order Approved', $req->email);
                }


                $values['displayname'] = $booking->cname;
                Utility::SendEmail('booking_approved', $values, 'Booking Order Approved', $booking->cemail);
                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Approved")
                    ]

                );

                break;

            default:
                return back();
                break;
        }
    }


    public function reject(Request $request)
    {

        $edit = $request->input('toEdit') ?? "0";
        $booking = Booking::where("id", $request->input('id'))->where('number', $request->input('number'))->first();
        if (!$booking) {
            return back();
        }

        $user = Auth::user();
        if (!$user) {
            return back();
        }

        $values = [
            "displayname" => $booking->cname,
            'facilityname' => $booking->facility->title,
            'bookingnumber' => $booking->number,
            'startDate' => $booking->fullstart,
            'endDate' => $booking->fullend,
            'reject_comment' => $request->input('reject_reason'),
            'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number,

        ];

        switch ($user->level) {
            case '1':

                $booking->update([
                    'reject_comment' => $request->input('reject_reason'),
                    'status' => '0'
                ]);

                Utility::SendEmail('booking_returned', $values, 'Booking Order Need Update', $booking->cemail);

                $req = $booking->UserOrClient();
                if ($req) {
                    $values['displayname'] = $req->displayname;
                    Utility::SendEmail('booking_returned', $values, 'Booking Order Need Update', $req->email);
                }



                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Booking Rejected")
                    ]

                );
                break;
            case '4':

                $booking->update([
                    'reject_comment' => $request->input('reject_reason'),
                    'status' => '0'
                ]);

                Utility::SendEmail('booking_returned', $values, 'Booking Order Need Update', $booking->cemail);

                $req = $booking->UserOrClient();
                if ($req) {
                    $values['displayname'] = $req->displayname;
                    Utility::SendEmail('booking_returned', $values, 'Booking Order Need Update', $req->email);
                }



                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Booking Rejected")
                    ]

                );
                break;
            case '5':
                if ($edit == '1') {
                    $booking->update([
                        'reject_comment' => $request->input('reject_reason'),
                        'status' => '0'
                    ]);

                    $values = [
                        "displayname" => $booking->cname,
                        'facilityname' => $booking->facility->title,
                        'bookingnumber' => $booking->number,
                        'startDate' => $booking->fullstart,
                        'endDate' => $booking->fullend,
                        'reject_comment' => $request->input('reject_reason'),
                        'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number,

                    ];

                    Utility::SendEmail('booking_returned', $values, 'Booking Order Need Update', $booking->cemail);
                } else {
                    $booking->update([
                        'reject_comment' => $request->input('reject_reason'),
                        'rejection_date' => today(),
                        'status' => '5'
                    ]);

                    $values = [
                        "displayname" => $booking->cname,
                        'facilityname' => $booking->facility->title,
                        'bookingnumber' => $booking->number,
                        'startDate' => $booking->fullstart,
                        'endDate' => $booking->fullend,
                        'reject_comment' => $request->input('reject_reason'),
                        'bookingurl' => "https://www.msy.gov.qa/sfb/public/booking-details/" . $booking->number,

                    ];

                    Utility::SendEmail('booking_rejected', $values, 'Booking Order Rejected', $booking->cemail);
                }

                return redirect()->route('bookings')->with(
                    [
                        'Responsesuccess' => "1",
                        'responseTxt' => __("Booking Rejected")
                    ]

                );
                break;
            default:
                break;
        }
    }

    public function cancel(Request $request)
    {

        $booking = Booking::where("id", $request->input('id'))->where('number', $request->input('number'))->first();
        if (!$booking) {
            return back();
        }

        $booking->update(['status' => '6']);

        return back()->with([
            'Responsesuccess' => "1",
            'responseTxt' => __("Canceled")
        ]);
    }

    private function randomHex()
    {

        $chars = 'ABCDEF0123456789';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
    }
    private function generateUniqueBookingNumber()
    {
        do {

            $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Booking::where('number', $randomNumber)->exists());

        return $randomNumber;
    }
}
