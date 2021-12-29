<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  //http://127.0.0.1:8000/api/main
    {
        return 'hi from index in mycontroller -r';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()        //http://127.0.0.1:8000/api/main/create  (get)
    {
        return 'hi from create in mycontroller -r';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)  //http://127.0.0.1:8000/api/main  (post)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)    //http://127.0.0.1:8000/api/main/{id}
    {
        return 'hi from show in mycontroller -r {{$id}}';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)    //http://127.0.0.1:8000/api/main/{id}/edit
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)   //http://127.0.0.1:8000/api/main/{id}
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)    //http://127.0.0.1:8000/api/main/{id}
    {
        //
    }
}
