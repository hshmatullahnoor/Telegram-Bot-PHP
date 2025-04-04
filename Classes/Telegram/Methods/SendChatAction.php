<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class SendChatAction extends Connection
{
    private int|string $chatId;
    private string $action;
    private ?string $businessConnectionId = null;
    private ?int $messageThreadId = null;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function action(string $action): self
    {
        $this->action = $action;
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

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->action)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and action are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'action' => $this->action
        ];

        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;

        return parent::Connect('sendChatAction', $params);
    }
}
