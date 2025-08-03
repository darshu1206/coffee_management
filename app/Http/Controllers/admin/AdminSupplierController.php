<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminSupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $suppliers = Supplier::withCount('coffees')
            ->latest()
            ->paginate(10);
        
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load(['coffees']);
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    public function destroy(Supplier $supplier)
    {
        // Check if supplier has coffees
        if ($supplier->coffees()->count() > 0) {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Cannot delete supplier that has coffees assigned to it!');
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}