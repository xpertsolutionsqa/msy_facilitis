<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Facility;
use App\Models\Maintenance;
use App\Models\Notification;
use App\Models\Settings;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function deleteNotification(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        if ($type == '1') {
            Notification::where('id', $id)->update(['deleted' => '1','read' => '1']);

            return  $response = [
                'status' => 'true'
            ];
            return response()->json($response);
        } else {
            Notification::where('id', $id)->update(['read' => '1']);

            return  $response = [
                'status' => 'true'
            ];
            return response()->json($response);
        }
    }

    public function checkAvailablity(Request $request)
    {
        $id = $request->input('faid');
        $bookingid = $request->input('bid');
        $start = $request->input('startDate');
        $end = $request->input('endDate');
        $booking = Booking::where('status', '5')->where('facility_id', $id)->where('id', '!=', $bookingid)->where('start_date', '<=', $end)->where('end_date', '>=', $start)->count();
        if ($booking > 0) {

            return  $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }

        return  $response = [
            'status' => 'true'
        ];
        return response()->json($response);
    }
    public function getBookingCardData(Request $request)
    {
        $id = $request->input('id');
        $year = $request->input('y');

        sleep(1);

        $booking = Booking::where('number', $id)->first();
        if ($booking) {
            $html = view('pages.bookings.bookingcard', compact('booking'))->render();
            return  $response = [
                'status' => 'true',
                'html' => $html
            ];
            return response()->json($response);
        }

        return  $response = [
            'status' => 'false'
        ];
        return response()->json($response);
    }

    public function getMaintenanceEvents(Request $request)
    {

        $id = $request->input('i') ?? '-1';
        $number = $request->input('n') ?? '-1';
        $month = $request->input('m');
        $year = $request->input('y');



        $query = Maintenance::with('facility')->whereMonth('startDate', $month)->whereYear('startDate', $year);

        if ($id != '-1') {
            $query->where('facility_id', $id);
        }
        if ($number != '-1') {
            $query->whereIn('facility_id', function ($query) use ($number) {
                $query->select('id')
                    ->from('facilities')
                    ->where('number', $number);
            });
        }

        $user = Auth::user();

        if ($user) {
            if ($user->level == '3') {
                $clubId = $user->club_id;
                $query->whereIn('facility_id', function ($query) use ($clubId) {
                    $query->select('id')
                        ->from('facilities')
                        ->where('clubId', $clubId);
                });
            }
        }

        $bookings = $query->get();
        $result = [];
        foreach ($bookings as $key => $booking) {
            array_push($result, [
                "isReadOnly" => true,
                "id" => $booking->number,
                "calendarId" => '1',
                "title" => __('Maintenance') . "  #" . $booking->number . "",
                "category" => 'allday',
                "dueDateClass" => '',
                "start" => $booking->startDate,
                "end" => $booking->endDate,
                "bgColor" => $booking->facility->color ?? "#5959598a",
                "borderColor" => "#8A1538",
                "facility" => $booking->facility->title,
                "work" => $booking->description ?? ""
            ]);
        }


        $response = [
            'status' => 'true',
            'events' => $result
        ];
        return response()->json($response);
    }


    public function getEvents(Request $request)
    {



        $id = $request->input('i') ?? '-1';
        $number = $request->input('n') ?? '-1';
        $month = $request->input('m');
        $year = $request->input('y');
        $all = $request->input('all') ?? false;


        $currentMonth = Carbon::create($year, $month, 1);
        $previousMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        // $query = Booking::where(function ($query) use ($previousMonth, $currentMonth, $nextMonth) {
        //     $query->where(function ($query) use ($previousMonth) {
        //         $query->whereMonth('start_date', $previousMonth->month)
        //             ->whereYear('start_date', $previousMonth->year);
        //     })
        //         ->orWhere(function ($query) use ($currentMonth) {
        //             $query->whereMonth('start_date', $currentMonth->month)
        //                 ->whereYear('start_date', $currentMonth->year);
        //         })
        //         ->orWhere(function ($query) use ($nextMonth) {
        //             $query->whereMonth('start_date', $nextMonth->month)
        //                 ->whereYear('start_date', $nextMonth->year);
        //         });
        // });
        $query = Booking::whereMonth('start_date', $month)->whereYear('start_date', $year);
        $query2 = Maintenance::whereMonth('startDate', $month)->whereYear('startDate', $year);


        $user = Auth::user();

        if ($user) {
            if ($user->level == '3') {
                $clubId = $user->club_id;
                $query->whereIn('facility_id', function ($query) use ($clubId) {
                    $query->select('id')
                        ->from('facilities')
                        ->where('clubId', $clubId);
                });
                $query2->whereIn('facility_id', function ($query2) use ($clubId) {
                    $query2->select('id')
                        ->from('facilities')
                        ->where('clubId', $clubId);
                });
            }
        }

        if ($id != '-1') {
            $query->where('facility_id', $id);
            $query2->where('facility_id', $id);
        }
        if ($number != '-1') {
            $query->whereIn('facility_id', function ($query) use ($number) {
                $query->select('id')
                    ->from('facilities')
                    ->where('number', $number);
            });
            $query2->whereIn('facility_id', function ($query2) use ($number) {
                $query2->select('id')
                    ->from('facilities')
                    ->where('number', $number);
            });
        }

        $bookings = $query->get();
        $maintenances = $query2->get();
        $result = [];
        foreach ($bookings as $key => $booking) {
            array_push($result, [
                "isReadOnly" => true,
                "id" => $booking->number,
                "calendarId" => '1',
                "title" => $booking->event_name,
                "category" => 'allday',
                "dueDateClass" => '',
                "start" => $booking->start_date . "T" . $booking->start_time . ":00",
                "end" => $booking->end_date . "T" . $booking->end_time . ":00",
                "bgColor" => $booking->color,
                "borderColor" => $booking->color,
                "facility" => $booking->facility->title,
                "htmlstatus" => $booking->htmlstatus
            ]);
        }
        if ($all == 'true') {
            foreach ($maintenances as $key => $maintenance) {
                array_push($result, [
                    "isReadOnly" => true,


                    "id" => $maintenance->number,
                    "calendarId" => '2',
                    "title" => __("Maintenance"),
                    "category" => 'allday',
                    "dueDateClass" => '',
                    "start" => $maintenance->startDate,
                    "end" => $maintenance->endDate,
                    "borderColor" => "#595959",
                    "bgColor" => "#595959",
                    "color" => "#fff",
                ]);
            }
        }



        $response = [
            'status' => 'true',

            'events' => $result
        ];
        return response()->json($response);
    }

    public function getMyEvents(Request $request)
    {

        $user = Auth::guard('client')->user();
        if (!$user) {
            $response = [
                'status' => 'true',
                'events' => []
            ];
            return response()->json($response);
        }
        $id = $request->input('i') ?? '-1';
        $number = $request->input('n') ?? '-1';
        $month = $request->input('m');
        $year = $request->input('y');
        $all = $request->input('all') ?? '0';
        $result = [];

        // $currentMonth = Carbon::create($year, $month, 1);
        // $previousMonth = $currentMonth->copy()->subMonth();
        // $nextMonth = $currentMonth->copy()->addMonth();

        $query = Booking::query();
        $query2 = Maintenance::whereMonth('startDate', $month)->whereYear('startDate', $year);
        if ($id != '-1') {
            $query->where('facility_id', $id);
            $query2->where('facility_id', $id);
        }
        if ($number != '-1') {
            $query->whereIn('facility_id', function ($query) use ($number) {
                $query->select('id')
                    ->from('facilities')
                    ->where('number', $number);
            });
            $query2->whereIn('facility_id', function ($query2) use ($number) {
                $query2->select('id')
                    ->from('facilities')
                    ->where('number', $number);
            });
        }

        switch ($all) {
            case '0':
                // only my bookings used for my bookings pages
                $query->where("UID", $user->number);
                $bookings = $query->get();
                foreach ($bookings as $key => $booking) {
                    array_push($result, [
                        "isReadOnly" => true,
                        "id" => $booking->number,
                        "calendarId" => '1',
                        "title" => $booking->event_name,
                        "category" => 'allday',
                        "dueDateClass" => '',
                        "start" => $booking->start_date . "T" . $booking->start_time . ":00",
                        "end" => $booking->end_date . "T" . $booking->end_time . ":00",
                        "bgColor" => $booking->color,
                        "borderColor" => $booking->color,
                        "facility" => $booking->facility->title,
                        "htmlstatus" => $booking->htmlstatus
                    ]);
                }
                $response = [
                    'status' => 'true',

                    'events' => $result
                ];
                return response()->json($response);
                break;
            case '1':
                // get all bookings

                $bookings = $query->get();
                foreach ($bookings as $key => $booking) {

                    if ($booking->UID != $user->number) {
                        if ($booking->status == '4') {
                            array_push($result, [
                                "isReadOnly" => true,
                                "id" => -100,
                                "calendarId" => '2',
                                "title" => __("Booked"),
                                "category" => 'allday',
                                "dueDateClass" => '',
                                "start" => $booking->start_date . "T" . $booking->start_time . ":00",
                                "end" => $booking->end_date . "T" . $booking->end_time . ":00",
                                "bgColor" => '#717171',
                                "color" => '#fff',

                                "borderColor" => '#717171',
                                "facility" => $booking->facility->title,
                                "htmlstatus" => $booking->htmlstatus
                            ]);
                        }
                    } else {
                        if ($booking->status != '5' && $booking->status != '6') {
                            array_push($result, [
                                "isReadOnly" => true,
                                "id" => $booking->number,
                                "calendarId" => '1',
                                "title" => $booking->event_name,
                                "category" => 'allday',
                                "dueDateClass" => '',
                                "start" => $booking->start_date . "T" . $booking->start_time . ":00",
                                "end" => $booking->end_date . "T" . $booking->end_time . ":00",
                                "bgColor" => $booking->color,
                                "borderColor" => $booking->color,
                                "facility" => $booking->facility->title,
                                "htmlstatus" => $booking->htmlstatus
                            ]);
                        }
                    }
                }

                $maintenances = $query2->get();
                foreach ($maintenances as $key => $maintenance) {
                    array_push($result, [
                        "isReadOnly" => true,


                        "id" => $maintenance->number,
                        "calendarId" => '2',
                        "title" => __("Maintenance"),
                        "category" => 'allday',
                        "dueDateClass" => '',
                        "start" => $maintenance->startDate,
                        "end" => $maintenance->endDate,
                        "borderColor" => "#595959",
                        "bgColor" => "#595959",
                        "color" => "#fff",
                    ]);
                }



                $response = [
                    'status' => 'true',
                    'events' => $result
                ];
                return response()->json($response);
                break;

            default:
                $response = [
                    'status' => 'true',
                    'events' => $result
                ];
                return response()->json($response);
                break;
        }

        // $query = Booking::where(function ($query) use ($previousMonth, $currentMonth, $nextMonth) {
        //     $query->where(function ($query) use ($previousMonth) {
        //         $query->whereMonth('start_date', $previousMonth->month)
        //             ->whereYear('start_date', $previousMonth->year);
        //     })
        //         ->orWhere(function ($query) use ($currentMonth) {
        //             $query->whereMonth('start_date', $currentMonth->month)
        //                 ->whereYear('start_date', $currentMonth->year);
        //         })
        //         ->orWhere(function ($query) use ($nextMonth) {
        //             $query->whereMonth('start_date', $nextMonth->month)
        //                 ->whereYear('start_date', $nextMonth->year);
        //         });
        // });
        //$query = Booking::where("UID",   $user->number)->whereMonth('start_date', $month)->whereYear('start_date', $year);











        $response = [
            'status' => 'true',

            'events' => $result
        ];
        return response()->json($response);
    }


    public function showCancelbookingModel(Request $request)
    {

        $user = Auth::guard('client')->user();
        if (!$user) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $id = $request->input('id');
        $number = $request->input('number');

        $booking = Booking::where('id', $id)->where('number', $number)->where('UID', $user->number)->first();
        if (!$booking) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.bookings.cancel', compact('booking'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }
    public function showEditbookingModel(Request $request)
    {

        $user = Auth::guard('client')->user();
        if (!$user) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $id = $request->input('id');
        $number = $request->input('number');

        $booking = Booking::where('id', $id)->where('number', $number)->where('UID', $user->number)->first();
        if (!$booking) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.bookings.edit', compact('booking'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }

    public function sendTestMail(Request $request)
    {

        $email = $request->input('email');
        $locale = $request->input('locale') ?? 'ar';
        $result =  Utility::SendEmail('TESTMAIL', [], 'TEST EMAIL', $email, $locale);
        $response = [
            'status' => 'true',
            'result' => $result,
        ];
        return response()->json($response);
    }

    public function generateReport(Request $request)
    {
        $facility = null;
        $userType = null;
        $client = null;
        $user = null;
        $title = 'تقرير ';
        $showBookings = true;
        $showMaintenance = true;
        $facilitynumber =  $request->input('facility') ?? '';
        $reportType =  $request->input('reportType') ?? '';
        $booker =  $request->input('booker') ?? '';
        $fromDate =  $request->input('fromDate') ?? '';
        $toDate =  $request->input('toDate') ?? '';
        $status = $request->input('status') ?? '';
        $bookingquery = Booking::with('facility');
        $minquery = Maintenance::with('facility');

        $statusArray = [
            __('Retreuned For Edit'),
            __('New'),
            __('Div Manger Approval'),
            __('Dep Manger Approval'),
            __('Approved'),
            __('Rejected'),
            __('Canceled')

        ];

        switch ($reportType) {
            case '':
                $title = $title . ' الحجوزات وأعمال الصيانة ';
                break;
            case 'bookings':
                $title = $title . ' الحجوزات';
                $showMaintenance = false;
                break;
            case 'maintenance':
                $title = $title . ' أعمال الصيانة ';
                $showBookings = false;

                break;

            default:
                break;
        }

        if ($facilitynumber != '') {
            $facility = Facility::where('number', $facilitynumber)->first();
            if ($facility) {
                $bookingquery->whereIn('facility_id', function ($query) use ($facilitynumber) {
                    $query->select('id')
                        ->from('facilities')
                        ->where('number', $facilitynumber);
                });
                $minquery->whereIn('facility_id', function ($query) use ($facilitynumber) {
                    $query->select('id')
                        ->from('facilities')
                        ->where('number', $facilitynumber);
                });
                $title = $title . ' بخصوص ' . $facility->title;
            }
        }
        if ($booker != '') {
            $bookerArray = explode('|', $booker);
            $userType = $bookerArray[0];
            $usernumber = $bookerArray[1];
            if ($userType == '1') {
                $client = Client::where('number', $usernumber)->first();
                if ($client) {
                    $title = $title . '<br>' . ' المقدمة بواسطة العميل ' . $client->displayname;
                }
            } else {
                $user = User::where('usernumber', $usernumber)->first();
                if ($user) {
                    $title = $title . '<br>' . ' المقدمة بواسطة الموظف ' . $user->displayname;
                }
            }
            $bookingquery->where('UID', $usernumber);
        }

        if ($fromDate) {
            $bookingquery->where('start_date', '>=', $fromDate);
            $minquery->where('startDate', '>=', $fromDate);
            $title = $title . '<br>' . ' من تاريخ ' . $fromDate;
        }
        if ($toDate) {
            $bookingquery->where('end_date', '<=', $toDate);
            $minquery->where('endDate', '<=', $toDate . ' 23:59:59');
            if ($fromDate == '') {
                $title = $title . '<br>' . ' قبل تاريخ ' . $toDate;
            } else {
                $title = $title .  ' حتى تاريخ ' . $toDate;
            }
        }

        if ($status != '') {
            $bookingquery->where('status', $status);
            $title = $title .  ' وحالتها ' . $statusArray[$status];
        }

        $bookings = $bookingquery->get();
        $maintenance = $minquery->get();



        $html = view('pages.reports.result', compact(['title', 'showMaintenance', 'showBookings', 'bookings', 'booker',  'maintenance', 'reportType', 'userType','facility', 'client', 'user']))->render();
        $response = [
            'status' => 'true',
            'facilitynumber' => $facilitynumber,
            'html' => $html
        ];
        return response()->json($response);
    }

    public function showDeleteMinModel(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');

        $min = Maintenance::where('id', $id)->where('number', $number)->first();
        if (!$min) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.maintenance.delete', compact('min'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }
    public function showEditMinModel(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');

        $min = Maintenance::where('id', $id)->where('number', $number)->first();
        if (!$min) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.maintenance.edit', compact('min'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }
    public function showDeleteFacilityModel(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');

        $facility = Facility::where('id', $id)->where('number', $number)->first();
        if (!$facility) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.facility.delete', compact('facility'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }
    public function showEditClientModel(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');

        $client = Client::where('id', $id)->where('number', $number)->first();
        if (!$client) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.users.edit', compact('client'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }
    public function showEditUserModel(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');

        $user = User::where('id', $id)->where('usernumber', $number)->first();
        if (!$user) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.users.edit', compact('user'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }


    public function showDeleteClientModel(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');

        $user = Client::where('id', $id)->where('number', $number)->first();
        if (!$user) {
            $response = [
                'status' => 'false',
            ];
            return response()->json($response);
        }
        $html = view('pages.users.delete', compact('user'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }

    public function getTemplate(Request $request)
    {
        $templateName =  $request->input('name');

        $template = Utility::getValues($templateName);

        // if ($template->ar_value == '' && $template->en_value == '') {
        //     $response = [
        //         'status' => 'false',
        //     ];
        //     return response()->json($response);
        // }


        $html = view('partials.edittemplate', compact('template', 'templateName'))->render();
        $response = [
            'status' => 'true',
            'html' => $html
        ];
        return response()->json($response);
    }
    public function saveTemplate(Request $request)
    {
        $name =  $request->input('name');
        $value =  $request->input('arvalue');
        $en_value =  $request->input('envalue');


        Settings::updateOrCreate(
            ['name' => $name],
            [
                'ar_value' => $value,
                'en_value' => $en_value
            ]
        );


        $response = [
            'status' => 'true',
        ];
        return response()->json($response);
    }

    public function checkLocation(Request $request)
    {
        $zone =  $request->input('zone');
        $street =  $request->input('street');
        $buliding =  $request->input('buliding');

        $result = Utility::getLocation($zone, $street, $buliding);

        $response = [
            'status' => 'true',
            'result' => $result
        ];

        return response()->json($response);
    }


    public function changeReqiuredValue(Request $request)
    {
        $id = $request->input('id');
        $newvalue = $request->input('newvalue');

        if ($newvalue == 'true') {
            $per  = '1';
        } else {
            $per  = '0';
        }
        Attachment::find($id)->update(['required' => $per]);
        $response =  [
            'status' => 'true',
        ];
        return response()->json($response);
    }


    public function changeUserPermission(Request $request)
    {

        $field = $request->input('field');
        $userid = $request->input('userid');
        $newvalue = $request->input('newvalue');

        if ($newvalue == 'true') {
            $per  = '1';
        } else {
            $per  = '0';
        }

        User::where('id', $userid)->update([$field => $per]);
        $response =  [
            'status' => 'true',
            'message' => $newvalue,
            'message2' =>  $per,
        ];
        return response()->json($response);
    }


    public function getDashboardTotals(Request $request)
    {

        $bookings = Booking::with('facility')->get()->groupBy('facility.title');

        $bnames = $bookings->keys()->toArray();
        $bvalues = $bookings->map(function ($bookings) {
            return $bookings->count();
        })->values()->toArray();

        $bcolors = $bookings->map(function ($bookings) {
            return $bookings->first()->facility->color;
        })->values()->toArray();

        $maintenance = Maintenance::with('facility')->get()->groupBy('facility.title');

        $mnames = $maintenance->keys()->toArray();
        $mvalues = $maintenance->map(function ($maintenance) {
            return $maintenance->count();
        })->values()->toArray();

        $mcolors = $maintenance->map(function ($maintenance) {
            return $maintenance->first()->facility->color;
        })->values()->toArray();


        $year = date("Y");

        $mbvalues = [];
        $mmvalues = [];

        for ($i = 0; $i <= 12; $i++) {
            $currentMonth = Carbon::create($year, $i, 1);
            $bookingsCount = Booking::whereMonth('start_date', $currentMonth->month)->whereYear('start_date', $year)->count();
            array_push($mbvalues, $bookingsCount);
            $maintenanceCount = Maintenance::whereMonth('startDate', $currentMonth->month)->whereYear('startDate', $year)->count();
            array_push($mmvalues, $maintenanceCount);
        }


        $response = [
            'status' => 'true',
            'bnames' => $bnames,
            'bvalues' => $bvalues,
            'bcolors' => $bcolors,
            'mnames' => $mnames,
            'mvalues' => $mvalues,
            'mcolors' => $mcolors,

            'mbvalues' => $mbvalues,
            'mmvalues' => $mmvalues,

        ];
        return response()->json($response);
    }
}
