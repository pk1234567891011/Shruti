<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cms;
class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cms_details=cms::latest()->paginate(5);
        return view('cms.index',compact('cms_details'));
    }

    public function search(Request $request){
        $search=$request->search;
        
        $cms_details=cms::where('title','like','%'.$search.'%')->paginate(2);
        return view('cms.index',compact('cms_details'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.create');
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
            'title'=>'required',
            'url'=>'required',
            'description'=>'required',
            'status'=>'required'
        ]);
        cms::create($request->all());
        return redirect('cms')->with('success', 'Cms created successfully');;

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
       $cms=cms::find($id);
       return view('cms.edit',compact('cms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $request->validate([
            'title'=>'required',
            'url'=>'required',
            'description'=>'required',
            'status'=>'required|numeric'
        ]);
        cms::find($id)->update($request->all());
        return redirect('cms')->with('success', 'Cms updated successfully');;
    }

    public function cmsPage($url)
    {
        $cmsCount=cms::where(['url'=>$url,'status'=>1])->count();
        if($cmsCount>0){
            $cms_details=cms::where('url',$url)->first();

        }
        else{
            abort(404);
        }
        return view('cms.cms_pages',compact('cms_details'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        cms::find($id)->delete();
        return redirect()->back()->with('success', 'Cms deleted successfully');;

    }
}
