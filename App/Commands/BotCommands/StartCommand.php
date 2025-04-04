<?php

namespace App\Commands\BotCommands;


use App\Commands\Kernal;
use App\Keyboards\Keyboards;
use App\Telegram\Telegram;

class StartCommand extends Kernal
{
    public static function handle()
    {
        if (self::$text == '/start') {
            Telegram::sendMessage()
                ->chatId(self::$chatId)
                ->text("Welcome to the bot! Please choose an option:")
                ->replyMarkup(Keyboards::mainKeyboard())
                ->send();
        }
    }
}
