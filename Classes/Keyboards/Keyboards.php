<?php


namespace Classes\Keyboards;

use Classes\Helpers\MakeKeyboard;

class Keyboards
{
    public static array $keyboardBTNs = [
        'main' => [
            'start' => '/start',
            'help' => '/help',
            'settings' => 'تنظیمات ⚙️',
            'about' => 'درباره ما 📝',
            'feedback' => 'نظرات و پیشنهادات 💬',
        ],
        'settings' => [
            'language' => 'زبان',
            'notifications' => 'اعلان ها',
            'privacy' => 'حریم خصوصی',
            'security' => 'امنیت',
            'back' => 'بازگشت 🔙',
        ],
        'feedback' => [
            'send_feedback' => 'ارسال نظر',
            'view_feedback' => 'مشاهده نظرات',
            'delete_feedback' => 'حذف نظر',
            'back' => 'بازگشت 🔙',
        ],
        'about' => [
            'about_app' => 'درباره اپلیکیشن',
            'about_developer' => 'درباره توسعه دهنده',
            'contact' => 'تماس با ما',
            'back' => 'بازگشت 🔙',
        ],
        'help' => [
            'faq' => 'سوالات متداول',
            'contact_support' => 'تماس با پشتیبانی',
            'back' => 'بازگشت 🔙',
        ],
    ];

    public static function mainKeyboard()
    {
        return MakeKeyboard::row()
            ->btn(self::$keyboardBTNs['main']['start'])
            ->row()
            ->btn(self::$keyboardBTNs['main']['help'])
            ->btn(self::$keyboardBTNs['main']['settings'])
            ->row()
            ->btn(self::$keyboardBTNs['main']['about'])
            ->btn(self::$keyboardBTNs['main']['feedback'])
            ->make();
    }

    public static function settingsKeyboard()
    {
        return MakeKeyboard::row()
            ->btn(self::$keyboardBTNs['settings']['language'])
            ->row()
            ->btn(self::$keyboardBTNs['settings']['notifications'])
            ->btn(self::$keyboardBTNs['settings']['privacy'])
            ->row()
            ->btn(self::$keyboardBTNs['settings']['security'])
            ->btn(self::$keyboardBTNs['settings']['back'])
            ->make();
    }

    public static function feedbackKeyboard()
    {
        return MakeKeyboard::row()
            ->btn(self::$keyboardBTNs['feedback']['send_feedback'])
            ->row()
            ->btn(self::$keyboardBTNs['feedback']['view_feedback'])
            ->btn(self::$keyboardBTNs['feedback']['delete_feedback'])
            ->row()
            ->btn(self::$keyboardBTNs['feedback']['back'])
            ->make();
    }

    public static function aboutKeyboard()
    {
        return MakeKeyboard::row()
            ->btn(self::$keyboardBTNs['about']['about_app'])
            ->row()
            ->btn(self::$keyboardBTNs['about']['about_developer'])
            ->btn(self::$keyboardBTNs['about']['contact'])
            ->row()
            ->btn(self::$keyboardBTNs['about']['back'])
            ->make();
    }

    public static function helpKeyboard()
    {
        return MakeKeyboard::row()
            ->btn(self::$keyboardBTNs['help']['faq'])
            ->row()
            ->btn(self::$keyboardBTNs['help']['contact_support'])
            ->btn(self::$keyboardBTNs['help']['back'])
            ->make();
    }
}