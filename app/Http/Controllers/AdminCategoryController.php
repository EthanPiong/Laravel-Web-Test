<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $data = $request->only(['name', 'description']);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        }
        
        Category::create($data);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $data = $request->only(['name', 'description']);
        
        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($category->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $category->image_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $category->image_url));
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        }
        
        $category->update($data);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    
    public function destroy(Category $category)
    {
        // Remove image if exists
        if ($category->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $category->image_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $category->image_url));
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}