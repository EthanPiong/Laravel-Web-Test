<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuItems = MenuItem::with('category')->where('is_available', true)->get();
        return response()->json([
            'status' => 'success',
            'data' => $menuItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menuItem = MenuItem::with('category')->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $menuItem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function categories()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
    
    public function categoryItems($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $menuItems = $category->menuItems()->where('is_available', true)->get();
        
        return response()->json([
            'status' => 'success',
            'category' => $category->name,
            'data' => $menuItems
        ]);
    }
}
