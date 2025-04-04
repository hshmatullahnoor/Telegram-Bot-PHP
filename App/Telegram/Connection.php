<?php

namespace App\Telegram;

require_once __DIR__ . '/../../config.php';

class Connection
{

    private static string $apiUrl = TELEGRAM_API_URL;
    private static string $token = TELEGRAM_TOKEN;


    public static function Connect(string $method, array $params = [], string | null $token = null, string | null $apiUrl = null): string
    {
        if (is_null($token)) {
            $token = self::$token;
        }
        if (is_null($apiUrl)) {
            $apiUrl = self::$apiUrl;
        }

        $url = $apiUrl . $token . '/' . $method;

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($response === false) {
            return json_encode([
                'ok' => false,
                'error_code' => $httpCode,
                'description' => 'Curl error: ' . curl_error($ch)
            ]);
        }

        return $response;
    }
}
