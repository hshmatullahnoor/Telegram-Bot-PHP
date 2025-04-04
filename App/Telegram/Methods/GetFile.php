<?php

namespace App\Telegram\Methods;

use App\Telegram\Connection;

class GetFile extends Connection
{
    private string $fileId;

    public function fileId(string $fileId): self
    {
        $this->fileId = $fileId;
        return $this;
    }

    public function send(): string
    {
        if (!isset($this->fileId)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'file_id is required'
            ]);
        }

        return parent::Connect('getFile', ['file_id' => $this->fileId]);
    }
}
