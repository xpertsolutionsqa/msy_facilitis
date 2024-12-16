<?php

namespace App\Http\Controllers;

use App\Providers\NotificationService;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Maintenance;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{


    public function create(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return back();
        }
        $UID = $user->id;
        $FaId = $request->input('FaId');
        $FaNum = $request->input('FaNum');

        $facility = Facility::where('id', $FaId)->where('number', $FaNum)->first();

        if (!$facility) {
            return back()->with(['Responseerror' => '1', 'responseTxt' => __('Coludnt find facility')]);
        }

        $from_date = $request->input('start_date');
        $to_date = $request->input('end_date');
        $from_time = $request->input('start_time');
        $to_time = $request->input('end_time');
        $team = $request->input('team');
        $notes = $request->input('notes');



        $number = $this->generateUniqueMinNumber();

        Maintenance::create([

            "number" => $number,
            "facility_id" => $FaId,
            "startDate" => $from_date . " " . $from_time,
            "endDate" => $to_date . " " . $to_time,
            "description" => $notes,
            "team" => $team,
            "requester" => $UID,
            "request_status" => '1',
            "status" => '1',
        ]);




        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Maintenance Request Sent")
            ]
        );
    }


    public function edit(Request $request)
    {

        $min = Maintenance::where('id', $request->input('id'))->where('number', $request->input('number'))->first();

        if (!$min) {
            return back();
        } 

        $from_date = $request->input('start_date');
        $to_date = $request->input('end_date');
        $from_time = $request->input('start_time');
        $to_time = $request->input('end_time');
        $team = $request->input('team');
        $notes = $request->input('notes');

        $min->update([
            "startDate" => $from_date . " " . $from_time,
            "endDate" => $to_date . " " . $to_time,
            "description" => $notes,
            "team" => $team,
        ]);



        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Updated")
            ]

        );
    }

    public function delete(Request $request)
    {

        $min = Maintenance::where('id', $request->input('id'))->where('number', $request->input('number'))->first();

        if (!$min) {
            return back();
        } 

        $min->delete();



        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Deleted")
            ]

        );
    }






    public function show(Request $request)
    {
        $number = $request->input('fa') ?? "";
        $query = Maintenance::where('status', '1');
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->level == '3') {
                $clubId = $user->club_id;
                //$query->whereIn('status', ['1','2', '3']);
                $query->whereIn('facility_id', function ($query) use ($clubId) {
                    $query->select('id')
                        ->from('facilities')
                        ->where('clubId', $clubId);
                });
            }
        }




        if ($number != '') {
            $query->whereIn('facility_id', function ($query) use ($number) {
                $query->select('id')
                    ->from('facilities')
                    ->where('number', $number);
            });
        }
        $maintenances = $query->get();

        
        return view('pages.maintenance.index')->with([
            'maintenances' => $maintenances,
            'gridactive' => $request->gridactive,
            'listactive' => $request->listactive,

        ]);
    }



    public function getEvents(Request $request)
    {
        $id = $request->input('i') ?? '-1';
        $number = $request->input('n') ?? '-1';
        $month = $request->input('m');
        $year = $request->input('y');



        $query = Booking::whereMonth('start_date', $month)->whereYear('start_date', $year);

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

        $bookings = $query->get();
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
            ]);
        }


        $response = [
            'status' => 'true',
            'events' => $result
        ];
        return response()->json($response);
    }
    public function getbookingdetails(Request $request)
    {
        $id = $request->input('id');
        $year = $request->input('y');



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








 
    


    private function randomHex()
    {

        $chars = 'ABCDEF0123456789';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
    }
    private function generateUniqueMinNumber()
    {
        do {

            $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Maintenance::where('number', $randomNumber)->exists());

        return $randomNumber;
    }


   
  
   
     
     
    
}
