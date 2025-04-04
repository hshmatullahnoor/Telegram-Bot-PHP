<?php

namespace App\Telegram\Methods\EditMessage;

use App\Telegram\Connection;

class EditMessageText extends Connection
{
    private ?string $businessConnectionId = null;
    private string|int|null $chatId = null;
    private ?int $messageId = null;
    private ?string $inlineMessageId = null;
    private string $text;
    private ?string $parseMode = null;
    private ?array $entities = null;
    private ?array $linkPreviewOptions = null;
    private mixed $replyMarkup = null;

    public function text(string $text): self
    {
        $this->text = $text;
        return $this;
    }

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

    // ... common setter methods ...

    public function send(): string
    {
        if (!isset($this->text)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'text is required'
            ]);
        }

        if (!isset($this->inlineMessageId) && (!isset($this->chatId) || !isset($this->messageId))) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'Either inline_message_id or both chat_id and message_id are required'
            ]);
        }

        $params = ['text' => $this->text];

        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->chatId) $params['chat_id'] = $this->chatId;
        if ($this->messageId) $params['message_id'] = $this->messageId;
        if ($this->inlineMessageId) $params['inline_message_id'] = $this->inlineMessageId;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->entities) $params['entities'] = $this->entities;
        if ($this->linkPreviewOptions) $params['link_preview_options'] = $this->linkPreviewOptions;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('editMessageText', $params);
    }
}
