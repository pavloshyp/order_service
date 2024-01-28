<?php

namespace App\Exception;

use Exception;

class ProductNotAvailableException extends Exception
{
    public function __construct(string $message = 'Product not available')
    {
        parent::__construct($message);
    }
}