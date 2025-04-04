<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class SetUserEmojiStatus extends Connection
{
    private int $userId;
    private ?string $emojiStatusCustomEmojiId = null;
    private ?int $emojiStatusExpirationDate = null;

    public function userId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function emojiStatusCustomEmojiId(string $emojiId): self
    {
        $this->emojiStatusCustomEmojiId = $emojiId;
        return $this;
    }

    public function emojiStatusExpirationDate(int $date): self
    {
        $this->emojiStatusExpirationDate = $date;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->userId)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'user_id is required'
            ]);
        }

        $params = ['user_id' => $this->userId];

        if ($this->emojiStatusCustomEmojiId !== null) {
            $params['emoji_status_custom_emoji_id'] = $this->emojiStatusCustomEmojiId;
        }
        if ($this->emojiStatusExpirationDate) {
            $params['emoji_status_expiration_date'] = $this->emojiStatusExpirationDate;
        }

        return parent::Connect('setUserEmojiStatus', $params);
    }
}
