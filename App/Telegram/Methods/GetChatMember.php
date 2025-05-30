<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class GetChatMember extends Connection
{
    private int|string $chatId;
    private int $userId;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function userId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->userId)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and user_id are required'
            ]);
        }

        return parent::Connect('getChatMember', [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId
        ]);
    }
}
