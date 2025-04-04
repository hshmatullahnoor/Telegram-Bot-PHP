<?php

namespace Classes\Helpers;

class MakeKeyboard
{
    private $keyboard = [];
    private $currentRow = [];
    private static $instance = null;
    private $resize_keyboard = true;
    private $one_time_keyboard = true;

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

    public function btn($text)
    {
        $this->currentRow[] = ['text' => $text];
        return $this;
    }

    public function make()
    {
        if (!empty($this->currentRow)) {
            $this->keyboard[] = $this->currentRow;
        }

        $result = [
            'keyboard' => $this->keyboard,
            'resize_keyboard' => $this->resize_keyboard,
            'one_time_keyboard' => $this->one_time_keyboard
        ];

        // Reset the instance
        self::$instance = null;

        return json_encode($result);
    }

    public function resize($value = true)
    {
        $this->resize_keyboard = $value;
        return $this;
    }

    public function oneTime($value = true)
    {
        $this->one_time_keyboard = $value;
        return $this;
    }
}

