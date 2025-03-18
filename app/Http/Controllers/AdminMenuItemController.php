<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->get();
        return view('admin.menu-items.index', compact('menuItems'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('admin.menu-items.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'sometimes|boolean'
        ]);
        
        $data = $request->only(['category_id', 'name', 'description', 'price']);
        $data['is_available'] = $request->has('is_available');
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-items', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        }
        
        MenuItem::create($data);
        
        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item created successfully.');
    }
    
    public function edit(MenuItem $menuItem)
    {
        $categories = Category::all();
        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }
    
    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'sometimes|boolean'
        ]);
        
        $data = $request->only(['category_id', 'name', 'description', 'price']);
        $data['is_available'] = $request->has('is_available');
        
        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($menuItem->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $menuItem->image_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $menuItem->image_url));
            }
            
            $imagePath = $request->file('image')->store('menu-items', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        }
        
        $menuItem->update($data);
        
        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item updated successfully.');
    }
    
    public function destroy(MenuItem $menuItem)
    {
        // Remove image if exists
        if ($menuItem->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $menuItem->image_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $menuItem->image_url));
        }
        
        $menuItem->delete();
        
        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item deleted successfully.');
    }
}