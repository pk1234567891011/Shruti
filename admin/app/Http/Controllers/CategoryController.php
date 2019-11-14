<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Category;
use App\Product_attributes;
use App\Product_attribute_values;
use App\Product;
use App\Product_images;
use App\Product_categories;
use App\Product_attributes_assoc;
class CategoryController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
    public function index()
    {
        $categories=Category::select('category.id','category.name','category.status','category.parent_id','c2.name as parent_name')
                            ->leftjoin('category as c2','category.parent_id','=','c2.id')
                            ->paginate(4);

        return view('category.index',compact('categories','categorys','categorys','category'));

    }

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
    public function create()
    {
        $category=Category::all();
        return view('category.create',compact('category'));
    }

    
    public function search(Request $request){
        $search=$request->search;
        $categories=Category::select('category.id','category.name','category.status','category.parent_id','c2.name as parent_name')
                            ->leftjoin('category as c2','category.parent_id','=','c2.id')
                            ->where('category.name','like','%'.$search.'%')
                            ->paginate(4);
        
       
        return view('category.index',compact('categories'));

    }
/**
* Store a newly created resource in storage.
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/
    public function store(Request $request)
    {
        $request->validate([

            'name'=>'required',
            'status'=>'required',
            'parent_id'=>'required'
        ]);
        $name=strtoupper($request->name);
        $category=new Category();
        $category->name=$name;
        $category->status=$request->status;
        $category->parent_id=$request->parent_id;
        $category->save();
       
        return redirect()->route('category.index')->with('success','Category created successfully');
    }


/**
* Display the specified resource.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
    public function show($id)
    {
    //
    }

/**
* Show the form for editing the specified resource.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
    public function edit($id)
    {
        $categories=Category::where('id','=',$id)->first();
        $category = Category::find($id); 
        $categoryDetails=Category::where('id',$id)->first();
        $level=Category::where('parent_id',0)->get();
        return view('category.edit',compact('category','categories','categoryDetails','level'));
    }

/**
* Update the specified resource in storage.
*
* @param \Illuminate\Http\Request $request
* @param int $id
* @return \Illuminate\Http\Response
*/
    public function update(Request $request, $id)
    {
        $data=$request->all();
            
        $category = Category::find($id);
        $request->validate([

            'name'=>'required',
            'status'=>'required'
        ]);
        $name=strtoupper($request->name);
        Category::find($id)->update(['name'=>$name,'status'=>$request->status]);
        return redirect()->route('category.index')->with('success','Category updated successfully');
    }

/**
* Remove the specified resource from storage.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
    public function destroy($id)
    {
        $category_id=Product_categories::where('category_id',$id)->first();
        if(empty($category_id)){
        Product_categories::where('category_id',$id)->delete();
        Category::where('parent_id',$id)->delete();
        Category::where('id',$id)->delete();
        }
        else{
        $product=Product::where('id',$category_id->product_id)->first();
        $product_attribute_assoc=Product_attributes_assoc::where('product_id',$product->id)->first();
        Product_attributes_assoc::where('product_id',$product->id)->delete();
        Product_categories::where('category_id',$id)->delete();
        Product_images::where('product_id',$product->id)->delete();
        Category::where('id',$id)->delete();
        Product::where('id',$category_id->product_id)->delete();
        }
        return redirect()->route('category.index')->with('success','Category deleted successfully');
    }

}