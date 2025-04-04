<?php

namespace App\Telegram\Methods\BotConfig;

use App\Telegram\Connection;

class SetMyCommands extends Connection
{
    private array $commands;
    private ?array $scope = null;
    private ?string $languageCode = null;

    public function commands(array $commands): self
    {
        if (count($commands) > 100) {
            throw new \InvalidArgumentException('Maximum 100 commands allowed');
        }
        $this->commands = $commands;
        return $this;
    }

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
        if (!isset($this->commands)) {
            return json_encode([
                'ok' => false,
                'error_code' => 400,
                'description' => 'commands are required'
            ]);
        }

        $params = ['commands' => $this->commands];
        if ($this->scope) $params['scope'] = $this->scope;
        if ($this->languageCode) $params['language_code'] = $this->languageCode;

        return parent::Connect('setMyCommands', $params);
    }
}
