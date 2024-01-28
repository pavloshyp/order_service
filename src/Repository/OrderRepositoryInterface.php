<?php

namespace App\Repository;

use App\Entity\Order;

interface OrderRepositoryInterface
{
    /**
     * Finds an Order by its ID.
     *
     * @param mixed $id The ID of the Order.
     * @return Order|null The found Order or null if not found.
     */
    public function find($id);

    /**
     * Finds all Orders.
     *
     * @return Order[] An array of Orders.
     */
    public function findAll();

    /**
     * Saves an Order, either by persisting a new one or updating an existing one.
     *
     * @param Order $order The Order entity to save.
     */
    public function save(Order $order): void;
}
