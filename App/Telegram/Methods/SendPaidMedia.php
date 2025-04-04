<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class SendPaidMedia extends Connection
{
    private int|string $chatId;
    private int $starCount;
    private array $media;
    private ?string $businessConnectionId = null;
    private ?string $payload = null;
    private ?string $caption = null;
    private ?string $parseMode = null;
    private ?array $captionEntities = null;
    private ?bool $showCaptionAboveMedia = null;
    private ?bool $disableNotification = null;
    private ?bool $protectContent = null;
    private ?bool $allowPaidBroadcast = null;
    private ?array $replyParameters = null;
    private mixed $replyMarkup = null;

    public function chatId(int|string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function starCount(int $count): self
    {
        if ($count < 1 || $count > 2500) {
            throw new \InvalidArgumentException('Star count must be between 1 and 2500');
        }
        $this->starCount = $count;
        return $this;
    }

    public function media(array $media): self
    {
        if (count($media) > 10) {
            throw new \InvalidArgumentException('Maximum 10 media items allowed');
        }
        $this->media = $media;
        return $this;
    }

    public function businessConnectionId(string $id): self
    {
        $this->businessConnectionId = $id;
        return $this;
    }

    public function payload(string $payload): self
    {
        if (strlen($payload) > 128) {
            throw new \InvalidArgumentException('Payload must not exceed 128 bytes');
        }
        $this->payload = $payload;
        return $this;
    }

    public function caption(string $caption): self
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

    public function disableNotification(bool $disable = true): self
    {
        $this->disableNotification = $disable;
        return $this;
    }

    public function protectContent(bool $protect = true): self
    {
        $this->protectContent = $protect;
        return $this;
    }

    public function allowPaidBroadcast(bool $allow = true): self
    {
        $this->allowPaidBroadcast = $allow;
        return $this;
    }

    public function replyParameters(array $parameters): self
    {
        $this->replyParameters = $parameters;
        return $this;
    }

    public function replyMarkup(array|string $markup): self
    {
        $this->replyMarkup = is_array($markup) ? json_encode($markup) : $markup;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->starCount) || !isset($this->media)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id, star_count and media are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'star_count' => $this->starCount,
            'media' => $this->media
        ];

        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->payload) $params['payload'] = $this->payload;
        if ($this->caption) $params['caption'] = $this->caption;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->captionEntities) $params['caption_entities'] = $this->captionEntities;
        if ($this->showCaptionAboveMedia) $params['show_caption_above_media'] = $this->showCaptionAboveMedia;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->allowPaidBroadcast) $params['allow_paid_broadcast'] = $this->allowPaidBroadcast;
        if ($this->replyParameters) $params['reply_parameters'] = $this->replyParameters;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('sendPaidMedia', $params);
    }
}
