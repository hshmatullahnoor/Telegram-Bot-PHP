<?php

namespace App\Telegram\Methods\EditMessage;

use App\Telegram\Connection;

class EditMessageCaption extends Connection
{
    private ?string $businessConnectionId = null;
    private string|int|null $chatId = null;
    private ?int $messageId = null;
    private ?string $inlineMessageId = null;
    private ?string $caption = null;
    private ?string $parseMode = null;
    private ?array $captionEntities = null;
    private ?bool $showCaptionAboveMedia = null;
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

    public function caption(?string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    public function parseMode(string $mode): self
    {
        $this->parseMode = $mode;
        return $this;
    }

    public function captionEntities(array $entities): self
    {
        $this->captionEntities = $entities;
        return $this;
    }

    public function showCaptionAboveMedia(bool $show = true): self
    {
        $this->showCaptionAboveMedia = $show;
        return $this;
    }

    public function replyMarkup(array|string $markup): self
    {
        $this->replyMarkup = is_array($markup) ? json_encode($markup) : $markup;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->inlineMessageId) && (!isset($this->chatId) || !isset($this->messageId))) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'Either inline_message_id or both chat_id and message_id are required'
            ]);
        }

        $params = [];

        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->chatId) $params['chat_id'] = $this->chatId;
        if ($this->messageId) $params['message_id'] = $this->messageId;
        if ($this->inlineMessageId) $params['inline_message_id'] = $this->inlineMessageId;
        if ($this->caption !== null) $params['caption'] = $this->caption;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->captionEntities) $params['caption_entities'] = $this->captionEntities;
        if ($this->showCaptionAboveMedia) $params['show_caption_above_media'] = $this->showCaptionAboveMedia;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('editMessageCaption', $params);
    }
}
