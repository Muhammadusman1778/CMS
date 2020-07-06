<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoriesRequest;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')->with('categories',Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCategoryRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {

        Category::create([
            'name'=>$request->name
        ]);
       session()->flash('success','Category created successfully');
        return redirect(route('categories.index'));

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
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param int $id
     */
    public function edit(Category $category)
    {
        return view('categories.create')->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoriesRequest|Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateCategoriesRequest $request, Category $category)
    {
        $category->update([
            'name'=>$request->name
        ]);
        session()->flash('success','Category updated successfully');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Category $category)
    {
        if($category->posts->count()>0){

            session()->flash('error','Category can not be deleted beacuse it is asscoiated with post');

            return redirect()->back();
        }
        $category->delete();
        //session
        session()->flash('success','Category deleted successfully');
        //
        return redirect(route('categories.index'));

    }
}
