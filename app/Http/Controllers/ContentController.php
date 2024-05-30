<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPlanCreateRequest;
use App\Http\Requests\UserPlanUpdateRequest;
use App\Services\UserPlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function __construct(
        public UserPlanService $service
    )
    {}

    public function index(int $planId)
    {
        dd($planId);

        return view('user-plan.index',
            compact('userInstances')
        );
    }

    public function getInstances(int $userInstanceId): JsonResponse
    {
        try {
            return response()->success($this->service->instances($userInstanceId));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage(), $e->getCode());
        }
    }

    public function getOne(int $id): JsonResponse
    {
        try {
            return response()->success($this->service->getInstance($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage(), $e->getCode());
        }
    }

    public function store(UserPlanCreateRequest $request): JsonResponse
    {
        try {
            $result = $this->service->create($request->validated());
            return response()->success($result);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(UserPlanUpdateRequest $request, int $id)
    {
        try {
            $result = $this->service->update($request->validated(), $id);
            return response()->success($result);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return response()->fail($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $result = $this->service->delete($id);
            return response()->success($result);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return response()->fail($e->getMessage());
        }
    }
}
