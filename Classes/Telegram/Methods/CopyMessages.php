<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class CopyMessages extends Connection
{
    private int|string $chatId;
    private int|string $fromChatId;
    private array $messageIds;
    private ?int $messageThreadId = null;
    private ?bool $disableNotification = null;
    private ?bool $protectContent = null;
    private ?bool $removeCaption = null;

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

    public function messageIds(array $messageIds): self
    {
        if (count($messageIds) > 100) {
            throw new \InvalidArgumentException('Maximum 100 message IDs allowed');
        }
        $this->messageIds = $messageIds;
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

    public function removeCaption(bool $remove = true): self
    {
        $this->removeCaption = $remove;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->fromChatId) || !isset($this->messageIds)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id, from_chat_id and message_ids are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'from_chat_id' => $this->fromChatId,
            'message_ids' => $this->messageIds
        ];

        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->removeCaption) $params['remove_caption'] = $this->removeCaption;

        return parent::Connect('copyMessages', $params);
    }
}
