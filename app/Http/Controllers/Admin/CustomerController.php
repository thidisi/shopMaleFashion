<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    private object $model;

    public function __construct(Customer $customer)
    {
        $this->table = (new Customer)->getTable();
        $this->customer = $customer;
    }
    public function index()
    {
        return view('backend.customers.index', [
            'titles' => $this->table,
        ]);
    }

    public function api()
    {
        return DataTables::of($this->customer->query())
            ->addColumn('edit', function ($object) {
                return route('admin.customers.update', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('admin.customers.destroy', $object);
            })
            ->addColumn('checkLevel', function () {
                if (auth()->user()->level == 'admin' || auth()->user()->level == 'manager') {
                    return 'true';
                } else {
                    return 'false';
                }
            })
            ->make(true);
    }

    public function update($customerId)
    {
        try {
            $customer = $this->customer->findOrFail($customerId);
            if ($customer->status == 'active') {
                $customer->status = 'inactive';
            } else {
                $customer->status = 'active';
            }
            $customer->save();
            return response('Updated successfully!!', 200);
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function destroy($customerId)
    {
        try {
            $this->customer->destroy($customerId);
            $array = array();
            $arr['status'] = true;

            return response($arr, 200);
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }
}
