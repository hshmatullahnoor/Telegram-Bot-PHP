<?php

namespace Utility\HelperCommands;

class webhook
{
    public static function set()
    {
        global $app;
        $url = $app['telegram_api_url'] . $app['telegram_token'] . '/setWebhook?url=' . $app['telegram_webhook_url'];

        $response = file_get_contents($url);

        $response = json_decode($response, true);

        if ($response['ok'] == true || $response['result'] == true) {
            echo "Webhook set successfully." . PHP_EOL;
        } else {
            echo $response['description'] . PHP_EOL;
        }
    }

    public static function delete()
    {
        global $app;
        $url = $app['telegram_api_url'] . $app['telegram_token'] . '/deleteWebhook';


        $response = file_get_contents($url);

        $response = json_decode($response, true);

        if ($response['ok'] == true || $response['result'] == true) {
            echo "Webhook deleted successfully." . PHP_EOL;
        } else {
            echo $response['description'] . PHP_EOL;
        }
    }
}
