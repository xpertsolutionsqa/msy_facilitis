<?php


// app/Http/Controllers/LanguageController.php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    
    public function remove(Request $request)
    {
        $dir = base_path();
        $path = $dir . '/resources/lang/ar.json';
        $keyToRemove = $request->input('key');

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!array_key_exists($keyToRemove, $data)) {
            return back()->with(
                [
                    'Responseerror' => "1",
                    'responseTxt' => __("no key")
                ]

            );
        }

        unset($data[$keyToRemove]);
        $newJson = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($path, $newJson);
        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Done")
            ]

        );
    }

    public function save(Request $request)
    {
        $array = $request->input('enlabel');
        foreach ($array as $key => $value) {
            if (is_null($value)) {
                $array[$key] = $key;
            }
        }
        $dir = base_path();
        file_put_contents($dir . '/resources/lang/ar.json', json_encode($request->input('arlabel')));
        file_put_contents($dir . '/resources/lang/en.json', json_encode($array));

        return back()->with(
            [
                'Responsesuccess' => "1",
                'responseTxt' => __("Updated")
            ]

        );
    }

    public function manage(Request $request)
    {
        $dir = base_path();
        $arLabels   = json_decode(file_get_contents($dir . '/resources/lang/ar.json'));
        $enLabels   = json_decode(file_get_contents($dir . '/resources/lang/en.json'));

        return view('pages.lang.manage')->with([
            'arlabels' => $arLabels,
            'enlabels' => $enLabels
        ]);
    }

    public function switchLang($locale)
    {
        if (array_key_exists($locale, config('app.locales'))) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        if (Auth::check()) {
            $user = Auth::user();
            User::where('id', $user->id)->update(['locale' => $locale]);
        }
        if (Auth::guard('client')->check()) {
            $client = Auth::guard('client')->user();
            Client::where('id', $client->id)->update(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
