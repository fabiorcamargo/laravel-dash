<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\ApnsConfig;

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
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $token = $request->input('token');
            $title = $request->input('title');
            $body = $request->input('body');

            $notification = Notification::create($title, $body);

            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withDefaultSounds();

            $this->messaging->send($message);

            return response()->json(['success' => true, 'message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function sendMessages(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'usernames' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $usernames = $request->input('usernames');
            $users = explode(',', $usernames);

            dd($users);
            $fcmTokens = [];

            foreach ($users as $username) {
                $user = User::where('username', $username)->first();

                if ($user && $user->UserApp) {
                    $tokens = $user->UserApp->pluck('fcm_token')->toArray();
                    $fcmTokens = array_merge($fcmTokens, $tokens);
                }
            }

            if (empty($fcmTokens)) {
                return response()->json(['message' => 'Nenhum token FCM encontrado para os usuários especificados.'], 400);
            }

            $title = $request->input('title');
            $body = $request->input('body');
            $image = $request->input('image');

            // Incluindo a página inicial nos dados da notificação
            $data = [
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK', // para apps Flutter
                'initialPage' => 'auth3Profile', // Nome da página ou rota que deseja abrir
            ];

            $notification = Notification::create($title, $body, $image);

            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data)  // Adicionando os dados personalizados aqui
                ->withDefaultSounds()
                ->withApnsConfig(
                    ApnsConfig::new()
                        ->withBadge(1)
                )
                ;

            $report = $this->messaging->sendMulticast($message, $fcmTokens);

            $successes = $report->successes()->count();
            $failures = $report->failures()->count();

            return response()->json([
                'message' => 'Notificações enviadas.',
                'successes' => $successes,
                'failures' => $failures,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
