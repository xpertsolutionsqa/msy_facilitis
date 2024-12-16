<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{

    public function showAdmins(Request $request)
    {
        $user = Auth::user();
        $admins = User::all();
        return view('pages.admins')->with(['admins' => $admins, 'user' => $user]);
    }

    public function create(Request $request)
    {

        $displayname = $request->input('displayname');
        $username = $request->input('username');
        $email = $request->input('email');
        $phonenumber = $request->input('phone');
        $level = $request->input('level');
        $add_facility = $request->input("add_facility") != null ? 1 : 0;
        $club_id = $request->input("club") ?? 0;

        $olduser = User::where((function ($query) use ($email, $username) {
            $query->where('email', $email)
                ->orwhere('username', $username);
        }
        ))->first();

        if ($olduser) {
            return back()->with([
                'Responseerror' => "1",
                'responseTxt' => __("User Exists")
            ]);
        }

        $number = $this->generateUniqueUserNumber();

        User::create([
            "usernumber" => $number,
            "displayname" => $displayname,
            "username" =>  $username,
            "email" => $email,
            "phone" => $phonenumber,
            "level" => $level,
            "add_facility" => $add_facility,
            "club_id" => $club_id,
            "status" => '1',

        ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Admin Created")
            ]

        );
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $number = $request->input('number');

        $user = User::where('id', $id)->where('usernumber', $number)->first();
        if (!$user) {

            return back()->with([
                'Responseerror' => "1",
                'responseTxt' => ''
            ]);
        }

        $displayname = $request->input('displayname');
        $username = $request->input('username');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $user_level  = $request->input('level');
        $club  = $request->input('club');

        $otherUser = User::where('id', '!=', $id)->where((function ($query) use ($email, $username) {
            $query->where('email', $email)
                ->orwhere('username', $username);
        }
        ))->first();

        if ($otherUser) {
            return back()->with([
                'Responseerror' => "1",
                'responseTxt' => __("User Exists")
            ]);
        }

        $user->update([

            "username" => $username,
            "displayname" => $displayname,
            "email" => $email,
            "phone" => $phone,
            "level" => $user_level,
            "club_id" => $club,

        ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Updated")
            ]
        );
    }

    public function changepassword(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return back();
        }
        $password = $request->input('current_pass');
        if (!Hash::check($password, $user->password)) {
            return back()->with([
                'Responseerror' => "1",
                'responseTxt' => __("Wrong Password")
            ]);
        }
        $admin = Admin::where('id', $user->id)->first();
        $newpassword = $request->input('new_pass');
        $hashedNewPassword = Hash::make($newpassword);
        $admin->password = $hashedNewPassword;
        $admin->update();
        return back()->with([
            'Responsesuccess' => "1",
            'responseTxt' => __("Password Updated")

        ]);
    }

    public function disable(Request $request)
    {

        User::where('id', $request->input('adId'))
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


    public function enable(Request $request)
    {
        User::where('id', $request->input('adId'))->update([
            'status' => '1'
        ]);


        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("User Enabled")
            ]

        );
    }

    private function generateUniqueUserNumber()
    {
        do {

            $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (User::where('usernumber', $randomNumber)->exists() && Client::where('number', $randomNumber)->exists());

        return $randomNumber;
    }
}
