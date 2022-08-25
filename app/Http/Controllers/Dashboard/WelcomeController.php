<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\TotalPrice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $a =Carbon::now()->format('Y/m/d');
        $categories_count = Category::count();
        $products_count = Product::count();
        $order_day =  Order::where(['create_order'=>$a])->count();

        $users_count = User::whereRoleIs('admin')->count();

        $sales_data = Order::select(
           DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum')
        )->groupBy('month')->get();

        $sales_data_t = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('DAY(created_at) as day'),
            DB::raw('SUM(total_price) as sum')
        )->groupBy('DAY')->get();




        return view('dashboard.welcome', compact('categories_count', 'products_count', 'order_day', 'users_count','sales_data' , 'sales_data_t'));

    }//end of index

}//end of controller
