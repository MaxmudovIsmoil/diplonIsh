<?php

namespace App\Http\Controllers;


use App\Http\Requests\OrderFileRequest;
use App\Services\OrderFileService;


class OrderFileController extends Controller
{
    public function __construct(
        public OrderFileService $service
    )
    {}

    public function getFiles(int $orderId)
    {
        return $this->service->getFiles($orderId);
    }

    public function store(OrderFileRequest $request)
    {
        return $this->service->store($request->validated());
    }


    public function destroy(int $id)
    {
        return $this->service->destroy($id);
    }

}
