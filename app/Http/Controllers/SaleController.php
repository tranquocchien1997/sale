<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumType;
use App\Contracts\ElementConfig;
use App\DetailPackage;
use App\HtmlElement;
use App\Import;
use App\Package;
use App\Product;
use App\OrderProduct;
use App\Order;
use App\Size;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SaleController extends Controller
{
    public function home()
    {
        $orders = Order::with('products')->get();
        $products = Product::all();
        $totalImportPrice = $products->sum('import_price');
        $totalAllImportPrice = Import::all()->sum('price');
        $totalProduct = Product::all()->count();
        $totalProductSold = Product::where('status', 'SOLD')->count();
        $totalProductAvailable = Product::where('status', 'AVAILABLE')->count();
        $totalPrice = $orders->sum('total_amount');
        $totalFinalPrice = $orders->sum('final_amount');
        $totalOrder = $orders->count();
        $typeProductAvailable = implode('|', \DB::table('products')->where('status', 'AVAILABLE')->select([
            \DB::raw('count(id) as number'),
            'type'
        ])->groupBy('type')->get()->map(function($item) { return $item->type . ': ' . $item->number;})->toArray());

        $typeProductSold = implode('|', \DB::table('products')->where('status', 'SOLD')->select([
            \DB::raw('count(id) as number'),
            'type'
        ])->groupBy('type')->get()->map(function($item) { return $item->type . ': ' . $item->number;})->toArray());
        
        $orderNew = Order::where('status', 'NEW')->get();
        $totalOrderNew = $orderNew->count();
        $totalOrderNewPrice = $orderNew->sum('final_amount');

        return view('sale.index', compact( 'totalImportPrice',
        'totalProduct',
        'totalProductSold',
        'totalProductAvailable',
        'totalPrice',
        'totalFinalPrice',
        'totalOrder',
        'totalOrderNew',
        'typeProductAvailable',
        'typeProductSold',
        'totalAllImportPrice',
        'totalOrderNewPrice'));
    }


    public function products()
    {
        $products = Product::with('sizes')->orderBy('status')->orderBy('id', 'DESC')->get();
    
        return view('sale.products' , compact('products'));
    }

   
    public function productDetail($id)
    {
        
        $product  = Product::with('sizes')->where('id', $id)->first();

       
        return view('sale.product-detail' , compact('product'));
    }

    public function productDelete($id)
    {
        Product::find($id)->delete();
        return redirect()->back();
    }

    public function productCreate(Request $request)
    {
        if ($request->isMethod('POST')) {
            
            if ($file = $request->file('banner')) {
                $request = $request->merge([
                    'path_thumb' => str_replace('public', 'storage', $file->store('public/sale'))
                ]);

            }
            $latestId = (Product::where('type', $request->type)->latest()->first()->id ?? 0) + 80 + 1;
            $request = $request->merge([
                'name' => \App\Contracts\SaleConfig::PRODUCT_KEY_TYPES[$request->type] . $latestId,
                'status' => 'AVAILABLE'
            ]);
            $product = Product::create($request->all());

            
            foreach($request->sizes as $size) {
                if($size['value']) {
                    Size::create([
                        'product_id' => $product->id,
                        'value' => $size['value'],
                        'name' => $size['name'],
                    ]);
                }
                
            }
            return redirect()->route('sale.product');
        }


        
        
        return view('sale.product-create');
    }



    public function productUpdate(Request $request)
    {

        $product = Product::find($request->id);
        if ($file = $request->file('banner')) {
            $request = $request->merge([
                'path_thumb' => str_replace('public', 'storage', $file->store('public/album'))
            ]);

        }

        Size::where('product_id', $product->id)->delete();
        foreach($request->sizes as $size) {
            if($size['value']) {
                Size::create([
                    'product_id' => $product->id,
                    'value' => $size['value'],
                    'name' => $size['name'],
                ]);
            }
            
        }
        $product->update($request->all());
        return redirect()->back();

    }


    public function orders()
    {
        $orders = Order::with('products')->orderBy('id', 'DESC')->get();
   
        return view('sale.orders' , compact(
            'orders',
           
        ));
    }

   
    public function orderDetail($id)
    {
        
        $order  = Order::with('products')->where('id', $id)->first();
        $products = Product::where('status', 'AVAILABLE')->with('sizes')->orderBy('id', 'DESC')->get();
       
        return view('sale.order-detail' , compact('order', 'products'));
    }

    public function orderDelete($id)
    {
        Order::find($id)->delete();
        return redirect()->back();
    }

    public function orderCreate(Request $request)
    {
        
        if ($request->isMethod('POST')) {
          
            $products = Product::whereIn('id', $request->products)->get();

            $total_amount = array_sum($products->pluck('price')->toArray()) + intval($request->additional_amount);
            $request = $request->merge([
            
                'status' => 'NEW',
                'total_amount' => $total_amount,
                'is_freeship' => $request->is_freeship == 'on' ? true : false,
                'is_paid' => $request->is_paid == 'on' ? true : false,
                'final_amount' => $total_amount - intval($request->freeship_amount) - array_sum($products->pluck('import_price')->toArray()),
            ]);
            $order = Order::create($request->all());

            
            foreach($products as $product) {
                OrderProduct::create([
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                
                ]);
             
                
            }
            $this->updateStatusProduct();
            return redirect()->route('sale.order');
        }


        $products = Product::where('status', 'AVAILABLE')->with('sizes')->orderBy('id', 'DESC')->get();
        
        return view('sale.order-create', compact('products'));
    }



    public function orderUpdate(Request $request)
    {

        $order = Order::find($request->id);
        $products = Product::whereIn('id', $request->products)->get();

            $total_amount = array_sum($products->pluck('price')->toArray()) + intval($request->additional_amount);
            $request = $request->merge([
            
                'total_amount' => $total_amount,
                'is_freeship' => $request->is_freeship == 'on' ? true : false,
                'is_paid' => $request->is_paid == 'on' ? true : false,
                'final_amount' => $total_amount - intval($request->freeship_amount) - array_sum($products->pluck('import_price')->toArray()),
            ]);

            OrderProduct::where('order_id', $order->id)->delete();

            foreach($products as $product) {
                OrderProduct::create([
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                
                ]);
            
                
            }
            $order->update($request->all());
            $this->updateStatusProduct();

        return redirect()->back();

    }

    protected function updateStatusProduct() 
    {
        Product::where('id', '<>', 0)->update([
            'status' => 'AVAILABLE'
        ]);

        Product::whereIn('id', OrderProduct::all()->pluck('product_id')->toArray())->update([
            'status' => 'SOLD'
        ]);
    }
}
