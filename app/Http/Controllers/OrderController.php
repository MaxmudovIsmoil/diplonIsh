<?php

namespace App\Http\Controllers;


use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        public OrderService $service
    ) {}


    public function index()
    {
        $user_plans = $this->service->getUserPlan();

        $userInstanceIds = $this->service->userInstanceIds();

        $orderAll = $this->service->getOrder();
        $orderAccepted = $this->service->getOrder(2);
        $orderGoBack = $this->service->getOrder(3);
        $orderCompleted = $this->service->getOrder(5);


        return view('order.index',
            compact(
                'user_plans',
                'orderAll',
                'orderAccepted',
                'orderGoBack',
                'orderCompleted',
                'userInstanceIds'
            )
        );
    }


    public function store(Request $request): JsonResponse
    {
        try {
            $result = $this->service->create($request);
            return response()->success($result);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function getOrderActionComments(int $orderId): JsonResponse
    {
        try {
            return response()->success($this->service->getOrderActionComments($orderId));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function getOrderPlan(int $orderId): JsonResponse
    {
        try {
            return response()->success($this->service->getOrderPlan($orderId));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }
}
