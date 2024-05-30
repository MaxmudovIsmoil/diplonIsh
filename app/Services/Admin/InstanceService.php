<?php

namespace App\Services\Admin;

use App\Models\Instance;
use Yajra\DataTables\DataTables;

class InstanceService
{
    public function list()
    {
        $instances = Instance::orderBy('id', 'DESC')->get();

        return DataTables::of($instances)
            ->addIndexColumn()
            ->addColumn('action', function ($instances) {
                $btn = '<div class="text-right">
                            <a href="javascript:void(0);" class="text-primary js_edit_btn mr-3"
                                data-update_url="'.route('admin.plan.update', $instances->id).'"
                                data-one_data_url="'.route('admin.plan.getOne', $instances->id).'"
                                title="Tahrirlash">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-name="'.$instances->name_uz.'"
                                data-url="'.route('admin.plan.destroy', $instances->id).'" title="O\'chirish">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>
                        </div>';
                return $btn;
            })
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($instances) {
                return ($instances->status == 1) ? trans('Admin.Active') : trans('Admin.No active');
            })
            ->setRowClass('js_this_tr')
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id)
    {
        return Instance::findOrFail($id);
    }

    public function create(array $data)
    {
        return Instance::create([
            'name_uz' => $data['name_uz'],
            'status' => $data['status']
        ]);
    }

    public function update(array $data, int $id)
    {
        return Instance::where(['id'=> $id])
            ->update([
                'name_uz' => $data['name_uz'],
                'status' => $data['status']
            ]);
    }

    public function delete(int $id)
    {
        Instance::destroy($id);
        return $id;
    }

}

