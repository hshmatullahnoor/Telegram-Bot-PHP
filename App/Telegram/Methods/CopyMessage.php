<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class CopyMessage extends Connection
{
    private int|string $chatId;
    private int|string $fromChatId;
    private int $messageId;
    private ?int $messageThreadId = null;
    private ?int $videoStartTimestamp = null;
    private ?string $caption = null;
    private ?string $parseMode = null;
    private ?array $captionEntities = null;
    private ?bool $showCaptionAboveMedia = null;
    private ?bool $disableNotification = null;
    private ?bool $protectContent = null;
    private ?bool $allowPaidBroadcast = null;
    private ?array $replyParameters = null;
    private mixed $replyMarkup = null;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function fromChatId(int|string $fromChatId): self
    {
        $this->fromChatId = $fromChatId;
        return $this;
    }

    public function messageId(int $messageId): self
    {
        $this->messageId = $messageId;
        return $this;
    }

    public function messageThreadId(int $messageThreadId): self
    {
        $this->messageThreadId = $messageThreadId;
        return $this;
    }

    public function videoStartTimestamp(int $timestamp): self
    {
        $this->videoStartTimestamp = $timestamp;
        return $this;
    }

    public function caption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    public function parseMode(string $parseMode): self
    {
        $this->parseMode = $parseMode;
        return $this;
    }

    public function captionEntities(array $entities): self
    {
        $this->captionEntities = $entities;
        return $this;
    }

    public function showCaptionAboveMedia(bool $show = true): self
    {
        $this->showCaptionAboveMedia = $show;
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
        if (!isset($this->chatId) || !isset($this->fromChatId) || !isset($this->messageId)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id, from_chat_id and message_id are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'from_chat_id' => $this->fromChatId,
            'message_id' => $this->messageId
        ];

        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;
        if ($this->videoStartTimestamp) $params['video_start_timestamp'] = $this->videoStartTimestamp;
        if ($this->caption) $params['caption'] = $this->caption;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->captionEntities) $params['caption_entities'] = $this->captionEntities;
        if ($this->showCaptionAboveMedia) $params['show_caption_above_media'] = $this->showCaptionAboveMedia;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->allowPaidBroadcast) $params['allow_paid_broadcast'] = $this->allowPaidBroadcast;
        if ($this->replyParameters) $params['reply_parameters'] = $this->replyParameters;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('copyMessage', $params);
    }
}
