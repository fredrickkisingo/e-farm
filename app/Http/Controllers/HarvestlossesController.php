<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Harvestlosses;
use App\User;
use DB;

class HarvestlossesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Harvestlosses::orderBy('created_at','desc')->paginate(10);
        return view('harvestlosses.index')->with('blogs',$blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('harvestlosses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=>'required',
            'body'=>'required',
          
            ]);
    
            //create Blog
     $blog= new Harvestlosses; //declaration of the object 'blog'
     $blog->title=$request->input('title');
     $blog->body=$request->input('body');
        $blog->save();
    return redirect('/harvestlosses')->with('success','Blog Uploaded');


        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Harvestlosses::find($id);
        return view('harvestlosses.show')->with('blog',$blog);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Harvestlosses::find($id);
        return view('harvestlosses.edit')->with('blog',$blog);
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
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
    ]);

        $blog= Harvestlosses::find($id);
        $blog->title=$request->input('title');
        $blog->body=$request->input('body');
        $blog->save();
        return redirect('/harvestlosses')->with('success','Blog Details Updated');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Harvestlosses::find($id);

        $blog->delete();
        return redirect('/harvestlosses')->with('success','Blog Removed');
    }
}
