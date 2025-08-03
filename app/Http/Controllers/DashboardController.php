<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get key metrics
        $totalCoffees = Coffee::count();
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();
        
        // Revenue calculations
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
            ->sum('total_amount');
        
        $monthlyRevenue = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');
        
        $yearlyRevenue = Order::whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');
        
        // Recent orders
        $recentOrders = Order::with(['customer', 'orderItems.coffee'])
            ->latest()
            ->take(5)
            ->get();
        
        // Low stock items (assuming quantity < 10 is low stock)
        $lowStockItems = Coffee::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();
        
        // Top selling coffees (last 30 days)
        $topSellingCoffees = Coffee::select('coffees.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'coffees.id', '=', 'order_items.coffee_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
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
            ->take(5)
            ->get();

        
        // Monthly sales data for chart (last 12 months)
        $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Order status distribution
        $orderStatusData = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        
        // Recent activities (you can customize this based on your needs)
        $recentActivities = collect([
            [
                'type' => 'order',
                'message' => 'New order #' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) . ' received',
                'time' => Carbon::now()->subMinutes(rand(5, 60)),
                'icon' => 'shopping-cart'
            ],
            [
                'type' => 'stock',
                'message' => 'Low stock alert: Colombian Supremo',
                'time' => Carbon::now()->subHours(rand(1, 3)),
                'icon' => 'alert-triangle'
            ],
            [
                'type' => 'customer',
                'message' => 'New customer registered',
                'time' => Carbon::now()->subHours(rand(2, 5)),
                'icon' => 'user-plus'
            ]
        ]);
        
        return view('dashboard', compact(
            'totalCoffees',
            'totalOrders',
            'totalCustomers',
            'totalSuppliers',
            'todayRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'recentOrders',
            'lowStockItems',
            'topSellingCoffees',
            'monthlySales',
            'orderStatusData',
            'recentActivities'
        ));
    }
    
    public function getChartData()
    {
        // API endpoint for dynamic chart updates
        $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        return response()->json($monthlySales);
    }
}