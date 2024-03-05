<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\productRequest;
use App\Http\Response;
use App\Models\Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $products = Products::with('comments')->get();
        return response()->json(['message' => $products], Response::HTTP_OK);
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
    public function store(productRequest $request)
    {
        $products = $request->validated();
        $addProduct = Products::create($products);
        if ($addProduct) {
            return response()->json(['message'=> "Product created successfully", 'product_id' => $addProduct->id], Response::HTTP_CREATED);
        } else {
            return response()->json(['error'=> "Error creating product"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = Products::with('comments')->find($id);
        if ($product) {
            return response()->json(['message'=>$product], Response::HTTP_OK);
        }else{
            return response()->json(['error'=> "Product does not exist"], Response::HTTP_FOUND);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $product = Products::find($id);
        if ($product) {
            return response()->json(['message'=> $product], Response::HTTP_OK);
        }else{
            return response()->json(['error'=> "Product does not exist"], Response::HTTP_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(productRequest $request, int $id)
    {
        $product = $request->validated();
        $update = Products::find($id);
        if (!$update) {
            return response()->json(['error'=> "Product not found"], Response::HTTP_NOT_FOUND);
        }
        $update->update($product);
        if ($update->wasChanged()) {
            return response()->json(['message'=> "Product Updated Successfully"], Response::HTTP_OK);
        } else {
            return response()->json(['message'=> "No changes were made to the product"], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['error'=> "Product not found"], Response::HTTP_NOT_FOUND);
        }

        if ($product->delete()) {
            return response()->json(['message'=> "Product deleted"], Response::HTTP_OK);
        } else {
            return response()->json(['error'=> "Error deleting product"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
