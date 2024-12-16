<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Utility extends Model
{
    use HasFactory;

    public static function getLocation($zone, $street, $building)
    {
        $location = Http::get("https://qnas.qa/get_location/$zone/$street/$building");
        if (!isset($location[0]['coord_x']) || !isset($location[0]['coord_y'])) {

            return 'wrong';
        }

        return  "good";
    }

    public static function getValues($requiredvalue = '')
    {
        $value =   Settings::where('name', $requiredvalue)->first();
        if ($value) {
            return $value;
        }
        return json_decode('{ "ar_value": "","en_value":"" }');
    }

    public static function getenValue($requiredvalue = '')
    {
        $value =   Settings::where('name', $requiredvalue)->first();
        if ($value) {
            return $value['en_value'];
        }
        return '';
    }

    public static function getarValue($requiredvalue = '')
    {
        $value =   Settings::where('name', $requiredvalue)->first();
        if ($value) {
            return $value['ar_value'];
        }
        return '';
    }

    public static function createNotification($userId, $artitle, $enTitle, $arabicContent, $englishContent, $url)
    {
        Notification::create([
            "user_id" => $userId,
            'title' => [
                'en' =>  $enTitle,
                'ar' =>  $artitle
            ],
            'content' => [
                'en' =>  $englishContent,
                'ar' =>  $arabicContent
            ],
            "url" => $url
        ]);
    }



    public static function SendEmail($template, $values, $subject, $recevier, $locale = 'ar')
    {

        $email_enabled = Utility::getenValue('email_enabled') ?? 'off';
        if ($email_enabled == 'on') {

            $email_host = Utility::getenValue('email_host');
            $email_port  = Utility::getenValue('email_port');
            $email_fromaddress = Utility::getenValue('email_fromaddress');
            $email_smtp_username = Utility::getenValue('email_smtp_username');
            $email_smtp_password = Utility::getenValue('email_smtp_password');


            try {
                $htmlEmailTemplate = Utility::getarValue($template);
                if ($locale != 'ar') {
                    $htmlEmailTemplate = Utility::getenValue($template);
                }


                foreach ($values as $key => $value) {
                    $htmlEmailTemplate = str_replace('{{' . $key . '}}', $value, $htmlEmailTemplate);
                }
                $htmlEmailTemplate = str_replace('{{systemurl}}', 'https://www.msy.gov.qa/sfb/public/login', $htmlEmailTemplate);


                preg_match_all('/\{\{(\w+)\}\}/', $htmlEmailTemplate, $matches);
                $placeholders = $matches[1];
                foreach ($placeholders as $placeholder) {
                    if (!isset($values[$placeholder])) {
                        $htmlEmailTemplate = str_replace('{{' . $placeholder . '}}', '', $htmlEmailTemplate);
                    }
                }


                $mailConfig = [
                    'transport' => 'smtp',
                    'host' => $email_host,
                    'port' =>  $email_port,
                    'username' => $email_smtp_username,
                    'password' => $email_smtp_password,
                    'timeout' => null
                ];

                config(['mail.mailers.smtp' => $mailConfig]);

                if ($locale == 'ar') {
                    $htmlEmailTemplate = '<div dir="rtl" style="text-align: right;">' . $htmlEmailTemplate . '</div>';
                }

                Mail::send([], [], function ($message) use ($subject, $recevier, $htmlEmailTemplate, $email_fromaddress) {
                    $message->to($recevier)
                        ->subject($subject)
                        ->from($email_fromaddress)
                        ->html($htmlEmailTemplate);
                });
                return 'sent';
            } catch (\Throwable $th) {
                return $th;
            }
        }

        return 'off';
    }

    public static function getBookingsCount($number)
    {
        if (App::getLocale() == 'ar') {
            if ($number == 0) {
                return ' ';
            } elseif ($number == 1) {
                return '   ';
            } elseif ($number == 2) {
                return 'حجزين';
            } elseif ($number > 2 && $number < 11) {
                return   ' حجوزات ';
            }
            return   ' حجز ';
        }

        if ($number > 1) {
            return "Bookins";
        }


        return "Booking";
    }

    public static function getFacCount($number)
    {
        if (App::getLocale() == 'ar') {
            if ($number == 0) {
                return ' ';
            } elseif ($number == 1) {
                return '   ';
            } elseif ($number == 2) {
                return 'منشأتين';
            } elseif ($number > 2 && $number < 11) {
                return   ' منشئات ';
            }
            return   ' منشأة ';
        }

        if ($number > 1) {
            return "Facilites";
        }


        return "Facility";
    }
}
