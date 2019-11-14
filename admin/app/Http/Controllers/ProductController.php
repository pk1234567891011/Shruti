<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_images;
use DB;
use Illuminate\Http\Request;
use App\Product_attributes;
use App\Product_attribute_values;
use App\Category;
use App\Product_categories;
use App\Product_attributes_assoc;
use File;
use Image;
use Auth;
use Illuminate\Support\Facades\Input;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::latest()->paginate(2);
        $multiple = Product::has('imgs')->get();
        return view('product.index', compact('product', 'multiple'));
    }
    public function search(Request $request){
        $search=$request->search;
        $multiple = Product::has('imgs')->get();

        $product=Product::where('name','like','%'.$search.'%')->paginate(2);
        return view('product.index', compact('product', 'multiple'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::all();
        $category = Category::where('parent_id','!=',0)->get();
        $attributes = Product_attributes::pluck("name","id");
        return view('product.create',compact('attributes','category'));
    }
    public function myformAjax($id){
        
        $values = Product_attribute_values::where("product_attribute_id",$id)->pluck("attribute_value","id");
        return json_encode($values);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'sku' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'price' => 'required|numeric',
            'special_price' => 'required|numeric',
            'special_price_from' => 'required',
            'special_price_to' => 'required|after_or_equal:special_price_from',
            'status' => 'required',
            'quantity' => 'required|numeric',
            'meta_description' => 'required',
            'meta_title' => 'required',
            'meta_keywords' => 'required',
            'is_featured' => 'required',
            'CID'=>'required',
            'names'=>'required',
          
        ]);
       
        Product::create($request->all());
        $user = auth()->user();
       
        $product = Product::select('*')->orderBy('id', 'DESC')->first();
        $category=new Product_categories();
        $category->product_id=$product->id;
        $category->category_id=$request->CID;
        
       
        $category->save();
        if ($request->hasFile('names')) {
            $image = $request->file('names');
            $object = new Product_images();
            $filename = $image->getClientOriginalName();
            $image->move(public_path() . '/products/', $filename);
            $object->image_name = $filename;
            $object->status = $product->status;
            $object->created_by = $user->id;
            $object->product_id = $product->id;
            $object->save();
        
        }
        $att = $request->drop;
        $val = $request->value;
        for($count = 0; $count < count($att); $count++)
        {
            $data = array(
                'product_attribute_id' => $att[$count],
                'product_attribute_value_id'  => $val[$count],
                'product_id'=>$product->id
            
                );
            $insert_data[] = $data; 
        }
  
        Product_attributes_assoc::insert($insert_data);
       return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function first()
    {   
        $category=Category::with('children')->get();
        $sliders = Banner::orderby('id', 'desc')->paginate(10);
        return view('Eshopper.first',compact('sliders','category'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::find($id);
        $multiple = Product::has('imgs')->get();
        $categories=Category::where('parent_id','!=',0)->get();
        $product_categories=Product_categories::where('product_id',$id)->first();
        return view('product.edit',compact('product','multiple','categories','product_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => 'required',
            'sku' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'price' => 'required',
            'special_price' => 'required',
            'special_price_from' => 'required',
            'special_price_to' => 'required',
            'status' => 'required',
            'quantity' => 'required',
            'meta_description' => 'required',
            'meta_title' => 'required',
            'meta_keywords' => 'required',
            'is_featured' => 'required',
            'CID'=>'required'
           
        ]);
        $user = auth()->user();
        $product_images= Product_images::where('product_id',$id)->first();
        $product=Product::find($id)->first();
        $category_details=Product_categories::where('product_id',$id)->first();
        $category_details->category_id=$request->CID;
        $category_details->save();
        if($request->hasFile('names'))
        {
           
            $userImage = public_path() . '/products/'.$product_images->image_name;
            
            
            if (File::exists($userImage)) 
            { 
                unlink($userImage);
    
               
            }
            $image = $request->file('names');
            $filename = $image->getClientOriginalName();
            $image->move(public_path() . '/products/', $filename);
            
            $product_images->image_name = $filename;
            $product_images->status = $product->status;
            $product_images->created_by = $user->id;
            $product_images->product_id = $id;
            $product_images->save();
        }

        Product::find($id)->update($request->all());
        return redirect()->route('product.index')->with('success','Product updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assoc=Product_attributes_assoc::where('product_id',$id)->first();
        $value=Product_attributes::where('id',$assoc->product_attribute_id)->first();
        $image =Product_images::where('product_id', $id)->first();
        $file= $image->image_name;
        $filename = public_path(). '/products/'.$file;
        \File::delete($filename);
        Product_images::where('product_id', $id)->delete();
        Product_categories::where('product_id', $id)->delete();
        Product_attributes_assoc::where('product_id',$id)->delete();
        Product::find($id)->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
