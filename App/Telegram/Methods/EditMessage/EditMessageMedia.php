<?php

namespace App\Telegram\Methods\EditMessage;

use App\Telegram\Connection;

class EditMessageMedia extends Connection
{
    private ?string $businessConnectionId = null;
    private string|int|null $chatId = null;
    private ?int $messageId = null;
    private ?string $inlineMessageId = null;
    private array $media;
    private mixed $replyMarkup = null;

    public function businessConnectionId(string $id): self
    {
        $this->businessConnectionId = $id;
        return $this;
    }

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

    public function inlineMessageId(string $inlineMessageId): self
    {
        $this->inlineMessageId = $inlineMessageId;
        return $this;
    }

    public function media(array $media): self
    {
        $this->media = $media;
        return $this;
    }

    public function replyMarkup(array|string $markup): self
    {
        $this->replyMarkup = is_array($markup) ? json_encode($markup) : $markup;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->media)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'media is required'
            ]);
        }

        if (!isset($this->inlineMessageId) && (!isset($this->chatId) || !isset($this->messageId))) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'Either inline_message_id or both chat_id and message_id are required'
            ]);
        }

        $params = ['media' => $this->media];

        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->chatId) $params['chat_id'] = $this->chatId;
        if ($this->messageId) $params['message_id'] = $this->messageId;
        if ($this->inlineMessageId) $params['inline_message_id'] = $this->inlineMessageId;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('editMessageMedia', $params);
    }
}
