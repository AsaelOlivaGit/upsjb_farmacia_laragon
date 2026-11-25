<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('management.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('management.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:150',
            'dni' => 'required|digits:8|unique:customers',
            'phone' => 'required|digits:9',
            'age' => 'required|integer|min:0|max:120',
        ]);

        Customer::create($validated);

        return to_route('customers.index')->with('ok', 'Cliente registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('management.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|max:150',
            // ignore(): el DNI no se repite, sin contar el cliente que se está editando
            'dni' => ['required', 'digits:8', Rule::unique('customers')->ignore($customer->id)],
            'phone' => 'required|digits:9',
            'age' => 'required|integer|min:0|max:120',
        ]);

        $customer->update($validated);

        return to_route('customers.index')->with('ok', 'Cliente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // sales.customer_id tiene restrictOnDelete(): no se puede borrar un cliente con ventas
        if ($customer->sales()->exists()) {
            return to_route('customers.index')->with('error', 'No se puede eliminar: el cliente tiene ventas registradas');
        }

        $customer->delete();

        return to_route('customers.index')->with('ok', 'Cliente eliminado correctamente');
    }
}
