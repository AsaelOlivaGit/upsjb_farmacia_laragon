<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('settings.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:roles,name',
            'description' => 'nullable|max:255',
        ]);

        Role::create($validated);

        return to_route('roles.index')->with('ok', 'Rol registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('settings.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:50',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'description' => 'nullable|max:255',
        ]);

        $role->update($validated);

        return to_route('roles.index')->with('ok', 'Rol actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // users.rol_id tiene restrictOnDelete(): no se puede borrar un rol con usuarios
        if ($role->users()->exists()) {
            return to_route('roles.index')->with('error', 'No se puede eliminar: el rol tiene usuarios asociados');
        }

        $role->delete();

        return to_route('roles.index')->with('ok', 'Rol eliminado correctamente');
    }
}
