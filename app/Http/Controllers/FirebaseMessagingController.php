<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseMessagingController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(storage_path('app/profissionaliza-app-7wmniq-firebase-adminsdk-aceib-349faaebd2.json'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendMessage(Request $request)
    {
        $token = $request->input('token');
        $title = $request->input('title');
        $body = $request->input('body');

        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        $this->messaging->send($message);

        return response()->json(['success' => true, 'message' => 'Notification sent successfully']);
    }

    public function sendMessages(Request $request)
    {
        $token = $request->input('token');
        $deviceTokens = ['dBnuulI_QbKBdMzEoPFLnT:APA91bFbTn64pjICYL4Sk7i7WOHxlC94qvrMpL9h-yZufTm1Ipxhes7_S0fbDDvYoKHrSjm3hhWFj62M_QyMYL8ynMecZJQmjFVKsbPQ4nSU2-h_dos1Y-i_umnm_FtaGKGvNv7d8sXF', 'cLCJQjIAQUGS1uhostp0FP:APA91bHhOOact2FNb2ha3ojc0Fu8_7-d8G_oNgt-9OJ3xyTAUx_Z6SYqLVnitKzTRHPoNMIlcMhzfiIJZkt9MyKj2yf4v9_84sq0Ig96Oa4fZhHUgSdzZf5mZPxDFK73UUOuP40-ufpO', 'eAOU5oIkB06xoHC_SikjqQ:APA91bH-G7GKXx-vO8zodoShXe7duNOdxJIQztrevxNpPd0E9PsNhypYCq34mCXcsdTxA6ZG7ppQ6r9BmQrvFb3hRsFjLKZYfYMAffX-bA-NprWHrXhxUePg-DE4mOYs8Qj_aMns59Dw' /* ... */];

        $title = $request->input('title');
        $body = $request->input('body');

        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);


        $this->messaging->sendMulticast($message, $deviceTokens);

        return response()->json(['success' => true, 'message' => 'Notification sent successfully']);
    }
}
