<?php

namespace App\Services\Admin;

use App\Helpers\Helper;
use App\Models\User;
use App\Models\UserInstance;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserService
{
    use FileTrait;

    public function list()
    {
        $users = User::where(['rule' => 2])
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('phone', function($users) {
                return Helper::phoneFormat($users->phone);
            })
            ->editColumn('status', function($users) {
                return ($users->status == 1) ? trans('Admin.Active') : trans('Admin.No active');
            })
            ->addColumn('photo', function($users) {
                return '<div class="avatar avatar-xl">
                            <img src="'.$users->photo.'" alt="Photo"/>
                        </div>';
            })
            ->addColumn('action', function ($users) {
                $btn = '<div class="text-right">
                            <a href="javascript:void(0);" class="text-primary js_edit_btn mr-3"
                                data-update_url="'.route('admin.user.update', $users->id).'"
                                data-one_data_url="'.route('admin.user.getOne', $users->id).'"
                                title="Tahrirlash">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-name="'.$users->name.'"
                                data-url="'.route('admin.user.destroy', $users->id).'" title="O\'chitish">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>
                        </div>';
                return $btn;
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['photo', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
            $photo = $this->fileUpload($data['photo']);

            $userId = User::insertGetId([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'photo' => $photo,
                'username' => strtolower($data['username']),
                'password' => Hash::make($data['password']),
                'rule' => 2,
            ]);

        DB::commit();
        return $userId;
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
            $user = User::findOrfail($id);
            if (isset($data['photo'])) {
                $this->fileDelete('photo/'.$user->photo);
                $user->fill(['photo' => $this->fileUpload($data['photo'])]);
            }
            if (isset($data['password'])) {
                $user->fill(['password' => Hash::make($data['password'])]);
            }
            $user->fill([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'status' => $data['status'],
                'username' => strtolower($data['username'])
            ]);
            $user->save();

        DB::commit();
        return $id;
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        $this->fileDelete('photo/' . $user->photo);
        return $user->delete();
    }


}
