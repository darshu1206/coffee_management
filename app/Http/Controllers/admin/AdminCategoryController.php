<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $categories = Category::withCount('coffees')
            ->latest()
            ->paginate(10);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // $imagePath = $request->file('image')->store('categories', 'public');
            // $data['image_url'] = $imagePath;

            $image = $request->file('image');

            // Generate filename like category_20250804_123456.jpg
            $imageName = 'category_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/category_images'), $imageName);
            $data['image_url'] = $imageName;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        $category->load(['coffees.supplier']);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image_url) {
                Storage::disk('public')->delete($category->image_url);
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image_url'] = $imagePath;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Check if category has coffees
        if ($category->coffees()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category that has coffees assigned to it!');
        }

        // Delete image file
        if ($category->image_url) {
            Storage::disk('public')->delete($category->image_url);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}