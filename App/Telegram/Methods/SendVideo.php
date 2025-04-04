<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class SendVideo extends Connection
{
    private int|string $chatId;
    private string $video;
    private ?string $businessConnectionId = null;
    private ?int $messageThreadId = null;
    private ?int $duration = null;
    private ?int $width = null;
    private ?int $height = null;
    private ?string $thumbnail = null;
    private ?string $cover = null;
    private ?int $startTimestamp = null;
    private ?string $caption = null;
    private ?string $parseMode = null;
    private ?array $captionEntities = null;
    private ?bool $showCaptionAboveMedia = null;
    private ?bool $hasSpoiler = null;
    private ?bool $supportsStreaming = null;
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

    public function video(string $video): self
    {
        $this->video = $video;
        return $this;
    }

    // Video-specific setters
    public function duration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function width(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    public function height(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    public function cover(string $cover): self
    {
        $this->cover = $cover;
        return $this;
    }

    public function startTimestamp(int $timestamp): self
    {
        $this->startTimestamp = $timestamp;
        return $this;
    }

    public function supportsStreaming(bool $supports = true): self
    {
        $this->supportsStreaming = $supports;
        return $this;
    }

    // ...common setter methods...

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->video)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id and video are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'video' => $this->video
        ];

        // Add video-specific parameters
        if ($this->duration) $params['duration'] = $this->duration;
        if ($this->width) $params['width'] = $this->width;
        if ($this->height) $params['height'] = $this->height;
        if ($this->thumbnail) $params['thumbnail'] = $this->thumbnail;
        if ($this->cover) $params['cover'] = $this->cover;
        if ($this->startTimestamp) $params['start_timestamp'] = $this->startTimestamp;
        if ($this->supportsStreaming) $params['supports_streaming'] = $this->supportsStreaming;

        // Add common parameters
        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;
        if ($this->caption) $params['caption'] = $this->caption;
        if ($this->parseMode) $params['parse_mode'] = $this->parseMode;
        if ($this->captionEntities) $params['caption_entities'] = $this->captionEntities;
        if ($this->showCaptionAboveMedia) $params['show_caption_above_media'] = $this->showCaptionAboveMedia;
        if ($this->hasSpoiler) $params['has_spoiler'] = $this->hasSpoiler;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->allowPaidBroadcast) $params['allow_paid_broadcast'] = $this->allowPaidBroadcast;
        if ($this->messageEffectId) $params['message_effect_id'] = $this->messageEffectId;
        if ($this->replyParameters) $params['reply_parameters'] = $this->replyParameters;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('sendVideo', $params);
    }
}
