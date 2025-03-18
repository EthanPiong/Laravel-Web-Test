<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with('menuItems')->get();
        return view('menu.index', compact('categories'));
    }

    public function show($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return view('menu.show',compact('menuItem'));
    }
}
