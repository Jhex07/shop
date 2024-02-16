<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartProduct;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('products')->firstOrCreate();

        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        try {

            $productId = $request->input('id');
            $quantity = $request->input('quantity', 1);


            $product = Product::findOrFail($productId);

            $user = $request->user();
            $cart = $user->cart;

            $existingProduct = $cart->products()->find($product->id);

            if ($existingProduct) {

                $cart->products()->updateExistingPivot($product->id, ['quantity' => $existingProduct->pivot->quantity + $quantity]);
            } else {

                $cart->products()->attach($product, ['quantity' => $quantity]);
            }

            return response()->json(['message' => 'Producto agregado al carrito'], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Error al agregar el producto al carrito'], 500);
        }
    }

    public function show()
    {
        $user = auth()->user();
        $cart = $user->cart;
        $cartProducts = $cart ? $cart->products : [];

        return view('cart.show', compact('cartProducts'));
    }

    public function getCartItems(Request $request)
    {
        $cart = $request->user()->cart;

        if ($cart) {
            $items = $cart->products()->withPivot('quantity')->get();
            return response()->json(['items' => $items], 200);
        }

        return response()->json(['items' => []], 200);
    }

    public function removeFromCart(Request $request, $productId)
    {
        $user = $request->user();
        $cart = $user->cart;

        if ($cart) {
            $cart->products()->detach($productId);
        }

        return response()->json(['message' => 'Producto eliminado'], 200);
    }

}
