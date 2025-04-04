<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class GetChatMemberCount extends Connection
{
    private int|string $chatId;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->chatId)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id is required'
            ]);
        }

        return parent::Connect('getChatMemberCount', ['chat_id' => $this->chatId]);
    }
}
