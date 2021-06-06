<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\postponed;
class PostponedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\postponed  $postponed
     * @return \Illuminate\Http\Response
     */
    public function show(postponed $postponed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\postponed  $postponed
     * @return \Illuminate\Http\Response
     */
    public function edit(postponed $postponed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\postponed  $postponed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, postponed $postponed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id=null)
    {
        //
        //$id = $request->Banckcheck_id;
        if($request->postponed_id){
            $status = postponed::where('id',$request->postponed_id)->delete();           
            return response()->json(array('status'=>$status));
        }
    }
}
