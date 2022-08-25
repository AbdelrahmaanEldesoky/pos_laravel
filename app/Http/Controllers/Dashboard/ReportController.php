<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $count_order = Order::when($request->date1, function ($q) use ($request) {
            return $q->whereBetween('create_order', [$request->date1,$request->date2 ]);
        })->count('id');


        $report_a = Order::when($request->date1, function ($q) use ($request) {
            return $q->whereBetween('create_order', [$request->date1,$request->date2 ]);
        })->where(['is_active'=>'1'])->sum('total_price');

        $report_d = Order::when($request->date2, function ($q) use ($request) {

            return $q->whereBetween('create_order', [$request->date1,$request->date2 ]);

        })->where(['is_active'=>'0'])->sum('total_price');

        $a =Carbon::now()->format('Y/m/d');
        $report_aa = Order::where(['create_order'=>$a])->where(['is_active'=>'1'])->sum('total_price');
        $report_dd = Order::where(['create_order'=>$a])->where(['is_active'=>'0'])->sum('total_price');
        $count_order_a = Order::where(['create_order'=>$a])->count('id');
        $orders = Order::where(['create_order'=>$a])->paginate(5);

        return view('dashboard.report.index', compact('orders','report_a','report_d','report_aa' , 'report_dd' ,'count_order_a','count_order'));

    }//end of index

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));

    }//end of create

    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required',
            // 'purchase_price' => 'required',
            'sale_price' => 'required',
            //'stock' => 'required',
//            'name' => 'required',
            //          'description' => 'required'
        ];


        $request->validate($rules);

        $request_data = $request->all();

        if ($request->image) {

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if

        $product= Product::create($request_data);
        $product->name = $request->name;
        $product->description  = $request->description;
        $product->save();

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');

    }//end of store

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories', 'product'));

    }//end of edit

    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'sale_price' => 'required',
        ];




        $request->validate($rules);

        $request_data = $request->all();

        if ($request->image) {

            if ($product->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);

            }//end of if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if

        $product->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');

    }//end of update

    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {

            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);

        }//end of if

        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');

    }//end of destroy

}//end of controller
