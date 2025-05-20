<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }
    public function destroy(User $user)
    {
        if($user->is_admin){
            return back()->with('error', 'Nie można usunąć administratora!');
        }
        $user->delete();
        return back()->with('success', 'Użytkownik usunięty.');
    }


    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email|unique:users,email,'.$user->id,
            'is_admin'   => 'required|boolean',
        ]);
        $user->update($validated);
        return redirect()->route('admin.users')->with('success', 'Użytkownik zaktualizowany.');
    }
}