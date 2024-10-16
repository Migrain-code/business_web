<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
class NotificationService
{
    public static function sendPushNotification($expoToken, $title, $body)
    {
        try {
            $client = new Client();
            $response = $client->post('https://exp.host/--/api/v2/push/send', [
                'json' => [
                    'to' => $expoToken,
                    'title' => $title,
                    'body' => $body,
                    'sound'=> 'default',
                ],
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Hata durumunda loglamak için veya başka işlemler için buraya kod ekleyebilirsiniz.
            // Örneğin:
            Log::error('Push notification error: ', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
