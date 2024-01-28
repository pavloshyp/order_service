<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Order;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateOrderDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $productId,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(max: Order::MAX_NAME_LENGTH)]
        public string $customerName,

        #[Assert\NotBlank]
        #[Assert\Type('int')]
        #[Assert\Positive]
        public int    $quantityOrdered,
    )
    {
    }
}