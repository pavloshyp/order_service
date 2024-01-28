<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CreateOrderDto;
use ProductManagement\Exception\ProductNotFoundException;
use App\Exception\OrderNotFoundException;
use App\Exception\ProductNotAvailableException;
use App\Service\OrderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route(path: '/api/v1')]
class OrderApiController extends AbstractController
{
    #[Route('/orders', name: 'api_order_create_v1', methods: ['POST'])]
    public function v1Create(#[MapRequestPayload] CreateOrderDto $createOrderDto, OrderServiceInterface $orderService): JsonResponse
    {
        try {
            $order = $orderService->createOrder($createOrderDto);
        } catch (ProductNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }  catch (ProductNotAvailableException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse(['data' => $order], Response::HTTP_CREATED);
    }

    #[Route('/orders', name: 'api_order_list_v1')]
    public function v1List(OrderServiceInterface $orderService): JsonResponse
    {
        $orders = $orderService->getOrders();

        return new JsonResponse(['data' => $orders]);
    }

    #[Route('/orders/{id}', name: 'api_order_get_v1', requirements: ['id' => '\d+'])]
    public function v1Get(int $id, OrderServiceInterface $orderService): JsonResponse
    {
        try {
            $order = $orderService->getOrder($id);
        } catch (OrderNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $order]);
    }
}
