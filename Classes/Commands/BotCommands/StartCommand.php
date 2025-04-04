<?php

namespace Classes\Commands\BotCommands;


use Classes\Commands\Kernal;
use Classes\Keyboards\Keyboards;
use Classes\Telegram\Telegram;

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