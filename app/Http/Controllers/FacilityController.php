<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Facility;
use App\Models\FacilityImage;
use App\Models\Maintenance;
use App\Models\SubFacility;
use App\Models\SubFacilityImage;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilityController extends Controller
{


    public function createSub(Request $request)
    {
        $id = $request->input('FaId');
        $number = $request->input('FaNum');
        $arname = $request->input('arname');
        $enname = $request->input('enname');
        $type = $request->input('type');
        $capacity = $request->input('capacity');
        $description = $request->input('description');

        $facility = Facility::with(['subfacilities', 'bookings'])->where('id', $id)->where('number', $number)->first();

        if (!$facility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this facility")]);
        }


        $subfa = SubFacility::create([
            "facility_id" => $id,
            'title' => [
                'en' =>  $enname,
                'ar' =>  $arname
            ],
            "description" => $description,
            "size" => $capacity,
            "type" => $type,
            "status" => '1',
        ]);

        $theId = $subfa->id;
        foreach ($request->file('images') as $index => $file) {

            $fileName = 'MSY_SUB_FA_' . $number . '_' . $index . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/subfacilities/'), $fileName);

            SubFacilityImage::create([
                "sfacility_id" => $theId,
                "url" => 'uploads/subfacilities/' . $fileName,
            ]);
        }


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Sub Facility Created")
            ]

        );
    }
    public function removesubImage(Request $request)
    {

        $id = $request->input('id');
        $sub = $request->input('sub');
        $path = $request->input('url');

        $subfacility = SubFacility::where('id', $sub)->where('facility_id', $id)->first();
        if (!$subfacility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this sub facility")]);
        }


        SubFacilityImage::where('sfacility_id', $sub)->where('url', $path)->delete();


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Image Removed"),

            ]
        );
    }
    public function addsubImage(Request $request)
    {

        $number = $request->input('number');
        $id = $request->input('id');
        $sub = $request->input('sub');

        $subfacility = SubFacility::where('id', $sub)->where('facility_id', $id)->first();
        if (!$subfacility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this sub facility")]);
        }

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $file) {

                $fileName = 'MSY_SUB_FA_' . $number . '_' . $index . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/subfacilities/'), $fileName);

                $image = new SubFacilityImage();
                $image->sfacility_id = $sub;
                $image->url = 'uploads/subfacilities/' . $fileName;
                $image->save();
            }
        }
        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Images Added"),

            ]
        );
    }
    public function removeImage(Request $request)
    {

        $number = $request->input('number');
        $id = $request->input('id');
        $path = $request->input('path');

        $facility = Facility::with(['subfacilities', 'bookings'])->where('id', $id)->where('number', $number)->first();
        if (!$facility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this facility")]);
        }


        FacilityImage::where('facility_id', $id)->where('url', $path)->delete();


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Image Removed"),

            ]
        );
    }
    public function addImage(Request $request)
    {

        $number = $request->input('number');
        $id = $request->input('id');

        $facility = Facility::with(['subfacilities', 'bookings'])->where('id', $id)->where('number', $number)->first();
        if (!$facility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this facility")]);
        }

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $file) {

                $fileName = 'MSY_FA_' . $number . '_' . $index . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/facilities/'), $fileName);

                $image = new FacilityImage();
                $image->facility_id = $id;
                $image->url = 'uploads/facilities/' . $fileName;
                $image->save();
            }
        }
        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Images Added"),

            ]
        );
    }
    public function update(Request $request)
    {
        $number = $request->input('number');
        $id = $request->input('id');

        $facility = Facility::with(['subfacilities', 'bookings'])->where('id', $id)->where('number', $number)->first();

        if (!$facility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this facility")]);
        }


        $type = $request->input('type');
        $ar_name = $request->input('ar_name');
        $en_name = $request->input('en_name');
        $space = $request->input('space');
        $capacity = $request->input('capacity');
        $zone = $request->input('zone');
        $location = $request->input('location');
        $buliding = $request->input('buliding');
        $street = $request->input('street');


        $facility->update([
            'title' => [
                'en' =>  $en_name,
                'ar' =>  $ar_name
            ],

            "zone" => $zone,
            "street" => $street,
            "building" => $buliding,
            "location" => $location,
            "space" => $space,
            "capacity" => $capacity,
            "type" => $type,

        ]);

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Facility Updated")
            ]

        );
    }


    public function show(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->level == '3') {
                return   redirect('/bookings');
            }
        }

        $type = $request->input('type');
        $start = $request->input('start');
        $end = $request->input('end');


        $filterquery = Facility::with(['subfacilities', 'images', 'bookings', 'club']);



        if (isset($start)) {
            // $filterquery->whereDoesntHave('bookings', function ($q) use ($start, $end) {
            //     $q->where(function ($query) use ($start, $end) {
            //         $query->whereBetween('start_date', [$start, $end])
            //             ->orWhereBetween('end_date', [$start, $end])
            //             ->orWhere(function ($query) use ($start, $end) {
            //                 $query->where('start_date', '<=', $start)
            //                     ->where('end_date', '>=', $end);
            //             });
            //     });
            // });

            $filterquery->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                $q->where(function ($query) use ($start, $end) {
                    $query->where('start_date', '<=', $end)
                        ->where('end_date', '>=', $start);
                });
            });
            $filterquery->whereDoesntHave('maintenance', function ($q) use ($start, $end) {
                $q->where(function ($query) use ($start, $end) {
                    $query->where('startDate', '<=', $end)
                        ->where('endDate', '>=', $start);
                });
            });
        }




        if (isset($type)) {
            $filterquery->where('type', $type);
        }


        $facilities = $filterquery->get();

        return view('pages.facility.show')->with([
            'facilities' => $facilities,
            'gridactive' => $request->gridactive,
            'listactive' => $request->listactive,

        ]);
    }


    public function showDetails($FaNumber)
    {
        $facility = Facility::with(['subfacilities.images', 'images', 'bookings'])->where('number', $FaNumber)->first();
        if (!$facility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this facility")]);
        }

        if (auth('client')->user()) {
            $user = auth('client')->user();
            return view('pages.facility.clientdetails')->with(['facility' => $facility]);
        }




        return view('pages.facility.details')->with(['facility' => $facility]);
    }
    public function showedit($FaNumber)
    {

        $facility = Facility::with(['subfacilities.images', 'images', 'bookings'])->where('number', $FaNumber)->first();

        if (!$facility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this facility")]);
        }

        $user = Auth::user();
        if (!$user) {
            return back();
        }

        if ($user->level != '6' && $user->level != '2') {
            return back();
        }

        return view('pages.facility.edit')->with(['facility' => $facility]);
    }

    public function updateSub(Request $request)
    {

        $sub = $request->input('sub');
        $id = $request->input('id');
        $arname = $request->input('arname');
        $enname = $request->input('enname');
        $type = $request->input('type');
        $capacity = $request->input('capacity');
        $description = $request->input('description');


        $subfacility = SubFacility::where('id', $sub)->where('facility_id', $id)->first();
        if (!$subfacility) {
            return redirect('/facilities')->with(['Responseerror' => "1",  'responseTxt' => __("Couldnt find this sub facility")]);
        }


        $subfacility->update([
            'title' => [
                'en' =>  $enname,
                'ar' =>  $arname
            ],
            "description" => $description,
            "size" => $capacity,
            "type" => $type,
        ]);

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Updated")
            ]

        );
    }
    public function disableSub(Request $request)
    {
        $sub = $request->input('sub');
        $id = $request->input('id');

        SubFacility::where('id', $sub)->where('facility_id', $id)->update([
            'status' => '0'
        ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Sub Facility Disabled")
            ]

        );
    }
    public function enableSub(Request $request)
    {
        $sub = $request->input('sub');
        $id = $request->input('id');

        SubFacility::where('id', $sub)->where('facility_id', $id)->update([
            'status' => '1'
        ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Sub Facility Enabled")
            ]

        );
    }
    public function disable(Request $request)
    {

        Facility::where('id', $request->input('faId'))
            ->where('number', $request->input('faNumber'))->update([
                'status' => '-1'
            ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Facility Disabled")
            ]

        );
    }
    public function delete(Request $request)
    {

        $facility = Facility::where('id', $request->input('id'))->where('number', $request->input('number'))->first();

        if (!$facility) {
            return back();
        }

        FacilityImage::where('facility_id', $facility->id)->delete();
        Maintenance::where('facility_id', $facility->id)->delete();
        $sub_facilities =  SubFacility::where('facility_id', $facility->id)->get();
        foreach ($sub_facilities as $key => $sub) {
            SubFacilityImage::where('sfacility_id', $sub->id)->delete();
            $sub->delete();
        }

        $facility->delete();



        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Facility Deleted")
            ]

        );
    }
    public function enable(Request $request)
    {
        Facility::where('id', $request->input('faId'))->where('number', $request->input('faNumber'))->update([
            'status' => '1'
        ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Facility Enabled")
            ]

        );
    }




    public function showcreate(Request $request)
    {
        return view('pages.facility.create');
    }
    public function create(Request $request)
    {

        $user = Auth::user();

        if (!$user) {
            return back();
        }

        if ($user->level != '3') {
            return back();
        }


        $club = $request->input('club');
        $type = $request->input('type');

        $ar_name = $request->input('ar_name');
        $en_name = $request->input('en_name');
        $space = $request->input('space');
        $capacity = $request->input('capacity');
        $zone = $request->input('zone');
        $location = $request->input('location');
        $buliding = $request->input('buliding');
        $street = $request->input('street');
        $subconunt = $request->input('subconunt');
        $number = $this->generateUniqueFacilityNumber();





        $facility = Facility::create([
            'title' => [
                'en' =>  $en_name,
                'ar' =>  $ar_name
            ],
            'clubId' => $club,
            'number' => $number,
            "zone" => $zone,
            "street" => $street,
            "building" => $buliding,
            "location" => $location,
            "space" => $space,
            "capacity" => $capacity,
            "type" => $type,
            "owner" => $user->id,
            "status" => '1',
            "color" => $this->randomHex(),
        ]);

        $FaId = $facility->id;

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $file) {

                $fileName = 'MSY_FA_' . $number . '_' . $index . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/facilities/'), $fileName);
                FacilityImage::create([
                    "facility_id" => $FaId,
                    "url" => 'uploads/facilities/' . $fileName,
                ]);
            }
        }
        for ($i = 1; $i <= $subconunt; $i++) {

            $arname = $request->input('subarname' . $i) ?? "";
            $enname = $request->input('subenname' . $i) ?? "";
            $desc = $request->input('subcdesc' . $i) ?? "";
            $subtype = $request->input('subtype' . $i) ?? "";
            $subsize = $request->input('subcapacitpy' . $i) ?? "";


            if ($arname != '') {
                $sub = SubFacility::create([
                    "facility_id" => $FaId,
                    'title' => [
                        'ar' =>  $arname,
                        'en' =>  $enname
                    ],

                    "description" => $desc,
                    "size" => $subsize,
                    "type" => $subtype,
                    "status" => "1",
                ]);
                if ($request->hasFile('subfiles' . $i)) {

                    foreach ($request->file('subfiles' . $i) as $index => $file) {

                        $fileName = 'MSY_SUB_FA_' . $number . '_' . $index . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/subfacilities/'), $fileName);

                        SubFacilityImage::create([
                            "sfacility_id" => $sub->id,
                            "url" => 'uploads/subfacilities/' . $fileName,
                        ]);
                    }
                }
            }
        }


        return redirect('/facilities')->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Facility Created")
            ]

        );



        return view('pages.facilities');
    }



    private function generateUniqueFacilityNumber()
    {
        do {

            $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Facility::where('number', $randomNumber)->exists());

        return $randomNumber;
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
}
