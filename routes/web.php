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
    $string = $socket_id . ":" . $channel_name;

    $sig = hash_hmac("sha256", $string, config("app.pusher_secret"));

    return [
        "auth" => config("app.pusher_key") . ":" . $sig,
        "key" => config("app.pusher_key"),
        "secret" => config("app.pusher_secret"),
    ];
});
//Route::get('/todo', function () {
//return view('todo');
//});

Route::get("/todo/{path?}", function () {
    return view("app");
})->where("path", ".*");
