<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
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
        $attributes = Attribute::all();
        $categories = Category::where('parent_id' , 0)->get();
        return view('admin.categories.create' , compact('categories' , 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->attribute_ids);

        $request->validate([
            'parent_id' => 'required|integer',
            'name' => 'required|string',
            'attribute_ids' => 'required',
        ]);

         $category = Category::create([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
        ]);

        $category->attributes()->attach($request->attribute_ids);
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
        $attributes = Attribute::all();
        $categories = Category::where('parent_id' , 0)->whereNot('id' , $category->id)->get();
        return view('admin.categories.edit' , compact('category' , 'categories' , 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'name' => 'required|string',
            'attribute_ids' => 'required',
        ]);

        $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
        ]);

        $category->attributes()->detach();
        $category->attributes()->attach($request->attribute_ids);
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
