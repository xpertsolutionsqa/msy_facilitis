<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\FacilityTypes;
use App\Models\Settings;
use App\Models\SubFacilityTypes;
use App\Models\Utility;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getSettings(Request $request)
    {
        $settings = Settings::first();

        if (!$settings) {
            return response()->json([
                'status' => 'false',
            ]);
        }

        $html_start = '<html><body>';
        $html_end = '</body></html>';

        return json_encode([
            'status' => 'true',
            "facebook" => $settings->facebook ?? "",
            "x" => $settings->x ?? "",
            "snapchat" => $settings->snapchat ?? "",
            "instagram" => $settings->instagram ?? "",
            "web" => $settings->web ?? "",
            "arabic_terms" => $settings->arabic_terms,
            "english_terms" => $settings->english_terms,
            "arabic_aboutUs" => $settings->arabic_aboutUs,
            "english_aboutUs" => $settings->english_aboutUs,
            "arabic_privacy" => $settings->arabic_privacy,
            "english_privacy" => $settings->english_privacy,
            "location" => $settings->location,
            "phone" => $settings->phone,
            "latitude" => $settings->latitude,
            "longitude" => $settings->longitude,
            "en_address" => $settings->en_address,
            "ar_address" => $settings->ar_address,

        ]);
    }

    public function UpdateTerms(Request $request)
    {

        $ar_terms = $request->input('arterms');
        $en_terms = $request->input('terms');


        Settings::first()->update([
            'arabic_terms' => $ar_terms,
            'english_terms' => $en_terms,
        ]);

        return 'updated';
    }

    public function UpdateAboutus(Request $request)
    {

        $arcontent = $request->input('arcontent');
        $content = $request->input('content');


        Settings::first()->update([
            'arabic_aboutUs' => $arcontent,
            'english_aboutUs' => $content,
        ]);

        return 'updated';
    }

    public function UpdatePrivacy(Request $request)
    {

        $arpricvy = $request->input('arpricvy');
        $pricvy = $request->input('pricvy');


        Settings::first()->update([
            'arabic_privacy' => $arpricvy,
            'english_privacy' => $pricvy,
        ]);

        return 'updated';
    }


    public function showattachments(Request $request)
    {
        $files_types = Utility::getenValue('files_types');
        $required_attachments = Utility::getenValue('required_attachments');
        $max = Utility::getenValue('max');



        return view('pages.settings.attachments')->with([
            'max' =>  $max,
            'extentions' =>  $files_types,
            'attachmentsrequired' => $required_attachments
        ]);
    }

    public function showNotification(Request $request)
    {


        $email_enabled = Utility::getenValue('email_enabled');
        $email_host = Utility::getenValue('email_host');
        $email_port = Utility::getenValue('email_port');
        $email_fromaddress = Utility::getenValue('email_fromaddress');
        $email_smtp_username = Utility::getenValue('email_smtp_username');
        $email_smtp_password = Utility::getenValue('email_smtp_password');
        return view('pages.settings.notification')->with([
            'email_enabled' =>  $email_enabled,
            "email_host" => $email_host,
            "email_port" => $email_port,
            "email_fromaddress" => $email_fromaddress,
            "email_smtp_username" => $email_smtp_username,
            "email_smtp_password" => $email_smtp_password,
        ]);
    }
    public function showFacilityTypes(Request $request)
    {

        $facilityTypes = FacilityTypes::all();
        return view('pages.settings.types')->with([
            'facilityTypes' =>  $facilityTypes,
        ]);
    }
    public function showSubfacilityTypes(Request $request)
    {

        $subfacilityTypes = SubFacilityTypes::all();
        return view('pages.settings.types')->with([
            'subfacilityTypes' =>  $subfacilityTypes,
        ]);
    }



    public function savenotifications(Request $request)
    {

        $email_smtp_password = $request->input('email_smtp_password') ?? '';
        $email_smtp_username = $request->input('email_smtp_username') ?? '';
        $email_fromaddress = $request->input('email_fromaddress') ?? '';
        $email_host = $request->input('email_host') ?? '';
        $email_enabled = $request->input('email_enabled') ?? "off";
        $this->saveValues('email_enabled', $email_enabled, $email_enabled);
        $this->saveValues('email_fromaddress', $email_fromaddress, $email_fromaddress);
        $this->saveValues('email_smtp_password', $email_smtp_password, $email_smtp_password);
        $this->saveValues('email_smtp_username', $email_smtp_username, $email_smtp_username);
        $this->saveValues('email_host', $email_host, $email_host); 

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Updated")
            ]

        );
    }


    public function savefacilitytype(Request $request)
    {

        $arname = $request->input('arname');
        $enname = $request->input('enname');
        FacilityTypes::create([
            'name' => [
                'ar' =>  $arname,
                'en' =>  $enname
            ],
            "status" => '1',
        ]);

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Added")
            ]

        );
    }

    public function savesubfacilitytype(Request $request)
    {
        $arname = $request->input('arname');
        $enname = $request->input('enname');

        SubFacilityTypes::create([
            'name' => [
                'ar' =>  $arname,
                'en' =>  $enname
            ],
            "status" => '1',
        ]);

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Added")
            ]

        );
    }

    public function saveattachemnts(Request $request)
    {

        $arname = $request->input('arname');
        $enname = $request->input('enname');
        $accept = $request->input('accept');
        $max = $request->input('max');
        $required = $request->input('required') == null ? '0' : '1';


        Attachment::create([
            'name' => [
                'ar' =>  $arname,
                'en' =>  $enname
            ],

            "accept" => join(",", $accept),
            "max" => $max,
            "required" => $required,
            "status" => '1',
        ]);

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Added")
            ]

        );
    }

    public function updateFacilityType(Request $request)
    {
        $id = $request->input('id');
        $arname = $request->input('arname');
        $enname = $request->input('enname');
        FacilityTypes::find($id)->update([
            'name' => [
                'ar' =>  $arname,
                'en' =>  $enname
            ],
        ]);
        return back();
    }
    public function updateSubFacilityType(Request $request)
    {
        $id = $request->input('id');
        $arname = $request->input('arname');
        $enname = $request->input('enname');
        SubFacilityTypes::find($id)->update([
            'name' => [
                'ar' =>  $arname,
                'en' =>  $enname
            ],
        ]);
        return back();
    }




    public function facilityTypeChangeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        FacilityTypes::find($id)->update(['status' => $status]);
        return back();
    }
    public function subFacilityTypeChangeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        SubFacilityTypes::find($id)->update(['status' => $status]);
        return back();
    }



    public function disableAttachment(Request $request)
    {
        $id = $request->input('id');
        Attachment::find($id)->update(['status' => '0']);
        return back();
    }


    public function updateAttachment(Request $request)
    {
        $id = $request->input('id');
        $arname = $request->input('arname');
        $enname = $request->input('enname');
        $accept = $request->input('accept');
        $max = $request->input('max');

        Attachment::find($id)->update([
            'name' => [
                'ar' =>  $arname,
                'en' =>  $enname
            ],

            "accept" => join(",", $accept),
            "max" => $max,
        ]);
        return back();
    }
    public function enableAttachment(Request $request)
    {
        $id = $request->input('id');
        Attachment::find($id)->update(['status' => '1']);
        return back();
    }

    public static function saveValues($name, $value = '', $en_value = '')
    {

        Settings::updateOrCreate(
            ['name' => $name],
            [
                'ar_value' => $value,
                'en_value' => $en_value
            ]
        );
    }
}
