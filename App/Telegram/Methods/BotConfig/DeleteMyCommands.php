<?php

namespace App\Telegram\Methods\BotConfig;

use App\Telegram\Connection;

class DeleteMyCommands extends Connection
{
    private ?array $scope = null;
    private ?string $languageCode = null;

    public function scope(array $scope): self
    {
        $this->scope = $scope;
        return $this;
    }

    public function languageCode(string $languageCode): self
    {
        $this->languageCode = $languageCode;
        return $this;
    }

    public function send(): string
    {
        $params = [];
        if ($this->scope) $params['scope'] = $this->scope;
        if ($this->languageCode) $params['language_code'] = $this->languageCode;

        return parent::Connect('deleteMyCommands', $params);
    }
}
