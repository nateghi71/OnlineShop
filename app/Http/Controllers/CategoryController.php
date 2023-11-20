<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('parent_id' , 0)->get();
        return view('admin.categories.create' , compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'name' => 'required|string',
        ]);

        Category::create([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show' , compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('parent_id' , 0)->whereNot('id' , $category->id)->get();
        return view('admin.categories.edit' , compact('category' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'name' => 'required|string',
        ]);

        $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }

}
