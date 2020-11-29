<?php

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

Route::post('/send-test-email', function (Request $request) {
    //TODO: Extract in controller
    //TODO: Implement support for native SMTP and mailgun
    //TODO: Create default mailer with native SMTP
    if ($request->get('type') === 'custom_smtp') {
        $mailer = app()->makeWith('custom.smtp.mailer', $request->all());
    } else if ($request->get('type') === 'custom_mailgun') {
        //TODO: Not tested
        $mailer = app()->makeWith('custom.mailgun.mailer', $request->all());
    }
    $mailer->to($request->get('to'))->send(new \App\Mail\TestEmail());
});
