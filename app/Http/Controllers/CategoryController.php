<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at','desc')->get();

        return CategoryResource::collection($categories);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated= $request->validated();
        if(Category::whereRaw('LOWER (name)=?',[strtolower($validated["name"])])->exists()){
            return response()->json(['message' => 'Category with this name already exists!'], 400);
        }
        $category= Category::create(attributes: $request->all());
        return response()->json(["message"=>"Category create successfully.","data"=>new CategoryResource($category)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            return new CategoryResource(resource: $category);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if($category){

            $category->fill(attributes: $request->validated());

            $category->save();

            return response()->json(["message"=>"Category update successfully.", "data"=>new CategoryResource($category)]);
        }
        return response()->json(["message"=> "Category not found"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Automatically throws an exception if the resource is not found,
        $category = Category::findOrFail($id);

        $category->delete();
        return response()->json(["message"=> "Category delete successfully."],200);
    }
}
