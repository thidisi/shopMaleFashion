<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private object $model;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('backend.users.index');
    }

    public function api()
    {

        return DataTables::of($this->user->query())
            ->editColumn('birthday', function ($object) {
                return $object->age;
            })
            ->editColumn('gender', function ($object) {
                return $object->gender_name;
            })
            ->editColumn('level', function ($object) {
                return $object->role_name;
            })
            ->editColumn('status', function ($object) {
                return $object->status_name;
            })
            ->addColumn('edit', function ($object) {
                return route('admin.users.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('admin.users.destroy', $object);
            })
            ->make(true);
    }

    public function edit(User $user)
    {
        $roles = UserRoleEnum::getKeys();
        return view('backend.users.edit', [
            'each' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->user->findOrFail($id);
            $fullname = $request->input('fullname');
            $address = $request->input('address');
            $phone = $request->input('phone');
            $birthday = $request->input('birthday');
            $birthday = date('Y-m-d', strtotime($birthday));
            $gender = $request->input('gender');
            $gender = $gender === '0' || $gender === '1' ? $gender : '0';
            $roles = $request->input('level');
            $status = $request->input('status') ? '1' : '2';

            $nameAvatar = null;
            if ($request->hasFile('photo_new')) {
                if ($request->file('photo_new')->isValid()) {
                    $nameAvatar = $request->file('photo_new')->hashName();
                    $path = $request->file('photo_new')->store(PATH_UPLOAD_AVATAR);
                }
            }
            if ($nameAvatar == '') {
                $nameAvatar = $request->input('photo_old');
            }

            $user->fullname = $fullname;
            $user->address = $address;
            $user->phone = $phone;
            $user->birthday = $birthday;
            $user->gender = $gender;
            $user->level = $roles;
            $user->status = $status;
            $user->avatar = $nameAvatar;
            if (is_numeric($id) && $id > 0) {
                $user->update();
                return redirect()->route("admin.users")->with('statusEdit', 'User Updated Successfully');
            } else {
                if (Storage::exists(PATH_UPLOAD_AVATAR . '/' . $nameAvatar)) {
                    Storage::delete(PATH_UPLOAD_AVATAR . '/' . $nameAvatar);
                }
                return redirect()->route('admin.users')->with('statusEdit', 'Edit Failed User table');
            }
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function destroy($userId)
    {
        try {
            $this->user->destroy($userId);
            $array = array();
            $arr['status'] = true;

            return response($arr, 200);
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }
}
