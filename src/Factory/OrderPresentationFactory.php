<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\OrderDto;
use App\Entity\Order;
use ProductManagement\Dto\ProductDto;
use ProductManagement\Exception\ProductNotFoundException;

class OrderPresentationFactory
{
    /**
     * @throws ProductNotFoundException
     */
    public function createOrderPresentation(Order $order): OrderDto
    {
        $product = $order->getProduct();
        if($product === null) {
            throw new ProductNotFoundException();
        }
        return new OrderDto(
            $order->getId(),
            $order->getCustomerName(),
            $order->getQuantity(),
            $order->getStatus(),
            new ProductDto(
                $product->getId(),
                $product->getName(),
                $product->getPrice(),
                $product->getQuantity(),
            ),
        );
    }
}
