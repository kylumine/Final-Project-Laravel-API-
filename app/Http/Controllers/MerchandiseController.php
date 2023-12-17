<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function index() {
        $merchandises = Merchandise::orderBy('brand')->get();
        
        return response()->json($merchandises);
    }

    
    public function view(Merchandise $merchandise) {
        
        $merchandise->load('sold_items', 'purchased_items');

        return response()->json($merchandise);
    }

    public function store(Request $request, Merchandise $merchandise) {
        $fields = $request->validate([
            'brand' => 'required|string',
            'description' => 'required|string',
            'retail_price' => 'required|integer',
            'whole_sale_price' => 'required|integer',
            'whole_sale_qty' => 'required|integer',
            'qty_stock' => 'required|integer',
        ]);

        $customer = Merchandise::create($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Merchandise with ID# ' .$customer->id . ' has been created'
        ]);
    }

    public function update(Request $request, Merchandise $merchandise) {
        $fields = $request->validate([
            'brand' => 'string',
            'description' => 'string',
            'retail_price' => 'integer',
            'whole_sale_price' => 'integer',
            'whole_sale_qty' => 'integer',
            'qty_stock' => 'integer',
        ]);

        $merchandise->update($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Merchandise with ID# ' .$merchandise->id . ' has been updated'
        ]);
    }

    public function destroy(Merchandise $merchandise){
        $details = $merchandise->company_name;
        $merchandise->delete();

        return response()->json([
            'status' => "OK",
            'message' => 'Merchandise with the name ' .$details . ' has been deleted'
        ]);
    }
}
