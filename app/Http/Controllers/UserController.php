<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function create(Request $request)
    {

        $type = $request->input('type');
        $displayname = $request->input('displayname');
        $email = $request->input('email');
        $phone = $request->input('phone');

        $oldclient = Client::where('email', $email)->first();
        if ($oldclient) {
            return back()->with([
                'Responseerror' => "1",
                'responseTxt' => __("User Exists")
            ]);
        }

        $number = $this->generateUniqueClientNumber();
        $password = $this->generateRandomPassword();
        $new_password = Hash::make($password);

        Client::create([

            'number' => $number,
            "displayname" => $displayname,
            "username" =>  $email,
            "email" => $email,
            "phone" => $phone,
            "password" => $new_password,
            "type" => $type,
            "status" => '1',
        ]);

        $values = [
            "displayname" => $displayname,
            'username' => $email,
            'usernumber' => $number,
            'password' => $password,
        ];
        Utility::SendEmail('new_client', $values, 'Registration', $email, 'en');


        return back()->with([
            'Responsesuccess' => "1",
            'responseTxt' => __("User Added")
        ]);
        return back();
    }

    public function editClient(Request $request)
    {
        $number = $request->input('number');
        $id = $request->input('id');
        $client = Client::where('id', $id)->where('number', $number)->first();
        if (!$client) {

            return back()->with([
                'Responseerror' => "1",
                'responseTxt' => ''
            ]);
        }



        $type  = $request->input('type');
        $displayname = $request->input('displayname');
        $email = $request->input('email');
        $phone = $request->input('phone');

        $otherUser = Client::where('id', '!=', $id)->where('email', $email)->first();
        if ($otherUser) {
            return back()->with([
                'Responseerror' => "1",
                'responseTxt' => __("User Exists")
            ]);
        }

        $client->update([

            "displayname" => $displayname,
            "email" => $email,
            "phone" => $phone,
            "type" => $type,

        ]);

        return back()->with([
            'Responsesuccess' => "1",
            'responseTxt' => __("Updated")
        ]);
    }


   
    public function delete(Request $request)
    {
        $number = $request->input('number');
        $id = $request->input('id');
        Client::where('id', $id)->where('number', $number)->delete();
        return back()->with([
            'Responsesuccess' => "1",
            'responseTxt' => __("Deleted")
        ]);
    }



    public function changePassword(Request $request)
    {

        $id = 0;
        $user = Auth::guard('client')->user();
        if (!$user) {
            return back();
        }
        $id = $user->id;
        $password = $request->input('current_pass');
        if (!Hash::check($password, $user->password)) {

            return back()->with(
                [
                    'Responseerror' => "1",
                    'responseTxt' => __("Wrong Password")
                ]

            );
        }

        $user = Client::where('id',  $id)->first();
        if ($user) {
            $newpassword = $request->input('new_pass');
            $hashedNewPassword = Hash::make($newpassword);
            $user->password = $hashedNewPassword;
            $user->save();
            return back()->with(
                [
                    'Responsesuccess' => "1",
                    'responseTxt' => __("Updated")
                ]

            );
        }
    }
    public function show(Request $request)
    {
        $users = Client::all();
        return view('pages.users.index')->with(['users' => $users]);
    }



    public function enable(Request $request)
    {
        Client::where('id', $request->input('userId'))->update([
            'status' => '1'
        ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("User Enabled")
            ]

        );
    }
    public function disable(Request $request)
    {

        Client::where('id', $request->input('userId'))
            ->update([
                'status' => '-1'
            ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("User Disabled")
            ]

        );
    }
    public function reset(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');



        $client =   Client::where('id', $id)->where('number', $number)->first();
        if (!$client) {
            return back();
        }

        $newpassword = $this->generateRandomPassword();


        $client->update([
            'password' => Hash::make($newpassword)
        ]);


        $values = [
            "displayname" => $client->displayname,
            'username' => $client->username,
            'usernumber' => $number,
            'password' =>  $newpassword,
        ];
        Utility::SendEmail('reset_password', $values, 'Reset Passowrd', $client->email);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("New Password Sent")
            ]

        );
    }

    private function generateUniqueClientNumber()
    {
        do {

            $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Client::where('number', $randomNumber)->exists() && User::where('usernumber', $randomNumber)->exists());

        return $randomNumber;
    }

    function generateRandomPassword($length = 8)
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@%^&*()-_=+';
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomPassword;
    }
}
