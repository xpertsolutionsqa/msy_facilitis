<?php

namespace App\Providers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function ($query) {

            if (strpos($query->sql, 'insert') === 0 || strpos($query->sql, 'update') === 0 || strpos($query->sql, 'delete') === 0) {

                if (strpos($query->sql, 'insert') === 0) {
                    $table = trim(explode(' ', $query->sql, 4)[2], '`');
                } elseif (strpos($query->sql, 'update') === 0) {
                    $table = trim(explode(' ', $query->sql, 4)[1], '`');
                } elseif (strpos($query->sql, 'delete') === 0) {
                    $table = trim(explode(' ', $query->sql, 3)[2], '`');
                }

                $type = '';
                $userid = '';
                $username = '';
                $usernumber = '';
                if ($table !== 'logs' && !($table === 'bookings' && strpos($query->sql, 'insert') === 0)) {
                    $user = Auth::user();
                    if ($user) {
                        $type = 'user';
                        $userid = $user->id;
                        $username = $user->displayname;
                        $usernumber = $user->usernumber;
                    } else {
                        $client = Auth::guard('client')->user();
                        if ($client) {
                            $type = 'client';
                            $userid = $client->id;
                            $username = $client->displayname;
                            $usernumber = $client->number;
                        }
                    }
                    $queryWithValues = vsprintf(str_replace('?', "'%s'", $query->sql), $query->bindings);
                    Log::create([
                        'user_type' => $type,
                        'user_id' => $userid,
                        'user_number' => $usernumber,
                        'user_name' => $username,
                        'query' => $queryWithValues,
                    ]);
                }
            }
        });
        // DB::listen(function ($query) {
        //     if (strpos($query->sql, 'insert') === 0 || strpos($query->sql, 'update') === 0) {


        //         if (strpos($query->sql, 'insert') === 0) {
        //             $table = trim(explode(' ', $query->sql, 4)[2], '`');
        //         } else {
        //             $table = trim(explode(' ', $query->sql, 4)[1], '`');
        //         }
        //         $type = '';
        //         $userid = '';
        //         $username = '';
        //         $usernumber = '';
        //         if ($table !== 'logs') {
        //             $user = Auth::user();

        //             if ($user) {
        //                 $type = 'user';
        //                 $userid = $user->id;
        //                 $username = $user->displayname;
        //                 $usernumber = $user->usernumber;
        //             } else {
        //                 $client = Auth::guard('client')->user();
        //                 if ($client) {
        //                     $type = 'client';
        //                     $userid = $client->id;
        //                     $username = $client->displayname;
        //                     $usernumber = $client->number;
        //                 }
        //             }
        //             $queryWithValues = vsprintf(str_replace('?', "'%s'", $query->sql), $query->bindings);

        //             Log::create([
        //                 'user_type' => $type,
        //                 'user_id' => $userid,
        //                 'user_number' => $usernumber,
        //                 'user_name' => $username,
        //                 'query' => $queryWithValues,
        //             ]);
        //         }
        //     }
        // });
    }
}
