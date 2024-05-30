<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest;
use App\Services\OrderActionService;
use Illuminate\Http\JsonResponse;

class OrderActionController extends Controller
{
    public function __construct(
        public OrderActionService $service
    )
    {}


    public function action(ActionRequest $request): JsonResponse
    {
        try {
            $action = $this->service->action($request->validated());
            return response()->success($action);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function getOrderAction(int $orderId): JsonResponse
    {
        try {
            return response()->success($this->service->getOrderAction($orderId));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }
}
