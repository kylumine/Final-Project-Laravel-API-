<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index() {
        $suppliers = Supplier::orderBy('company_name')->get();
        
        return response()->json($suppliers);
    }

    public function view(Supplier $supplier) {
        
        $supplier->load('purchases');

        return response()->json($supplier);
    }

    public function store(Request $request, Supplier $supplier) {
        $fields = $request->validate([
            'company_name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'contact_person' => 'required|string'
        ]);

        $supplier = Supplier::create($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Supplier with ID# ' .$supplier->id . ' has been created'
        ]);
    }

    public function update(Request $request, Supplier $supplier) {
        $fields = $request->validate([
            'company_name' => 'string',
            'address' => 'string',
            'phone' => 'string',
            'contact_person' => 'string'
        ]);

        $supplier->update($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'Supplier with ID# ' .$supplier->id . ' has been updated'
        ]);
    }

    public function destroy(Supplier $supplier){
        $details = $supplier->company_name;
        $supplier->delete();

        return response()->json([
            'status' => "OK",
            'message' => 'Supplier with the name ' .$details . ' has been deleted'
        ]);
    }

}
