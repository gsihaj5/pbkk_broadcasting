<?php

use App\Events\MessageSent;
use App\Events\MessageSentRoom;
use App\Events\MessageBroadcasted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:api")->get("/user", function (Request $request) {
    return $request->user();
});

Route::post("/message", function (Request $request) {
    switch ($request->input("scope")) {
        case "private":
            return event(
                new MessageSent(
                    $request->input("message"),
                    $request->input("name_from"),
                    (new DateTime())->getTimestamp()
                )
            );
        case "public":
            return event(
                new MessageBroadcasted(
                    $request->input("message"),
                    $request->input("name_from"),
                    (new DateTime())->getTimestamp()
                )
            );
        case "presence":
        default:
            return event(
                new MessageSentRoom(
                    $request->input("message"),
                    $request->input("name_from"),
                    (new DateTime())->getTimestamp()
                )
            );
    }
});
