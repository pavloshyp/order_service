<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\ProductServiceInterface;
use ProductManagement\Message\ProductMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ProductMessageHandler
{
    public function __construct(
        private ProductServiceInterface $productService
    )
    {
    }

    /**
     * Handles product messages to create or update product information.
     *
     * @param ProductMessage $message The product message containing the product DTO.
     */
    public function __invoke(ProductMessage $message): void
    {
        $this->productService->createOrUpdateProduct($message->productDto);
    }
}
