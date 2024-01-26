<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;

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
            return view('categories.index');
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
            $category->assignRole($request->input('role'));
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


    public function show(Request $request, User $user)
{
        if (!$request->ajax()) {
            return view('users.show', compact('user'));
        }
        return response()->json(['user' => $user], 200);
}



    public function edit($id)
    {
        //
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category -> update($request->all());
        if(!$request->ajax()){
            return back()->with('success', 'Category updated');
        }
        return response()->json([], 204);
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
