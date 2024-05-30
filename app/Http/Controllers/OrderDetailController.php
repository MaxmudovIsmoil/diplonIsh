<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailRequest;
use App\Services\OrderDetailService;
use Illuminate\Http\JsonResponse;


class OrderDetailController extends Controller
{
    public function __construct(
        public OrderDetailService $service
    )
    {}

    public function getOne(int $orderId): JsonResponse
    {
        try {
            return response()->success($this->service->getOne($orderId));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(OrderDetailRequest $request): JsonResponse
    {
        try {
            return response()->success($this->service->store($request->validated()));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function update(int $orderDetailId, OrderDetailRequest $request): JsonResponse
    {
        try {
            return response()->success($this->service->update($orderDetailId, $request->validated()));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function destroy(int $id): JsonResponse
    {
        try {
            return response()->success($this->service->destroy($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
