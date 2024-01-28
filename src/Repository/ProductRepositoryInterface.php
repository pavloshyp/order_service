<?php

namespace App\Repository;

use ProductManagement\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * Find a product by its ID.
     *
     * @param mixed $id The ID of the product.
     * @return Product|null The product if found, null otherwise.
     */
    public function find($id);

    /**
     * Find all products.
     *
     * @return Product[] An array of Product entities.
     */
    public function findAll();

    /**
     * Save a product entity.
     *
     * @param Product $product The product entity to save.
     */
    public function save(Product $product): void;
}
