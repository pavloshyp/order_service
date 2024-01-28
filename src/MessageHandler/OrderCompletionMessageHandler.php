<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Enum\OrderStatus;
use App\Exception\OrderNotFoundException;
use App\Message\OrderCompletionMessage;
use App\Service\OrderServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class OrderCompletionMessageHandler
{
    public function __construct(
        private OrderServiceInterface $orderService,
        private LoggerInterface       $logger
    )
    {
    }

    public function __invoke(OrderCompletionMessage $orderCompletionMessage): void
    {
        try {
            $this->orderService->updateOrderStatus($orderCompletionMessage->orderId, OrderStatus::COMPLETED);
        } catch (OrderNotFoundException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
