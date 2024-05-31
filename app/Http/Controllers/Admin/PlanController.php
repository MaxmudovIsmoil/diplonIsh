<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Services\Admin\PlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{

    public function __construct(
        public PlanService $service
    ) {}

    public function index(int $courseId)
    {
        $plans = Plan::where('course_id', $courseId)
            ->get()
            ->toArray();

        return view('admin.plan.index', compact('plans', 'courseId'));
    }

    public function getPlans()
    {
        return $this->service->list();
    }

    public function getOne(int $id): JsonResponse
    {
        try {
            return response()->success($this->service->one($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(PlanRequest $request): JsonResponse
    {
        try {
            $result = $this->service->create($request->validated());
            return response()->success($result);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return response()->fail($e->getMessage());
        }
    }

    public function update(PlanRequest $request, int $id): JsonResponse
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
            return response()->fail($e->getMessage());
        }
    }

}
