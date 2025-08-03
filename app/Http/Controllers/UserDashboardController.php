<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // User's order statistics
        $totalOrders = Order::where('customer_id', $user->id)->count();
        $pendingOrders = Order::where('customer_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
        $totalSpent = Order::where('customer_id', $user->id)
            ->sum('total_amount');
        
        // Recent orders
        $recentOrders = Order::where('customer_id', $user->id)
            ->with(['orderItems.coffee'])
            ->latest()
            ->take(3)
            ->get();
        
        // Featured coffees (latest or most popular)
        $featuredCoffees = Coffee::where('stock_quantity', '>', 0)
            ->latest()
            ->take(6)
            ->get();
        
        // User's favorite categories (based on order history)
        $favoriteCategories = Category::select('categories.*', DB::raw('COUNT(order_items.id) as order_count'))
            ->join('coffees', 'categories.id', '=', 'coffees.category_id')
            ->join('order_items', 'coffees.id', '=', 'order_items.coffee_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.customer_id', $user->id)
            ->groupBy('categories.id', 'categories.name', 'categories.description', 'categories.image_url', 'categories.created_at', 'categories.updated_at')
            ->orderBy('order_count', 'desc')
            ->take(3)
            ->get();
        
        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalSpent',
            'recentOrders',
            'featuredCoffees',
            'favoriteCategories'
        ));
    }

    public function home()
    {
        // Featured products
        $featuredCoffees = Coffee::where('stock_quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        
        // Categories
        $categories = Category::withCount('coffees')->get();
        
        // Special offers or bestsellers
        $bestsellers = Coffee::select('coffees.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'coffees.id', '=', 'order_items.coffee_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
            ->where('coffees.stock_quantity', '>', 0)
            ->groupBy(
                'coffees.id',
                'coffees.name',
                'coffees.description',
                'coffees.price',
                'coffees.category_id',
                'coffees.stock_quantity',
                'coffees.created_at',
                'coffees.updated_at',
                'coffees.supplier_id',
                'coffees.roast_level',
                'coffees.origin',
                'coffees.image_url'
            )
            ->orderBy('total_sold', 'desc')
            ->take(4)
            ->get();
        
        return view('user.home', compact('featuredCoffees', 'categories', 'bestsellers'));
    }

    public function shop(Request $request)
    {
        $query = Coffee::where('stock_quantity', '>', 0);
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by roast level
        if ($request->has('roast_level') && $request->roast_level) {
            $query->where('roast_level', $request->roast_level);
        }
        
        // Filter by origin
        if ($request->has('origin') && $request->origin) {
            $query->where('origin', 'like', '%' . $request->origin . '%');
        }
        
        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }
        
        $coffees = $query->paginate(12);
        $categories = Category::all();
        $roastLevels = Coffee::distinct()->pluck('roast_level')->filter();
        $origins = Coffee::distinct()->pluck('origin')->filter();
        
        return view('user.shop', compact('coffees', 'categories', 'roastLevels', 'origins'));
    }

    public function productDetail($id)
    {
        $coffee = Coffee::findOrFail($id);
        
        // Related products (same category)
        $relatedCoffees = Coffee::where('category_id', $coffee->category_id)
            ->where('id', '!=', $coffee->id)
            ->where('stock_quantity', '>', 0)
            ->take(4)
            ->get();
        
        return view('user.product-detail', compact('coffee', 'relatedCoffees'));
    }

    public function orderHistory()
    {
        $user = Auth::user();
        
        $orders = Order::where('customer_id', $user->id)
            ->with(['orderItems.coffee'])
            ->latest()
            ->paginate(10);
        
        return view('user.order-history', compact('orders'));
    }

    public function orderDetail($id)
    {
        $user = Auth::user();
        
        $order = Order::where('customer_id', $user->id)
            ->where('id', $id)
            ->with(['orderItems.coffee', 'customer'])
            ->firstOrFail();
        
        return view('user.order-detail', compact('order'));
    }

    public function profile()
    {
        $user = Auth::user();
        
        // User statistics
        $stats = [
            'total_orders' => Order::where('customer_id', $user->id)->count(),
            'total_spent' => Order::where('customer_id', $user->id)->sum('total_amount'),
            'favorite_coffee' => $this->getFavoriteCoffee($user->id),
            'member_since' => $user->created_at->format('M Y')
        ];
        
        return view('user.profile', compact('user', 'stats'));
    }

    public function aboutUs()
    {
        return view('user.about');
    }

    public function contactUs()
    {
        return view('user.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        // Here you can save to database or send email
        // For now, just redirect with success message
        
        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    private function getFavoriteCoffee($userId)
    {
        $favoriteCoffee = Coffee::select('coffees.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->join('order_items', 'coffees.id', '=', 'order_items.coffee_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.customer_id', $userId)
            ->groupBy('coffees.id', 'coffees.name')
            ->orderBy('total_quantity', 'desc')
            ->first();
        
        return $favoriteCoffee ? $favoriteCoffee->name : 'None yet';
    }
}