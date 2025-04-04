<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class SetMessageReaction extends Connection
{
    private int|string $chatId;
    private int $messageId;
    private ?array $reaction = null;
    private ?bool $isBig = null;

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

    public function reaction(array $reaction): self
    {
        $this->reaction = $reaction;
        return $this;
    }

    public function isBig(bool $isBig = true): self
    {
        $this->isBig = $isBig;
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

        $params = [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId
        ];

        if ($this->reaction) $params['reaction'] = $this->reaction;
        if ($this->isBig) $params['is_big'] = $this->isBig;

        return parent::Connect('setMessageReaction', $params);
    }
}
