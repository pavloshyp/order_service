<?php

namespace App\Service;

use ProductManagement\Dto\ProductDto;

interface ProductServiceInterface
{
    /**
     * Creates a new product or updates an existing one based on the provided Product DTO.
     *
     * @param ProductDto $productDto The data transfer object containing product data.
     */
    public function createOrUpdateProduct(ProductDto $productDto): void;
}
