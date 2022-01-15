<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Publisher;


class PublilshersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:ame');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = Publisher::all();
        return view('backend.pages.publishers.index', compact('publishers'));
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
        $request->validate([
            'name' => 'required|max:25',
            'link' => 'nullable|url',
            'description' => 'nullable',
        ]);

        $publishers = new Publisher();
        $publishers->name = $request->name;
        $publishers->link = $request->link;
        $publishers->address = $request->description;
        $publishers->outlet = $request->outlet;
        $publishers->description = $request->description;
        $publishers->save();
        session()->flash('success', 'A Publishers Created Success');

        return back();
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
        //
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
            'name' => 'required|max:25',
            'link' => 'nullable|url',
            'description' => 'nullable',
        ]);

        $publishers = Publisher::find($id);
        $publishers->name = $request->name;
        $publishers->link = $request->link;
        $publishers->address = $request->description;
        $publishers->outlet = $request->outlet;
        $publishers->description = $request->description;
        $publishers->save();
        session()->flash('success', 'A Publishers Updated Success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $publishers =  Publisher::find($id);
        $publishers->delete();
        session()->flash('success', 'A Publishers Deleted Success');

        return back();
    }
}
