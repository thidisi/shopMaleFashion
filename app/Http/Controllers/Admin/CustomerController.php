<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = Customer::query();
        $this->table = (new Customer)->getTable();
    }

    public function index()
    {
        return view('backend.customers.index', [
            'titles' => $this->table,
        ]);
    }

    public function api()
    {
        return DataTables::of($this->model)
            ->editColumn('status', function ($object) {
                return $object->status_name;
            })
            ->addColumn('edit', function ($object) {
                return route('admin.customers.update', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('admin.customers.destroy', $object);
            })
            ->addColumn('checkLevel', function () {
                if (session('sessionUserRole') == 'admin' || session('sessionUserRole') == 'manager') {
                    return 'true';
                } else {
                    return 'false';
                }
            })
            ->make(true);
    }

    public function update($customerId)
    {
        $customer = $this->model->find($customerId);
        if ($customer->status == ACTIVE) {
            $customer->status = NOT_ACTIVE;
        } else {
            $customer->status = ACTIVE;
        }
        $customer->save();
        return response('Updated successfully!!', 200);
    }

    public function destroy($customerId)
    {
        Customer::destroy($customerId);
        $array = array();
        $arr['status'] = true;

        return response($arr, 200);
    }
}
