<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CreateOrderDto;
use App\Entity\Order;
use App\Enum\OrderStatus;
use App\Message\OrderCompletionMessage;
use ProductManagement\Exception\ProductNotFoundException;
use App\Exception\OrderNotFoundException;
use App\Exception\ProductNotAvailableException;
use App\Factory\OrderPresentationFactory;
use App\Repository\OrderRepositoryInterface;
use App\Dto\OrderDto;
use App\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class OrderService implements OrderServiceInterface
{
    public function __construct(
        private OrderRepositoryInterface          $orderRepository,
        private ProductRepositoryInterface        $productRepository,
        private MessageBusInterface      $messageBus,
        private OrderPresentationFactory $orderPresentationFactory,
    )
    {
    }

    /**
     * @inheritdoc
     * @throws ProductNotFoundException If the product is not found.
     * @throws ProductNotAvailableException If the product is not available in the requested quantity.
     */
    public function createOrder(CreateOrderDto $orderData): OrderDto
    {
        $product = $this->productRepository->find($orderData->productId);

        if (!$product) {
            throw new ProductNotFoundException(sprintf('Product with id %s not found', $orderData->productId));
        }
        if ($product->getQuantity() < $orderData->quantityOrdered) {
            throw new ProductNotAvailableException(sprintf('Product with id %s not available in quantity %s', $orderData->productId, $orderData->quantityOrdered));
        }
        $order = new Order();
        $order->setCustomerName($orderData->customerName);
        $order->setQuantity($orderData->quantityOrdered);
        $order->setStatus(OrderStatus::PROCESSING);
        $order->setProduct($product);
        $this->orderRepository->save($order);

        $this->messageBus->dispatch(new OrderCompletionMessage($order->getId()));

        return $this->orderPresentationFactory->createOrderPresentation($order);
    }

    /**
     * @inheritdoc
     * @throws ProductNotFoundException If a product related to any order is not found.
     */
    public function getOrders(): array
    {
        $orders = $this->orderRepository->findAll();
        $ordersPresentation = [];
        foreach ($orders as $order) {
            $ordersPresentation[] = $this->orderPresentationFactory->createOrderPresentation($order);
        }

        return $ordersPresentation;
    }

    /**
     * @inheritdoc
     * @throws OrderNotFoundException If the order is not found.
     * @throws ProductNotFoundException If the product related to the order is not found.
     */
    public function getOrder(int $id): OrderDto
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            throw new OrderNotFoundException(sprintf('Order with id %s not found', $id));
        }

        return $this->orderPresentationFactory->createOrderPresentation($order);
    }

    /**
     * @inheritdoc
     * @throws OrderNotFoundException If the order is not found.
     */
    public function updateOrderStatus(int $id, OrderStatus $status): void
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            throw new OrderNotFoundException(sprintf('Order with id %s not found', $id));
        }
        $order->setStatus($status);
        $this->orderRepository->save($order);
    }
}