<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:serveur,caissier',
            'is_active' => 'boolean'
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour');
    }

    public function create()
    {
        // Tu peux passer la liste des rôles si besoin
        $roles = ['admin', 'caissier', 'serveur'];
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,caissier,serveur'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Si vous utilisez Spatie Laravel Permissions
        // $user->assignRole($request->role);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé');
    }
}