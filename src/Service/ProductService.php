<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ProductRepository;
use ProductManagement\Dto\ProductDto;
use ProductManagement\Entity\Product;

readonly class ProductService implements ProductServiceInterface
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {
    }

    /**
     * @inheritdoc
     */
    public function createOrUpdateProduct(ProductDto $productDto): void
    {
        $product = $this->productRepository->find($productDto->id);
        if ($product === null) {
            $product = new Product();
        }
        $product->setName($productDto->name);
        $product->setPrice($productDto->price);
        $product->setQuantity($productDto->quantity);
        $this->productRepository->save($product);
    }
}