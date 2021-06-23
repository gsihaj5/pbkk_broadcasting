<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return view("messaging");
});

Route::post("/broadcasting/auth", function (Request $request) {
    $socket_id = $request->input("socket_id");
    $channel_name = $request->input("channel_name");
    $username_pengirim =
        $request->header("X-Name") ?? $request->input("X-Name");

    $string = $socket_id . ":" . $channel_name;

    $user_info = null;
    if ($username_pengirim) {
        $user_info = [
            "user_id" => $username_pengirim,
            "user_info" => [
                "name" => $username_pengirim,
            ],
        ];

        $string = $string . ":" . json_encode($user_info);
    }

    $sig = hash_hmac("sha256", $string, config("app.pusher_secret"));

    $auth = config("app.pusher_key") . ":" . $sig;

    return [
        "auth" => $auth,
        "channel_data" => $user_info != null ? json_encode($user_info) : null,
    ];
});
//Route::get('/todo', function () {
//return view('todo');
//});

Route::get("/todo/{path?}", function () {
    return view("app");
})->where("path", ".*");
