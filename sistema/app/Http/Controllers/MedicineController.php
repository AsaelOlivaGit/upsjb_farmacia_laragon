<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    // Unidades a partir de las cuales el stock se considera bajo
    const LOW_STOCK = 10;

    /**
     * Display a listing of the resource (con búsqueda y filtros).
     */
    public function index(Request $request)
    {
        $medicines = Medicine::with('category')                            // carga la categoría en 1 sola consulta (evita N+1)
            ->when($request->search, function ($query, $search) {          // solo si escribió algo en el buscador
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->category_id, function ($query, $categoryId) { // solo si eligió una categoría
                $query->where('category_id', $categoryId);
            })
            ->when($request->boolean('low_stock'), function ($query) {     // solo si marcó "stock bajo"
                $query->where('stock', '<=', self::LOW_STOCK);
            })
            ->orderBy('name')
            ->get();

        // Para llenar la lista desplegable del filtro
        $categories = Category::orderBy('name')->get();
        $lowStock = self::LOW_STOCK;

        return view('management.medicines.index', compact('medicines', 'categories', 'lowStock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('management.medicines.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:120',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // máx. 2 MB
        ]);

        // Si subió una imagen, se guarda en storage/app/public/medicines
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('medicines', 'public');
        }

        Medicine::create($validated);

        return to_route('medicines.index')->with('ok', 'Medicamento registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        $categories = Category::orderBy('name')->get();
        return view('management.medicines.edit', compact('medicine', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:120',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Borra la imagen anterior y guarda la nueva
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $validated['image'] = $request->file('image')->store('medicines', 'public');
        } else {
            // Si no subió imagen nueva, se mantiene la actual
            unset($validated['image']);
        }

        $medicine->update($validated);

        return to_route('medicines.index')->with('ok', 'Medicamento actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        // detail_sales.medicine_id tiene restrictOnDelete(): no se puede borrar un medicamento vendido
        if ($medicine->detailSales()->exists()) {
            return to_route('medicines.index')->with('error', 'No se puede eliminar: el medicamento tiene ventas registradas');
        }

        // Borra también su imagen
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        return to_route('medicines.index')->with('ok', 'Medicamento eliminado correctamente');
    }
}
