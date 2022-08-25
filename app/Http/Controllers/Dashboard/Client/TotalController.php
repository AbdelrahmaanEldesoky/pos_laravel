<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\TotalPrice;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TotalController extends Controller
{
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.create', compact( 'client', 'categories', 'orders'));

    }//end of create

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $this->attach_order($request, $client);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of store

    public function edit(Client $client,  $id)
    {

       $order = Order::find(['id' => $id]) ;

       return view('dashboard.edit' , compact('order','client'));
       /*= TotalPrice::create([
            'id_table' =>  $client->id,
            'type' => $client->type,
            'total_price' => $total_price
            ]);
        */


    }//end of edit

    public function update(Request $request, Client $client,  $order)
    {
        $orders = Order::FindOrFail($order);
        $orders->update([
            'is_active' => '0'
        ]);

          /* $total= TotalPrice::create([
               'id_table' => $client->id,
                'type' => $client->type,
                'total_price' => $order,
           ]) ;
            //$total->save();   */
        $clients = Client::find($client->id);
         $clients->update([
            'is_active' => '0'
        ]);
        return redirect()->route('dashboard.orders.index');

    }//end of update

    private function attach_order($request, $client)
    {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);

        }//end of foreach

        $order->update([
            'total_price' => $total_price
        ]);

    }//end of attach order

    private function detach_order($order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }//end of for each

        $order->delete();

    }//end of detach order

}//end of controller
