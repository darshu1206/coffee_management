<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Coffee;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class CoffeeManagementSeeder extends Seeder
{
    public function run()
    {
        // Create Categories
        $categories = [
            ['name' => 'Espresso', 'description' => 'Strong, concentrated coffee'],
            ['name' => 'Americano', 'description' => 'Espresso with hot water'],
            ['name' => 'Latte', 'description' => 'Espresso with steamed milk'],
            ['name' => 'Cappuccino', 'description' => 'Espresso with steamed milk and foam'],
            ['name' => 'Cold Brew', 'description' => 'Coffee brewed with cold water'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Suppliers
        $suppliers = [
            [
                'name' => 'Colombian Coffee Co.',
                'contact_person' => 'Juan Rodriguez',
                'email' => 'juan@colombiancoffee.com',
                'phone' => '+57-1-234-5678',
                'address' => '123 Coffee St, Bogotá',
                'country' => 'Colombia',
                'rating' => 4.5
            ],
            [
                'name' => 'Ethiopian Highlands',
                'contact_person' => 'Abebe Kebede',
                'email' => 'abebe@ethiopianhighlands.com',
                'phone' => '+251-11-123-4567',
                'address' => '456 Bean Ave, Addis Ababa',
                'country' => 'Ethiopia',
                'rating' => 4.8
            ],
            [
                'name' => 'Brazilian Beans Ltd',
                'contact_person' => 'Maria Santos',
                'email' => 'maria@brazilianbeans.com',
                'phone' => '+55-11-9876-5432',
                'address' => '789 Santos Port, São Paulo',
                'country' => 'Brazil',
                'rating' => 4.3
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Create Coffees
        $coffees = [
            [
                'name' => 'Colombian Supremo',
                'description' => 'Premium Colombian coffee with rich flavor',
                'price' => 18.99,
                'stock_quantity' => 50,
                'category_id' => 1,
                'supplier_id' => 1,
                'roast_level' => 'medium',
                'origin' => 'Colombia'
            ],
            [
                'name' => 'Ethiopian Yirgacheffe',
                'description' => 'Floral and citrusy Ethiopian coffee',
                'price' => 22.50,
                'stock_quantity' => 30,
                'category_id' => 2,
                'supplier_id' => 2,
                'roast_level' => 'light',
                'origin' => 'Ethiopia'
            ],
            [
                'name' => 'Brazilian Santos',
                'description' => 'Smooth and balanced Brazilian coffee',
                'price' => 16.75,
                'stock_quantity' => 75,
                'category_id' => 3,
                'supplier_id' => 3,
                'roast_level' => 'medium',
                'origin' => 'Brazil'
            ],
            [
                'name' => 'Colombian Decaf',
                'description' => 'Decaffeinated Colombian coffee',
                'price' => 19.99,
                'stock_quantity' => 25,
                'category_id' => 1,
                'supplier_id' => 1,
                'roast_level' => 'medium',
                'origin' => 'Colombia'
            ],
            [
                'name' => 'Ethiopian Sidamo',
                'description' => 'Wine-like Ethiopian coffee',
                'price' => 21.00,
                'stock_quantity' => 8, // Low stock item
                'category_id' => 4,
                'supplier_id' => 2,
                'roast_level' => 'dark',
                'origin' => 'Ethiopia'
            ],
            [
                'name' => 'Brazilian Cold Brew',
                'description' => 'Perfect for cold brewing',
                'price' => 15.50,
                'stock_quantity' => 5, // Low stock item
                'category_id' => 5,
                'supplier_id' => 3,
                'roast_level' => 'medium',
                'origin' => 'Brazil'
            ],
        ];

        foreach ($coffees as $coffee) {
            Coffee::create($coffee);
        }

        // Create Customers
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1-555-123-4567',
                'address' => '123 Main St, City, State',
                'date_of_birth' => '1985-05-15',
                'loyalty_points' => 250
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1-555-987-6543',
                'address' => '456 Oak Ave, City, State',
                'date_of_birth' => '1990-08-22',
                'loyalty_points' => 180
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'phone' => '+1-555-456-7890',
                'address' => '789 Pine Rd, City, State',
                'date_of_birth' => '1982-12-10',
                'loyalty_points' => 320
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Create Orders with OrderItems
        $orders = [
            [
                'customer_id' => 1,
                'total_amount' => 41.48,
                'status' => 'completed',
                'order_date' => Carbon::now()->subDays(1),
                'delivery_address' => '123 Main St, City, State',
                'payment_method' => 'card',
                'notes' => 'Please deliver in the morning'
            ],
            [
                'customer_id' => 2,
                'total_amount' => 22.50,
                'status' => 'processing',
                'order_date' => Carbon::now()->subHours(3),
                'delivery_address' => '456 Oak Ave, City, State',
                'payment_method' => 'online',
                'notes' => null
            ],
            [
                'customer_id' => 3,
                'total_amount' => 67.50,
                'status' => 'pending',
                'order_date' => Carbon::now()->subMinutes(30),
                'delivery_address' => '789 Pine Rd, City, State',
                'payment_method' => 'cash',
                'notes' => 'Call before delivery'
            ],
            [
                'customer_id' => 1,
                'total_amount' => 35.75,
                'status' => 'completed',
                'order_date' => Carbon::now()->subDays(5),
                'delivery_address' => '123 Main St, City, State',
                'payment_method' => 'card',
                'notes' => null
            ],
            [
                'customer_id' => 2,
                'total_amount' => 18.99,
                'status' => 'completed',
                'order_date' => Carbon::now()->subDays(10),
                'delivery_address' => '456 Oak Ave, City, State',
                'payment_method' => 'online',
                'notes' => null
            ],
        ];

        foreach ($orders as $orderData) {
            Order::create($orderData);
        }

        // Create Order Items
        $orderItems = [
            // Order 1 items
            ['order_id' => 1, 'coffee_id' => 1, 'quantity' => 2, 'price' => 18.99, 'subtotal' => 37.98],
            ['order_id' => 1, 'coffee_id' => 3, 'quantity' => 1, 'price' => 16.75, 'subtotal' => 16.75],
            
            // Order 2 items
            ['order_id' => 2, 'coffee_id' => 2, 'quantity' => 1, 'price' => 22.50, 'subtotal' => 22.50],
            
            // Order 3 items
            ['order_id' => 3, 'coffee_id' => 1, 'quantity' => 1, 'price' => 18.99, 'subtotal' => 18.99],
            ['order_id' => 3, 'coffee_id' => 2, 'quantity' => 2, 'price' => 22.50, 'subtotal' => 45.00],
            ['order_id' => 3, 'coffee_id' => 4, 'quantity' => 1, 'price' => 19.99, 'subtotal' => 19.99],
            
            // Order 4 items
            ['order_id' => 4, 'coffee_id' => 3, 'quantity' => 2, 'price' => 16.75, 'subtotal' => 33.50],
            ['order_id' => 4, 'coffee_id' => 5, 'quantity' => 1, 'price' => 21.00, 'subtotal' => 21.00],
            
            // Order 5 items
            ['order_id' => 5, 'coffee_id' => 1, 'quantity' => 1, 'price' => 18.99, 'subtotal' => 18.99],
        ];

        foreach ($orderItems as $item) {
            OrderItem::create($item);
        }
    }
}