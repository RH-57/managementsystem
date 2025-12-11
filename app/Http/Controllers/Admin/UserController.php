<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:50',
            'email'     => 'required|string|email|max:100|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'status'      => 'required|in:admin,superadmin',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:50',
            'email'     => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'required|in:admin,superadmin',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Pastikan ada user login (seharusnya sudah dijaga middleware)
        if (! Auth::check()) {
            return redirect()->route('users.index')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Cegah user menghapus dirinya sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun yang sedang digunakan.');
        }

        // (Opsional) Cegah admin biasa menghapus superadmin
        if ($user->role === 'superadmin' && Auth::user()->role !== 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Hanya superadmin yang dapat menghapus superadmin.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
