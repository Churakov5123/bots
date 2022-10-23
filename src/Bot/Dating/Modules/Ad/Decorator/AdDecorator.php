<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Ad\Decorator;

class AdDecorator
{
    private string $message;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getAdForFeed(): array
    {
        return [
            'msg' => $this->message,
        ];
    }
}
