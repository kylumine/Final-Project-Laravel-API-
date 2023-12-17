<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::orderBy('id')->get();
        
        return response()->json($users);
    }

    public function view(User $user) {
        
        $user->load('purchases' , 'sales');
        return response()->json($user);
    }

    public function store(Request $request, User $user) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        $user = User::create($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'User with ID# ' .$user->id . ' has been created'
        ]);
    }

    public function update(Request $request, User $user) {
        $fields = $request->validate([
            'name' => 'string',
            'email' => 'email',
        ]);

        $user->update($fields);

        return response()->json([
            'status' => "OK",
            'message' => 'User with ID# ' .$user->id . ' has been updated'
        ]);
    }

    public function destroy(User $user){
        $details = $user->company_name;
        $user->delete();

        return response()->json([
            'status' => "OK",
            'message' => 'User with the name ' .$details . ' has been deleted'
        ]);
    }
}
