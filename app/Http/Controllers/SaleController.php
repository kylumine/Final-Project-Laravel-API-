<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index() {
        $sales = Sale::orderBy('id')->get();
        
        return response()->json($sales);
    }

    public function view(Sale $sale) {
        $sale->load('customer', 'sold_items', 'user');
        return response()->json($sale);
    }

    public function store(Request $request, Sale $sale) {
        $fields = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'is_credit' => 'required|boolean',
        ]);

        $sale = Sale::create($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Sale item with ID# ' .$sale->id . ' has been created'
        ]);
    }

    public function update(Request $request, Sale $sale) {
        $fields = $request->validate([
            'customer_id' => 'exists:customers,id',
            'user_id' => 'exists:users,id',
            'date' => 'date',
            'is_credit' => 'boolean',
        ]);

        $sale->update($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Sale item with ID# ' .$sale->id . ' has been updated'
        ]);
    }

    public function destroy(Sale $sale){
        $details = $sale->company_name;
        $sale->delete();

        return response()->json([
            'status' => "OK",
            'message' => 'Sale item with the name ' .$details . ' has been deleted'
        ]);
    }
}
