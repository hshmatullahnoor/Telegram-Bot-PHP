<?php

namespace App\Commands\BotCommands;


use App\Commands\Kernal;
use App\Keyboards\Keyboards;
use App\Telegram\Telegram;

class HelpCommand extends Kernal
{
    public static function handle()
    {
        if (self::$text == '/help') {
            Telegram::sendMessage()
                ->chatId(self::$chatId)
                ->text("Here are some commands you can use:")
                ->replyMarkup(Keyboards::helpKeyboard())
                ->send();
        }
    }
}
