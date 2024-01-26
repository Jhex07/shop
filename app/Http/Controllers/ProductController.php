<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Category;

class ProductController extends Controller
{
    public function home()
    {
        $products = Product::with('category')->whereHas('category')->where('stock', '>', 0)->get();
        return view('index', compact('products'));
    }

    public function index(Request $request)
    {
        $products = Product::with('category')->get();
        $categories = Category::get();
        if(!$request->ajax()){
            return view('products.index', compact('products', 'categories'));
        }
        return response()->json(['products'=> $products], 200);
    }


    public function create()
    {
        //
    }


    public function store(ProductRequest $request)
    {
        try{
            DB::beginTransaction();
            $product = new Product($request->all());
            $product->save();
            DB::commit();
            if(!$request->ajax()){
                return back()->with('success', 'product created');
            }
            return response()->json(['status'=> 'product created', 'product' => $product], 201);

        } catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }
    }

    public function update(ProductRequest $request, Product $product)
    {
        try{
            DB::beginTransaction();
            $product -> update($request->all());

            DB::commit();
            if(!$request->ajax()){
                return back()->with('success', 'Product update');
            }
            return response()->json([], 204);

        } catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }

        dd($request->all(), $product);
    }


    public function show(Request $request, Product $product)
    {
        if(!$request->ajax()){
            return view('products.show', compact('product'));
        }
        return response()->json(['product' => $product], 200);
    }




    public function edit($id)
    {
        //
    }




    public function destroy(Request $request, Product $product)
    {
        $product -> delete();
        if(!$request->ajax()){
            return back()->with('succes', 'User delete');
        }
        return response()->json([], 204);
    }
}
