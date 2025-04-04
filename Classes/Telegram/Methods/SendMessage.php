<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class SendMessage extends Connection
{
    private string|int $chatId;
    private string $text;
    private ?string $businessConnectionId = null;
    private ?int $messageThreadId = null;
    private ?string $parseMode = null;
    private ?array $entities = null;
    private ?array $linkPreviewOptions = null;
    private ?bool $disableNotification = null;
    private ?bool $protectContent = null;
    private ?bool $allowPaidBroadcast = null;
    private ?string $messageEffectId = null;
    private ?array $replyParameters = null;
    private mixed $replyMarkup = null;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function businessConnectionId(string $id): self
    {
        $this->businessConnectionId = $id;
        return $this;
    }

    public function messageThreadId(int $id): self
    {
        $this->messageThreadId = $id;
        return $this;
    }

    public function parseMode(string $mode): self
    {
        $this->parseMode = $mode;
        return $this;
    }

    public function entities(array $entities): self
    {
        $this->entities = $entities;
        return $this;
    }

    public function linkPreviewOptions(array $options): self
    {
        $this->linkPreviewOptions = $options;
        return $this;
    }

    public function disableNotification(bool $disable = true): self
    {
        $this->disableNotification = $disable;
        return $this;
    }

    public function protectContent(bool $protect = true): self
    {
        $this->protectContent = $protect;
        return $this;
    }

    public function allowPaidBroadcast(bool $allow = true): self
    {
        $this->allowPaidBroadcast = $allow;
        return $this;
    }

    public function messageEffectId(string $effectId): self
    {
        $this->messageEffectId = $effectId;
        return $this;
    }

    public function replyParameters(array $parameters): self
    {
        $this->replyParameters = $parameters;
        return $this;
    }

    public function replyMarkup(array|string $markup): self
    {
        $this->replyMarkup = is_array($markup) ? json_encode($markup) : $markup;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->text)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and text are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'text' => $this->text
        ];

        // Add optional parameters if set
        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->entities) $params['entities'] = $this->entities;
        if ($this->linkPreviewOptions) $params['link_preview_options'] = $this->linkPreviewOptions;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->allowPaidBroadcast) $params['allow_paid_broadcast'] = $this->allowPaidBroadcast;
        if ($this->messageEffectId) $params['message_effect_id'] = $this->messageEffectId;
        if ($this->replyParameters) $params['reply_parameters'] = $this->replyParameters;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('sendMessage', $params);
    }
}
