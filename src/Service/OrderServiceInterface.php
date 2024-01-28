<?php

namespace App\Service;

use App\Dto\CreateOrderDto;
use App\Dto\OrderDto;
use App\Enum\OrderStatus;
use ProductManagement\Exception\ProductNotFoundException;
use App\Exception\OrderNotFoundException;
use App\Exception\ProductNotAvailableException;

interface OrderServiceInterface
{
    /**
     * Create a new order based on the provided order data.
     *
     * @param CreateOrderDto $orderData Data necessary to create the order.
     * @return OrderDto The data transfer object for the created order.
     */
    public function createOrder(CreateOrderDto $orderData): OrderDto;

    /**
     * Retrieve all orders.
     *
     * @return OrderDto[] An array of order DTOs.
     */
    public function getOrders(): array;

    /**
     * Retrieve a single order by its ID.
     *
     * @param int $id The ID of the order to retrieve.
     * @return OrderDto The data transfer object for the retrieved order.
     */
    public function getOrder(int $id): OrderDto;

    /**
     * Update the status of an order.
     *
     * @param int $id The ID of the order to update.
     * @param OrderStatus $status The new status for the order.
     */
    public function updateOrderStatus(int $id, OrderStatus $status): void;
}
