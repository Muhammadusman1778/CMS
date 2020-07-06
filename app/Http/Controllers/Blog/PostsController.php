<?php

namespace App\Http\Controllers\Blog;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * @param Post $post
     * @return view
     */
    public function show(Post $post){

        return view('blog.show')->with('post',$post);
    }

    /**
     * @param Category $category
     *@
     * @return view
     */

    public function category(Category $category){

        return view('blog.category')
            ->with('category',$category)
            ->with('posts',$category->posts()->searched()->simplePaginate(3))
            ->with('categories',Category::all())
            ->with('tags',Tag::all())
            ;

    }

    /**
     * @param Tag $tag
     * @return view
     */
    public function tag(Tag $tag){

        return view('blog.tag')
            ->with('tag',$tag)->
            with('posts',$tag->posts()->searched()
                    ->simplePaginate(3))
            ->with('categories',Category::all())
            ->with('tags',Tag::all());

    }

}
