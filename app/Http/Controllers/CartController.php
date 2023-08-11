<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Exceptions\QuantityExceededException;
use App\Models\admin\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Instance of Cart.
     *
     * @var Cart
     */
    protected $cart;
    protected $id;

    /**
     * Create a new CartController instance.
     *
     * @param Cart $cart
     * @param Product $product
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;

    }

    public function apiCartItems()
    {
       $items = $this->cart->all();
       return response()->json($items);
    }


    public function apiAddToCart(Request $request)
    {
        $slug = $request->input('slug');

        $product = Product::where('slug', $slug)->with(['categories', 'images'])->firstOrFail();

        try {
            $this->cart->add($product, $request->quantity ?? 1);
        } catch (QuantityExceededException $e) {
            return response()->json($e);
        }

        return response()->json([
            'message' => 'Product added successfully to the cart',
        ]);

    }
    public function postUpdate(Request $request)
    {
        $product = Product::where('slug', $request->input('slug'))->firstOrFail();

        try {
            $this->cart->update($product, $request->input('newQuantity'));

        } catch (QuantityExceededException $e) {
            return trans('site.cart.msgs.exceeded');
        }

        if (!$request->quantity) {
            return array_merge([
                'total' => $this->num_format($this->cart->subTotal()) . " (" . ('symbol') . ")"
            ], trans('site.cart.msgs.removed'));
        }

        return trans('site.cart.msgs.updated');
    }
     public function postDelete(Request $request)
    {
        $product = Product::where('slug', $request->input('slug'))->firstOrFail();

        try {
            $this->cart->remove($product->id);

        } catch (QuantityExceededException $e) {
            return response()->json($e);
        }

        return response()->json('success');
    }

    public function apiCartSubtotal()
    {
        $subTotal = $this->cart->subTotal();
        return response()->json($subTotal);
    }

}
