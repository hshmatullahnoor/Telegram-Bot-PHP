<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class AnswerCallbackQuery extends Connection
{
    private string $callbackQueryId;
    private ?string $text = null;
    private ?bool $showAlert = null;
    private ?string $url = null;
    private ?int $cacheTime = null;

    public function callbackQueryId(string $callbackQueryId): self
    {
        $this->callbackQueryId = $callbackQueryId;
        return $this;
    }

    public function text(string $text): self
    {
        if (strlen($text) > 200) {
            throw new \InvalidArgumentException('Text must not exceed 200 characters');
        }
        $this->text = $text;
        return $this;
    }

    public function showAlert(bool $show = true): self
    {
        $this->showAlert = $show;
        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function cacheTime(int $seconds): self
    {
        $this->cacheTime = $seconds;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->callbackQueryId)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'callback_query_id is required'
            ]);
        }

        $params = ['callback_query_id' => $this->callbackQueryId];

        if ($this->text) $params['text'] = $this->text;
        if ($this->showAlert) $params['show_alert'] = $this->showAlert;
        if ($this->url) $params['url'] = $this->url;
        if ($this->cacheTime) $params['cache_time'] = $this->cacheTime;

        return parent::Connect('answerCallbackQuery', $params);
    }
}
