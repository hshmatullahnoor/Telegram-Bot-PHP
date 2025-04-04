<?php

namespace Classes\Telegram\Methods;

use Classes\Telegram\Connection;

class GetUserProfilePhotos extends Connection
{
    private int $userId;
    private ?int $offset = null;
    private ?int $limit = null;

    public function userId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function limit(int $limit): self
    {
        if ($limit < 1 || $limit > 100) {
            throw new \InvalidArgumentException('Limit must be between 1 and 100');
        }
        $this->limit = $limit;
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

        if ($this->offset) $params['offset'] = $this->offset;
        if ($this->limit) $params['limit'] = $this->limit;

        return parent::Connect('getUserProfilePhotos', $params);
    }
}
