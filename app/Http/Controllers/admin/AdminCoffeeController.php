<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coffee;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCoffeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $coffees = Coffee::with(['category', 'supplier'])
            ->latest()
            ->paginate(10);
        
        return view('admin.coffees.index', compact('coffees'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        
        return view('admin.coffees.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'roast_level' => 'required|in:light,medium,dark',
            'origin' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('coffees', 'public');
            $data['image_url'] = $imagePath;
        }

        Coffee::create($data);

        return redirect()->route('admin.coffees.index')
            ->with('success', 'Coffee created successfully!');
    }

    public function show(Coffee $coffee)
    {
        $coffee->load(['category', 'supplier']);
        return view('admin.coffees.show', compact('coffee'));
    }

    public function edit(Coffee $coffee)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        
        return view('admin.coffees.edit', compact('coffee', 'categories', 'suppliers'));
    }

    public function update(Request $request, Coffee $coffee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'roast_level' => 'required|in:light,medium,dark',
            'origin' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($coffee->image_url) {
                Storage::disk('public')->delete($coffee->image_url);
            }
            
            $imagePath = $request->file('image')->store('coffees', 'public');
            $data['image_url'] = $imagePath;
        }

        $coffee->update($data);

        return redirect()->route('admin.coffees.index')
            ->with('success', 'Coffee updated successfully!');
    }

    public function destroy(Coffee $coffee)
    {
        // Delete image file
        if ($coffee->image_url) {
            Storage::disk('public')->delete($coffee->image_url);
        }

        $coffee->delete();

        return redirect()->route('admin.coffees.index')
            ->with('success', 'Coffee deleted successfully!');
    }
}