<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class DeleteMessages extends Connection
{
    private int|string $chatId;
    private array $messageIds;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
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

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->messageIds)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and message_ids are required'
            ]);
        }

        return parent::Connect('deleteMessages', [
            'chat_id' => $this->chatId,
            'message_ids' => $this->messageIds
        ]);
    }
}
