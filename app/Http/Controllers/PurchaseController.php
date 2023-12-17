<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index() {
        $purchases = Purchase::orderBy('id')->get();
        
        return response()->json($purchases);
    }

    public function view(Purchase $purchase) {
        
        $purchase->load('supplier','user','purchased_items');

        return response()->json($purchase);
    }

    public function store(Request $request, Purchase $purchase) {
        $fields = $request->validate([
            'date' => 'required|date',
            'total' => 'required|integer',
            'invoice_no' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $purchase = Purchase::create($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Merchandise with ID# ' .$purchase->id . ' has been created'
        ]);
    }

    public function update(Request $request, Purchase $purchase) {
        $fields = $request->validate([
            'date' => 'date',
            'total' => 'integer',
            'invoice_no' => 'string',
            'supplier_id' => 'exists:suppliers,id',
            'user_id' => 'exists:users,id',
        ]);

        $purchase->update($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Purchase with ID# ' .$purchase->id . ' has been updated'
        ]);
    }

    public function destroy(Purchase $purchase){
        $details = $purchase->company_name;
        $purchase->delete();

        return response()->json([
            'status' => "OK",
            'message' => 'Purchase with the name ' .$details . ' has been deleted'
        ]);
    }
}
