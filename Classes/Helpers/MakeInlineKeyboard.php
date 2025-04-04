<?php

namespace Classes\Helpers;

class MakeInlineKeyboard
{
    private $keyboard = [];
    private $currentRow = [];
    private static $instance = null;

    private function __construct() {}

    public static function row()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        if (!empty(self::$instance->currentRow)) {
            self::$instance->keyboard[] = self::$instance->currentRow;
            self::$instance->currentRow = [];
        }

        return self::$instance;
    }

    public function btn($text, $callback_data)
    {
        $this->currentRow[] = [
            'text' => $text,
            'callback_data' => $callback_data
        ];
        return $this;
    }

    public function url($text, $url)
    {
        $this->currentRow[] = [
            'text' => $text,
            'url' => $url
        ];
        return $this;
    }

    public function make()
    {
        if (!empty($this->currentRow)) {
            $this->keyboard[] = $this->currentRow;
        }

        $result = [
            'inline_keyboard' => $this->keyboard
        ];

        // Reset the instance
        self::$instance = null;

        return json_encode($result);
    }
}

// Example usage:
// $keyboard = MakeInlineKeyboard::row()
//     ->btn('Click me', 'click_action')
//     ->url('Visit site', 'https://example.com')
//     ->row()
//     ->btn('Option 1', 'opt1')
//     ->btn('Option 2', 'opt2')
//     ->make();