<?php

declare(strict_types=1);

namespace App\Dto;

use ProductManagement\Dto\ProductDto;
use App\Enum\OrderStatus;

readonly class OrderDto
{
    public function __construct(
        public int         $orderId,
        public string      $customerName,
        public int         $quantityOrdered,
        public OrderStatus $orderStatus,
        public ProductDto  $product,
    )
    {
    }
}