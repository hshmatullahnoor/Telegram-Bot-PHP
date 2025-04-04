<?php

namespace App\Keyboards;

use App\Helpers\MakeInlineKeyboard;

class InlineKeyboards
{
    public static array $inlineKeyboards = [
        'main' => [
            'start' => [
                'text' => 'شروع',
                'callback_data' => '/start'
            ],
            'help' => [
                'text' => 'راهنما',
                'callback_data' => '/help'
            ],
            'settings' => [
                'text' => 'تنظیمات ⚙️',
                'callback_data' => '/settings'
            ],
            'about' => [
                'text' => 'درباره ما 📝',
                'callback_data' => '/about'
            ],
        ],
    ];


    public static function mainKeyboard()
    {
        return MakeInlineKeyboard::row()
            ->btn(self::$inlineKeyboards['main']['start']['text'], self::$inlineKeyboards['main']['start']['callback_data'])
            ->row()
            ->btn(self::$inlineKeyboards['main']['help']['text'], self::$inlineKeyboards['main']['help']['callback_data'])
            ->btn(self::$inlineKeyboards['main']['settings']['text'], self::$inlineKeyboards['main']['settings']['callback_data'])
            ->row()
            ->btn(self::$inlineKeyboards['main']['about']['text'], self::$inlineKeyboards['main']['about']['callback_data'])
            ->make();
    }
}
