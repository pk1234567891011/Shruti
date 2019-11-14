<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use DB;
use File;
use Illuminate\Support\Facades\Input;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner=Banner::latest()->paginate(2);           
        return view('banner.index',compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner=Banner::all();
        return view('banner.create');
                
    }
    public function search(Request $request){
        $search=$request->search;
        
        $banner=Banner::where('status','like','%'.$search.'%')->paginate(2);
        return view('banner.index',compact('banner'));

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
            'image'=>'required|image',
            'status'=>'required'
        ]);
        $banner= new Banner();

        if( $request->hasFile('image')) {
            $image = $request->file('image');
            
            
            $filename = time() . rand().'.' . $image->getClientOriginalExtension();

            $path = '/image/'.$filename;

            $destinationpath = public_path(). '/image/';
            $image->move($destinationpath, $filename);

            $banner->banner_path = $path;
            $banner->status = $request->status;
        }


        $banner->save();

        return redirect()->route('banner.index')->with('success','banner added successfully');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('banner.edit',compact('banner'));
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
            
             'status'=>'required'
         ]);
         $banner = Banner::find($id);
        if($request->hasFile('image'))
        {
           
            $userImage = public_path().$banner->banner_path;
            
            
            if (File::exists($userImage)) 
            { 
                 unlink($userImage);
    
               
            }

            $image = Input::file('image');

            $filename = time() . rand().'.' . $image->getClientOriginalExtension();
            $path = '/image/'.$filename;

            $destinationpath = public_path(). '/image/';

            $image->move($destinationpath, $filename);
            $banner->banner_path = $path;
            $banner->status = $request->status;
        }
        $banner->save();
        Banner::find($id)->update($request->all());
        return redirect()->route('banner.index')->with('success','banner updated successfully');

    }
        
     

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = \DB::table('banner')->where('id', $id)->first();
        $file= $image->banner_path;
        $filename = public_path().$file;
        \File::delete($filename);
        Banner::find($id)->delete();
        return redirect()->route('banner.index')->with('success','banner deleted successfully');
    
    }
}
