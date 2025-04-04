<?php

namespace Classes\Commands\BotCommands;


use Classes\Commands\Kernal;
use Classes\Keyboards\Keyboards;
use Classes\Telegram\Telegram;

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