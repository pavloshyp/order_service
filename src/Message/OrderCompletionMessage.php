<?php

declare(strict_types=1);

namespace App\Message;

readonly class OrderCompletionMessage
{
    public function __construct(
        public int $orderId
    )
    {
    }
}