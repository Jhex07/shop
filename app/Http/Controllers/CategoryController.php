<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{

    public function home()
    {
        $categories = Category::with('products')->get();

        return view('index', compact('categories'));
    }

    public function index(Request $request)
    {
        $categories = Category::get();
        if(!$request->ajax()){
            return view('categories.index', compact('categories'));
        }
        return response()->json(['categories'=> $categories], 200);
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories], 200);
    }

    public function store(CategoryRequest $request)
    {
        try{
            DB::beginTransaction();
            $category = new Category($request->all());
            $category->save();
            DB::commit();
            if(!$request->ajax()){
                return back()->with('success', 'category created');
            }
            return response()->json(['status'=> 'category created', 'category' => $category], 201);

        } catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }
    }


    public function show(Request $request, Category $category)

    {
        if (!$request->ajax()) {
            return view('categories.show', compact('category'));
        }
        return response()->json(['category' => $category], 200);
    }



    public function edit($id)
    {
        //
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try{
            DB::beginTransaction();
            $category -> update($request->all());
            DB::commit();
            if(!$request->ajax()){
                return back()->with('success', 'Category update');
            }
            return response()->json([], 204);

        } catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }
    }


    public function destroy(Request $request, Category $category)
    {
        $category -> delete();
        if(!$request->ajax()){
            return back()->with('succes', 'Category delete');
        }
        return response()->json([], 204);
    }
}
