<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories', 'images'])
            ->where('in_stock', 1)
            ->where('is_active', 1)->get();
        $dealProducts = $products->sortByDesc('viewed')->take(2);
        $featuredProducts = $products->sortByDesc('sale_price')->take(4);

        $response = [
            'all_products' => $products,
            'deal_products' => $dealProducts,
            'featured_products' => $featuredProducts,
        ];

        return response()->json($response);
    }


    public function details($id)
    {
        $product = Product::with(['categories', 'images'])
            ->where('in_stock', 1)
            ->where('is_active', 1)->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
