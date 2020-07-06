<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagsRequest;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index')->with('tags',Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTagRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {

        Tag::create([
            'name'=>$request->name
        ]);
        session()->flash('success','Tag created successfully');
        return redirect(route('tags.index'));

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
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Tag $Tag
     * @internal param int $id
     */
    public function edit(Tag $tag)
    {
        return view('tags.create')->with('tag',$tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTagsRequest|Request $request
     * @param Tag $Tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateTagsRequest $request, Tag $tag)
    {
        $tag->update([
            'name'=>$request->name
        ]);
        session()->flash('success','Tag updated successfully');
        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     * @internal param Tag $Tag
     * @internal param int $id
     */
    public function destroy(Tag $tag)
    {   if($tag->posts->count()>0){

        session()->flash('error','Tag can not be deleted beacuse it is asscoiated with post');

        return redirect()->back();
    }
        $tag->delete();
        //session
        session()->flash('success','Tag deleted successfully');
        //
        return redirect(route('tags.index'));

    }
}
