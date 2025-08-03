<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
            ->with('coffee')
            ->get();
        
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->coffee->price;
        });
        
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;
        
        return view('user.cart', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'coffee_id' => 'required|exists:coffees,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $user = Auth::user();
        $coffee = Coffee::findOrFail($request->coffee_id);
        
        // Check if item already exists in cart
        $existingItem = Cart::where('user_id', $user->id)
            ->where('coffee_id', $request->coffee_id)
            ->first();
        
        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'coffee_id' => $request->coffee_id,
                'quantity' => $request->quantity,
                'price' => $coffee->price
            ]);
        }
        
        $cartCount = Cart::where('user_id', $user->id)->sum('quantity');
        
        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully!',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->findOrFail($id);
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->findOrFail($id);
        $cartItem->delete();
        
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
            ->with('coffee')
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty!');
        }
        
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->coffee->price;
        });
        
        $tax = $subtotal * 0.1;
        $shipping = $subtotal > 50 ? 0 : 10; // Free shipping over $50
        $total = $subtotal + $tax + $shipping;
        
        return view('user.checkout', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            return response()->json(['cart_count' => $cartCount]);
        }
        
        return response()->json(['cart_count' => 0]);
    }
}