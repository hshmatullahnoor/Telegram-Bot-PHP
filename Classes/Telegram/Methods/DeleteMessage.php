<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class DeleteMessage extends Connection
{
    private int|string $chatId;
    private int $messageId;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function messageId(int $messageId): self
    {
        $this->messageId = $messageId;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->messageId)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and message_id are required'
            ]);
        }

        return parent::Connect('deleteMessage', [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId
        ]);
    }
}
