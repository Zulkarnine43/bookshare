<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Author;





class AuthorsController extends Controller
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
        $authors = Author::all();
        return view('backend.pages.authors.index', compact('authors'));
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
            'description' => 'nullable|min:5',
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->link = str_slug($request->name);
        $author->description = $request->description;
        $author->save();
        session()->flash('success', 'Author Created Success');

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
            'description' => 'nullable|min:5',
        ]);


        $author =  Author::find($id);
        $author->name = $request->name;
        // $author->link = str_slug($request->name);
        $author->description = $request->description;
        $author->save();
        session()->flash('success', 'Author Updated Successfully ');
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
        $author =  Author::find($id);
        $author->delete();
        return back();
    }
}
