<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use Illuminate\Http\Request;
use Session;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Send Request
    public function store(Request $request)
    {
        $data = $request->all();
        $senderID = $data['senderID'];
        $receiverID = $data['receiverID'];

        // Store the data in Requests table
        $request = new RequestModel;
        $request->sender_id = $senderID;
        $request->receiver_id = $receiverID;
        
        if($request->save()){
            Session::flash('success_message', 'Request Sent.');
        }
        else{
            Session::flash('error_message', 'Something went wrong. Try again.');
        }

        return true;
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Accept Request
    public function update(Request $request, $id)
    {
        if(RequestModel::where('id', $id)->update(['accepted'=> 1])){
            Session::flash('success_message', 'Request Accepted.');
        }
        else{
            Session::flash('error_message', 'Something went wrong. Try again.');
        }

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Withdraw Request
    public function destroy($id)
    {
        if(RequestModel::where('id', $id)->delete()){
            Session::flash('success_message', 'Request Deleted.');
        }
        else{
            Session::flash('error_message', 'Something went wrong. Try again.');
        }

        return true;
    }
}
