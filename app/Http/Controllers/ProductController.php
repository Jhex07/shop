<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Traits\UploadFile;

class ProductController extends Controller
{
    use UploadFile;

    public function home()
    {
        $products = Product::with('category')->whereHas('category')->where('stock', '>', 0)->get();
        return view('index', compact('products'));
    }

    public function index(Request $request)
    {
        $products = Product::with('category', 'file')->get();
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
            $this->UploadFile($product, $request);
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

    public function update(ProductUpdateRequest $request, Product $product)
    {
        try{
            DB::beginTransaction();
            $product -> update($request->all());
            $this->UploadFile($product, $request);
            DB::commit();
            if(!$request->ajax()){
                return back()->with('success', 'Product update');
            }
            return response()->json([], 204);

        } catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }

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
        $this->deleteFile($product);
        if(!$request->ajax()){
            return back()->with('succes', 'User delete');
        }
        return response()->json([], 204);
    }
}
