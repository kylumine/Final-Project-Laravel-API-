<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::orderBy('name')->get();
        
        return response()->json($customers);
    }

    public function view(Customer $customer) {
        $customer->load('sales');
        return response()->json($customer);
    }

    public function store(Request $request, Customer $customer) {
        $fields = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'balance' => 'required|integer',
        ]);

        $customer = Customer::create($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Customer with ID# ' .$customer->id . ' has been created'
        ]);
    }

    public function update(Request $request, Customer $customer) {
        $fields = $request->validate([
            'name' => 'string',
            'address' => 'string',
            'phone' => 'string',
            'balance' => 'integer',
        ]);

        $customer->update($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Customer with ID# ' .$customer->id . ' has been updated'
        ]);
    }

    public function destroy(Customer $customer){
        $details = $customer->company_name;
        $customer->delete();

        return response()->json([
            'status' => "OK",
            'message' => 'Customer with the name ' .$details . ' has been deleted'
        ]);
    }
}
