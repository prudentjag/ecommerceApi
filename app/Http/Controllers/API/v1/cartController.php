<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\cartRequest;
use App\Http\Response;
use App\Models\cart;
use Illuminate\Http\Request;

class cartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usercart = cart::with('product')->where('user_id', auth()->user()->id)->get();
        return response()->json(['message' => $usercart], Response::HTTP_OK);
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
    public function store(cartRequest $request)
    {
         $carts = $request->validated();
        $addCart = cart::create($carts);
        if ($addCart) {
            return response()->json(['message'=> "Product added to cart", 'cart_id' => $addCart->id], Response::HTTP_CREATED);
        } else {
            return response()->json(['error'=> "Error adding product to cart"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $cart = cart::find($id);
        if (!$cart) {
            return response()->json(['error'=> "cart not found"], Response::HTTP_NOT_FOUND);
        }
        if($cart->user_id === auth()->user()->id){
            if ($cart->delete()) {
                return response()->json(['message'=> "Product removed from cart"], Response::HTTP_OK);
            } else {
                return response()->json(['error'=> "Error removing product from cart"], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }else{
            return response()->json(['error'=> "Na wa for you oo"], Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }
}
