<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class SendDocument extends Connection
{
    private int|string $chatId;
    private string $document;
    private ?string $businessConnectionId = null;
    private ?int $messageThreadId = null;
    private ?string $thumbnail = null;
    private ?string $caption = null;
    private ?string $parseMode = null;
    private ?array $captionEntities = null;
    private ?bool $disableContentTypeDetection = null;
    private ?bool $disableNotification = null;
    private ?bool $protectContent = null;
    private ?bool $allowPaidBroadcast = null;
    private ?string $messageEffectId = null;
    private ?array $replyParameters = null;
    private mixed $replyMarkup = null;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function document(string $document): self
    {
        $this->document = $document;
        return $this;
    }

    // ...common setter methods like businessConnectionId, messageThreadId, etc...

    public function thumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    public function disableContentTypeDetection(bool $disable = true): self
    {
        $this->disableContentTypeDetection = $disable;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->document)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and document are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'document' => $this->document
        ];

        // Add optional parameters
        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;
        if ($this->thumbnail) $params['thumbnail'] = $this->thumbnail;
        if ($this->caption) $params['caption'] = $this->caption;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->captionEntities) $params['caption_entities'] = $this->captionEntities;
        if ($this->disableContentTypeDetection) $params['disable_content_type_detection'] = $this->disableContentTypeDetection;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->allowPaidBroadcast) $params['allow_paid_broadcast'] = $this->allowPaidBroadcast;
        if ($this->messageEffectId) $params['message_effect_id'] = $this->messageEffectId;
        if ($this->replyParameters) $params['reply_parameters'] = $this->replyParameters;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('sendDocument', $params);
    }
}
