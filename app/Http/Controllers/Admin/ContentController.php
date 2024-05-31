<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentRequest;
use App\Models\Content;
use App\Services\Admin\ContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{

    public function __construct(
        public ContentService $service
    ) {}

    public function index(int $planId)
    {
        $contents = Content::where('plan_id', $planId)
            ->get()
            ->toArray();

        return view('admin.content.index', compact('contents', 'planId'));
    }

    public function getOne(int $id)
    {
        return response()->success($this->service->one($id));
    }

    public function store(ContentRequest $request): JsonResponse
    {
        try {
            $result = $this->service->create($request->validated());
            return response()->success($result);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(ContentRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->service->update($request->validated(), $id);
            return response()->success($result);
        }
        catch(\Exception $e) {
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
