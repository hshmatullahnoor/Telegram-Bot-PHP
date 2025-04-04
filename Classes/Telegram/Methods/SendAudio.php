<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class SendAudio extends Connection
{
    private int|string $chatId;
    private string $audio;
    private ?string $businessConnectionId = null;
    private ?int $messageThreadId = null;
    private ?string $caption = null;
    private ?string $parseMode = null;
    private ?array $captionEntities = null;
    private ?int $duration = null;
    private ?string $performer = null;
    private ?string $title = null;
    private ?string $thumbnail = null;
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

    public function audio(string $audio): self
    {
        $this->audio = $audio;
        return $this;
    }

    public function duration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function performer(string $performer): self
    {
        $this->performer = $performer;
        return $this;
    }

    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function thumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    // ...existing setter methods for common parameters...

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->audio)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and audio are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'audio' => $this->audio
        ];

        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;
        if ($this->caption) $params['caption'] = $this->caption;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->captionEntities) $params['caption_entities'] = $this->captionEntities;
        if ($this->duration) $params['duration'] = $this->duration;
        if ($this->performer) $params['performer'] = $this->performer;
        if ($this->title) $params['title'] = $this->title;
        if ($this->thumbnail) $params['thumbnail'] = $this->thumbnail;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->allowPaidBroadcast) $params['allow_paid_broadcast'] = $this->allowPaidBroadcast;
        if ($this->messageEffectId) $params['message_effect_id'] = $this->messageEffectId;
        if ($this->replyParameters) $params['reply_parameters'] = $this->replyParameters;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('sendAudio', $params);
    }
}
