<?php

namespace App\Services\Admin;

use App\Models\Course;
use App\Traits\FileTrait;
use Yajra\DataTables\DataTables;

class CourseService
{

    public function list()
    {
        $course = Course::orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return DataTables::of($course)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($course) {
                return ($course['status'] == 1) ? 'Faol' : 'faol emas';
            })
            ->addColumn('plan', function($course) {
                return '<a href="'.route('admin.plan.index', $course['id']).'" class="btn btn-outline-primary">Reja</a>';
            })
            ->addColumn('action', function ($course) {
                $btn = '<div class="text-right">
                            <a href="javascript:void(0);" class="text-primary js_edit_btn mr-3"
                                data-update_url="'.route('admin.course.update', $course['id']).'"
                                data-one_data_url="'.route('admin.course.getOne', $course['id']).'"
                                title="Tahrirlash">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-name="'.$course['name'].'"
                                data-url="'.route('admin.course.destroy', $course['id']).'" title="O\'chitish">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>
                        </div>';
                return $btn;
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['plan', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id)
    {
        return Course::findOrFail($id);
    }

    public function create(array $data): bool
    {
        Course::create([
            'name' => $data['name'],
            'text' => '',
            'status' => $data['status'],
        ]);

        return true;
    }

    public function update(array $data, int $id): int
    {
        $user = Course::findOrfail($id);
        $user->fill([
            'name' => $data['name'],
            'status' => $data['status'],
        ]);
        $user->save();
        return $id;
    }

    public function delete(int $id)
    {
        return Course::destroy($id);
    }


}
