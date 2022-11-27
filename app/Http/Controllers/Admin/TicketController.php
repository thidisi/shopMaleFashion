<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    /**
     * Construct
     * @param Customer $customer
     * @param Ticket $ticket
     */

    public function __construct(Customer $customer, Ticket $ticket)
    {
        $this->customer = $customer;
        $this->ticket = $ticket;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('backend.tickets.index');
    }

    public function get_data(): JsonResponse
    {
        try {
            $customers = $this->customer->where('status', ACTIVE)->get(['id', 'name'])->toArray();
            // $total_customer = $this->customer->where('status', ACTIVE)->count();
            $total_customer = 100;
            $data = [
                'customers' => $customers,
                'total_customer' => $total_customer
            ];
            return response()->json([
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => __("messages.not_content")], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTicketRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            $data = $request->all();
            if (is_array($data['data'])) {
                $data['quantity'] = count($data['data']);
                foreach ($data['data'] as $each) {
                    $data['data_customer'][] = json_encode($this->customer->select(['id', 'name', 'email'])->findOrFail($each));
                }
            } else {
                $data['quantity'] = $data['data'];
                $getData = $this->customer->where('status', ACTIVE)->inRandomOrder()->limit($data['quantity'])->get(['id', 'name', 'email']);
                foreach ($getData as $each) {
                    $data['data_customer'][] = json_encode($each);
                }
            }
            unset($data['_token'], $data['customRadio'], $data['data']);
            if (is_array($data['data_customer'])) {
                $data['code'] .= mt_rand(999, 99999);
                $data['date_end'] = date_format(date_create_from_format('j-M-Y', $data['date_end']), 'Y-m-d');
                $this->ticket->create($data);
            }
            return redirect()->back()->with('addTicketStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return response()->json(['message' => __("messages.not_content")], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        //
    }
}
