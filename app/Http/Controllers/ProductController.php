<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::with(relations: "category")->orderBy('created_at',"desc");
        if(request()->has("category")){
            $query->whereHas('category',function($q){
                $q->where("name",request("category"));
            });
        }
        $product=$query->get();
        return ProductResource::collection($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        
        if (Product::where('barcode', $validated['barcode'])->exists()) {
            return response()->json(['message' => 'Product with this barcode already exists!'], 400);
        }
        if(Product::whereRaw('LOWER(name)=?',[strtolower($validated['name'])])->exists()){
            return response()->json(['message' => 'Product with this name already exists!'], 400);
        }
        $product = Product::create($validated);

        return response()->json([
            "message"=>"Product create successfully!",
            "data"=>new ProductResource(resource: $product)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

       return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if($product){

            $product->fill( $request->validated());

            $product->save();

            return response()->json(["message"=>"Product update successfully.", "data"=>new ProductResource($product)]);
        }
        return response()->json(["message"=> "Product not found"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(["message" => "Product deleted successfully."]);
        }

        return response()->json(["message" => "Product not found"], 404);
    }
}
