<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // with('role') trae los roles en una sola consulta (evita el problema N+1)
        $users = User::with('role')->latest()->get();
        return view('settings.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Opciones de la lista desplegable de roles
        $roles = Role::orderBy('name')->get();
        return view('settings.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rol_id' => 'required|exists:roles,id',
            'name' => 'required|max:255',
            'dni' => 'required|digits:8|unique:users',
            'phone' => 'nullable|max:15',
            'tuition' => 'nullable|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed', // confirmed: debe coincidir con password_confirmation
        ]);

        User::create($validated); // el cast 'hashed' del modelo encripta la contraseña al guardar

        return to_route('users.index')->with('ok', 'Usuario registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('settings.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'rol_id' => 'required|exists:roles,id',
            'name' => 'required|max:255',
            // ignore(): el DNI y el correo no se repiten, sin contar el usuario que se está editando
            'dni' => ['required', 'digits:8', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|max:15',
            'tuition' => 'nullable|max:20',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Si no escribió contraseña nueva, se mantiene la actual
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return to_route('users.index')->with('ok', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // sales.user_id tiene restrictOnDelete(): no se puede borrar un usuario con ventas
        if ($user->sales()->exists()) {
            return to_route('users.index')->with('error', 'No se puede eliminar: el usuario tiene ventas registradas');
        }

        $user->delete();

        return to_route('users.index')->with('ok', 'Usuario eliminado correctamente');
    }
}
