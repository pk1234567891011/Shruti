<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Mail;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_details=Contact::latest()->paginate(10);
        return view('contact.index',compact('contact_details'));
    }
    
    public function search(Request $request){
        $search=$request->search;
        
        $contact_details=Contact::where('name','like','%'.$search.'%')->paginate(10);
        return view('contact.index',compact('contact_details'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $contact = Contact::find($id);
        return view('contact.reply',compact('contact'));
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
        $contact = Contact::find($id);
        $request->validate([

            'message'=>'required',
            
        ]);
        $messageData=[
            'reply'=>$request->message,
           
        ];
        $email=$contact->email;
            Mail::send('emails.reply', $messageData,function ($message) use ($email) {
                $message->to($email)->subject('Inquiry Reply');
            });
        return redirect()->route('contact.index')->with('success','Replied successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::find($id)->delete();
        return redirect()->route('contact.index')->with('success','Contact deleted successfully');
    }
}
