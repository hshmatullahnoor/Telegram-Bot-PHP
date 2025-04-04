<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class SendLocation extends Connection
{
    private int|string $chatId;
    private float $latitude;
    private float $longitude;
    private ?string $businessConnectionId = null;
    private ?int $messageThreadId = null;
    private ?float $horizontalAccuracy = null;
    private ?int $livePeriod = null;
    private ?int $heading = null;
    private ?int $proximityAlertRadius = null;
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

    public function latitude(float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function longitude(float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function horizontalAccuracy(float $accuracy): self
    {
        if ($accuracy < 0 || $accuracy > 1500) {
            throw new \InvalidArgumentException('Horizontal accuracy must be between 0 and 1500');
        }
        $this->horizontalAccuracy = $accuracy;
        return $this;
    }

    public function livePeriod(int $period): self
    {
        if ($period != 0x7FFFFFFF && ($period < 60 || $period > 86400)) {
            throw new \InvalidArgumentException('Live period must be between 60 and 86400, or 0x7FFFFFFF');
        }
        $this->livePeriod = $period;
        return $this;
    }

    public function heading(int $heading): self
    {
        if ($heading < 1 || $heading > 360) {
            throw new \InvalidArgumentException('Heading must be between 1 and 360');
        }
        $this->heading = $heading;
        return $this;
    }

    public function proximityAlertRadius(int $radius): self
    {
        if ($radius < 1 || $radius > 100000) {
            throw new \InvalidArgumentException('Proximity alert radius must be between 1 and 100000');
        }
        $this->proximityAlertRadius = $radius;
        return $this;
    }

    // ...common setter methods...

    public function send(): string
    {
        if (!isset($this->chatId) || !isset($this->latitude) || !isset($this->longitude)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'chat_id, latitude and longitude are required'
            ]);
        }

        $params = [
            'chat_id' => $this->chatId,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];

        if ($this->businessConnectionId) $params['business_connection_id'] = $this->businessConnectionId;
        if ($this->messageThreadId) $params['message_thread_id'] = $this->messageThreadId;
        if ($this->horizontalAccuracy) $params['horizontal_accuracy'] = $this->horizontalAccuracy;
        if ($this->livePeriod) $params['live_period'] = $this->livePeriod;
        if ($this->heading) $params['heading'] = $this->heading;
        if ($this->proximityAlertRadius) $params['proximity_alert_radius'] = $this->proximityAlertRadius;
        if ($this->disableNotification) $params['disable_notification'] = $this->disableNotification;
        if ($this->protectContent) $params['protect_content'] = $this->protectContent;
        if ($this->allowPaidBroadcast) $params['allow_paid_broadcast'] = $this->allowPaidBroadcast;
        if ($this->messageEffectId) $params['message_effect_id'] = $this->messageEffectId;
        if ($this->replyParameters) $params['reply_parameters'] = $this->replyParameters;
        if ($this->replyMarkup) $params['reply_markup'] = $this->replyMarkup;

        return parent::Connect('sendLocation', $params);
    }
}
