<?php

namespace App\Commands;

class Kernal
{
    protected static $update;
    protected static $message;
    protected static $callback_query;
    protected static $channel_post;
    protected static $edited_message;
    protected static $chat;
    protected static $text;
    protected static $messageId;
    protected static $fromId;
    protected static $chatId;
    protected static $callbackData;

    public function __construct($update)
    {
        self::$update = $update;
        $this->parseUpdate();
    }

    protected function parseUpdate()
    {
        self::$message = self::$update['message'] ?? null;
        self::$callback_query = self::$update['callback_query'] ?? null;
        self::$channel_post = self::$update['channel_post'] ?? null;
        self::$edited_message = self::$update['edited_message'] ?? null;

        if (self::$message) {
            self::$chat = self::$message['chat'];
            self::$text = self::$message['text'] ?? null;
            self::$messageId = self::$message['message_id'];
            self::$fromId = self::$message['from']['id'];
            self::$chatId = self::$message['chat']['id'];
        }

        if (self::$callback_query) {
            self::$callbackData = self::$callback_query['data'];
            self::$fromId = self::$callback_query['from']['id'];
            self::$messageId = self::$callback_query['message']['message_id'];
            self::$chatId = self::$callback_query['message']['chat']['id'];
        }
    }

    public static function getMessage()
    {
        return self::$message;
    }

    public static function getCallbackQuery()
    {
        return self::$callback_query;
    }

    public static function getText()
    {
        return self::$text;
    }

    public static function getChat()
    {
        return self::$chat;
    }

    public static function getMessageId()
    {
        return self::$messageId;
    }

    public static function getFromId()
    {
        return self::$fromId;
    }

    public static function getChatId()
    {
        return self::$chatId;
    }

    public static function getCallbackData()
    {
        return self::$callbackData;
    }

    public static function init($update)
    {
        return new static($update);
    }

    public static function updateType()
    {
        if (isset(self::$update['message'])) {
            return 'message';
        } elseif (isset(self::$update['callback_query'])) {
            return 'callback_query';
        }
        return null;
    }
}
