<?php

namespace App\Enum;

enum OrderStatus: string
{
    case PROCESSING = 'Processing';
    case COMPLETED = 'Completed';
}
