<?php

namespace App\Http\Controllers;

use App\Models\Purchased_Item;
use Illuminate\Http\Request;

class PurchasedItemController extends Controller
{
    public function index() {
        $purchased_item = Purchased_Item::orderBy('id')->get();
        
        return response()->json($purchased_item);
    }

    public function view(Purchased_Item $purchased_item) {
        
        $purchased_item->load('purchase','merchandise');

        return response()->json($purchased_item);
    }

    public function store(Request $request, Purchased_Item $purchased_item) {
        $fields = $request->validate([
            'merchandise_id' => 'required|exists:merchandises,id',
            'purchase_id' => 'required|exists:purchases,id',
            'whole_sale_qty' => 'required|integer',
            'purchase_price' => 'required|integer',
        ]);

        $purchased_item = Purchased_Item::create($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Purchased item with ID# ' .$purchased_item->id . ' has been created'
        ]);
    }

    public function update(Request $request, Purchased_Item $purchased_item) {
        $fields = $request->validate([
            'merchandise_id' => 'exists:merchandises,id',
            'purchase_id' => 'exists:purchases,id',
            'whole_sale_qty' => 'integer',
            'purchase_price' => 'integer',
        ]);

        $purchased_item->update($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Purchased item with ID# ' .$purchased_item->id . ' has been updated'
        ]);
    }

    public function destroy(Purchased_Item $purchased_item){
        $details = $purchased_item->company_name;
        $purchased_item->delete();

        return response()->json([
            'status' => "OK",
            'message' => 'Purchased item with the name ' .$details . ' has been deleted'
        ]);
    }
}
