<?php

namespace App\Services\Admin;

use App\Models\Plan;
use Yajra\DataTables\DataTables;

class PlanService
{
    public function list()
    {
        $plan = Plan::orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return DataTables::of($plan)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($plan) {
                return ($plan['status'] == 1) ? 'Faol' : 'faol emas';
            })
            ->addColumn('content', function($plan) {
                return '<a href="'.route('admin.content.index', $plan['id']).'" class="btn btn-primary"></a>';
            })
            ->addColumn('action', function ($plan) {
                $btn = '<div class="text-right">
                            <a href="javascript:void(0);" class="text-primary js_edit_btn mr-3"
                                data-update_url="'.route('admin.plan.update', $plan['id']).'"
                                data-one_data_url="'.route('admin.plan.getOne', $plan['id']).'"
                                title="Tahrirlash">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-name="'.$plan['name'].'"
                                data-url="'.route('admin.plan.destroy', $plan['id']).'" title="O\'chitish">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>
                        </div>';
                return $btn;
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id)
    {
        return Plan::findOrFail($id);
    }

    public function create(array $data): bool
    {
        Plan::create([
            'name' => $data['name'],
            'text' => '',
            'status' => $data['status'],
        ]);

        return true;
    }

    public function update(array $data, int $id): int
    {
        $user = Plan::findOrfail($id);
        $user->fill([
            'name' => $data['name'],
            'status' => $data['status'],
        ]);
        $user->save();
        return $id;
    }

    public function delete(int $id)
    {
        return Plan::destroy($id);
    }


}
