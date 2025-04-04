<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class ForwardMessage extends Connection
{
    private int|string $chatId;
    private int|string $fromChatId;
    private int $messageId;
    private ?int $messageThreadId = null;
    private ?bool $disableNotification = null;
    private ?bool $protectContent = null;
    private ?int $videoStartTimestamp = null;

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

    public function videoStartTimestamp(int $timestamp): self
    {
        $this->videoStartTimestamp = $timestamp;
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
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->videoStartTimestamp) $params['video_start_timestamp'] = $this->videoStartTimestamp;

        return parent::Connect('forwardMessage', $params);
    }
}
