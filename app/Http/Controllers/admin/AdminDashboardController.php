<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Coffee;
use App\Models\Order;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        // Dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_coffees' => Coffee::count(),
            'total_orders' => Order::count(),
            'total_customers' => Customer::count(),
            'total_categories' => Category::count(),
            'total_suppliers' => Supplier::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'low_stock_items' => Coffee::where('stock_quantity', '<', 10)->count(),
        ];

        // Recent orders
        $recentOrders = Order::with(['customer'])
            ->latest()
            ->take(5)
            ->get();

        // Low stock items
        $lowStockItems = Coffee::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();

        // Monthly revenue chart data (last 12 months) - MariaDB compatible
        $monthlyRevenue = Order::select([
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTHNAME(created_at) as month_name'),
                DB::raw('SUM(total_amount) as revenue')
            ])
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy([
                DB::raw('YEAR(created_at)'),
                DB::raw('MONTH(created_at)'),
                DB::raw('MONTHNAME(created_at)')
            ])
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Get top selling coffees using MariaDB-compatible approach
        $topSellingCoffees = $this->getTopSellingCoffees();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topSellingCoffees',
            'lowStockItems',
            'monthlyRevenue'
        ));
    }

    /**
     * Get top selling coffees using MariaDB-compatible approach
     */
    private function getTopSellingCoffees()
    {
        // Step 1: Get coffee sales data using a simple query
        $coffeeSales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
            ->where('orders.status', 'completed')
            ->groupBy('order_items.coffee_id')
            ->select([
                'order_items.coffee_id',
                DB::raw('SUM(order_items.quantity) as total_sold')
            ])
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Step 2: Get coffee IDs from the results
        $coffeeIds = $coffeeSales->pluck('coffee_id')->toArray();

        if (empty($coffeeIds)) {
            return collect([]);
        }

        // Step 3: Get the actual coffee models
        $coffees = Coffee::whereIn('id', $coffeeIds)->get()->keyBy('id');

        // Step 4: Merge sales data with coffee models and maintain order
        return $coffeeSales->map(function($sale) use ($coffees) {
            $coffee = $coffees->get($sale->coffee_id);
            if ($coffee) {
                $coffee->total_sold = $sale->total_sold;
                return $coffee;
            }
            return null;
        })->filter()->values();
    }

    /**
     * Alternative method for MariaDB - using separate queries (most compatible)
     */
    private function getTopSellingCoffeesSimple()
    {
        // Get top 5 coffee IDs by sales in the last 30 days
        $topCoffeeIds = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
            ->where('orders.status', 'completed')
            ->select('order_items.coffee_id', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('order_items.coffee_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->pluck('coffee_id');

        if ($topCoffeeIds->isEmpty()) {
            return collect([]);
        }

        // Get coffee details and calculate total sold for each
        return Coffee::whereIn('id', $topCoffeeIds)
            ->get()
            ->map(function ($coffee) {
                $totalSold = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('order_items.coffee_id', $coffee->id)
                    ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
                    ->where('orders.status', 'completed')
                    ->sum('order_items.quantity');
                
                $coffee->total_sold = $totalSold;
                return $coffee;
            })
            ->sortByDesc('total_sold')
            ->values();
    }
}