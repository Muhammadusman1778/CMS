<?php

namespace App\Http\Controllers;
use App\Category;
use App\Http\Requests\Posts\UpdatePostRequest;
use  App\Post;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Middleware;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create','store']);
    }


    public function index()
    {
        return view('posts.index')->with('posts',Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories',Category::all())->with('tags',Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePostRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
      $product_image=$request->image;
      $product_image_new_name=time().$product_image->getClientOriginalName();
      $product_image->move('uploads/posts/',$product_image_new_name);

          $post= Post::create([
          'title'=>$request->title,
          'description'=>$request->description,
          'content'=>$request->content,
          'image'=>'uploads/posts/'.$product_image_new_name,
          'published_at'=>$request->published_at,
          'category_id'=>$request->category,
               'user_id'=>auth()->user()->id
      ]);

       if($request->tags){
           $post->tags()->attach($request->tags);
       }

        session()->flash('success','Post created successfully');

        return redirect(route('posts.index'));
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
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Post $post)

    {
        return view('posts.create')->with('post',$post)->with('categories',Category::all())->with('tags',Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data=$request->only(['title','description','published_at','content']);

        //check if new image

        if($request->hasFile('image')){
            $image=$request->image->store('uploads','public');
            //delete old one
            $post->deleteImage();
            $data['image']=$image;
        }
        if($request->tags){
            $post->tags()->sync($request->tags);
        }
        //update attributes

        $post->update($data);

        //flash message
        session()->flash('success','Post updated successfully');

        //redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {     $post=Post::withTrashed()->where('id',$id)->firstorFail();
        if ($post->trashed()){

        $post->forceDelete();
            $post->deleteImage();
    }
        else{
            $post->delete();}
        session()->flash('success','Post deleted successfully');
        return redirect(route('posts.index'));
    }

    public function trashed( )
    {
       $trashed=Post::onlyTrashed()->get();
       return view('posts.index')->withPosts($trashed);
    }
    public function restore($id)
    { $post=Post::withTrashed()->where('id',$id)->firstorFail();
          $post->restore();

        session()->flash('success','Post restored successfully');

          return redirect()->back();

    }

}
