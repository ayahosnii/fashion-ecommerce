<?php

namespace App\Http\Controllers;

use App\Models\admin\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products =  auth()->user()
            ->wishlist()
            ->with(['images', 'categories'])
            ->latest()
            ->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function apiAddToWishlist()
    {
        if (auth()->check()) {
            if (! auth()->user()->wishlistHas(request('productId'))) {
                auth()->user()->wishlist()->attach(request('productId'))->with(['images', 'categories']);
                return response()->json(['status' => true, 'wished' => true]);
            }
            return response()->json(['status' => true, 'wished' => false]);
        }else{
            return redirect()->route('login');
        }

        return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        auth()->user()->wishlist()->detach(request('product_id'));
    }
}
