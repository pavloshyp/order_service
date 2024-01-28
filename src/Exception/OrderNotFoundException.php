<?php

namespace App\Exception;

use Exception;

class OrderNotFoundException extends Exception
{
    public function __construct(string $message = 'Order not found', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}