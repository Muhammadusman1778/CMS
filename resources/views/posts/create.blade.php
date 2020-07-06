@extends('layouts.app')
@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{isset($post)?'Edit Post':'Create Post'}}
        </div>
        <div class="card-body">

            @include('partials.errors')

            <form action="{{isset($post)?route('posts.update',$post->id):route('posts.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($post))
                    @method('PUT')
                    @endif
                <div class="form-group">
                    <label for="title">Title</label>

                    <input type="text" class="form-control" name="title" id="title"  value="{{isset($post)?$post->title:''}}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>

                    <textarea name="description" id="description" cols="5" rows="5 " class="form-control">{{isset($post)?$post->description:''}}
                       </textarea>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content">{{isset($post)?$post->content:''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="published_at">Published At</label>
                    <input type="" class="form-control" name="published_at" id="published_at" value=" {{isset($post)?$post->published_at:''}}">
                </div>
                
                @if(isset($post))
                    
                    <div class="form-group">

                        <img src="{{asset($post->image)}}"  class="img-thumbnail" alt="">
                        
                    </div>
                    
                    
                    @endif

                <div class="form-group">
                    <label for="image">Image</label>

                    <input type="file" class="form-control" name="image" id="image" >
                </div>
                
                <div class="form-group">
                    
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">

                        @foreach($categories as $category)
                            <option value="{{$category->id}}"

                            @if(isset($post))

                            @if($category->id==$post->category_id)
                            selected
                                    @endif

                              @endif

                            >
                                {{$category->name}}
                            </option>
                         @endforeach
                    </select>
                    
                </div>

                  @if($tags->count()>0)
                <div class="form-group">

                    <label for="tags">Tag</label>
                    <select name="tags[]" id="tags" class="form-control tags-selector" multiple>
                        
                        @foreach($tags as $tag)

                            <option value="{{$tag->id}}"

                           @if(isset($post))

                           @if($post->hasTag($tag->id))

                           selected
                                    @endif

                                    @endif

                            >

                                {{$tag->name}}
                            </option>
                            
                            
                            @endforeach



                    </select>


                </div>

                @endif




                
                <div class="form-group">
                    <button class="btn btn-success">
                        {{isset($post)?'Edit Post':'Create Post'}}
                    </button></div>
            </form>

        </div>
    </div>
    @endsection
   @section('scripts')
       <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
       <script>
           tinymce.init({
               selector: '#content'
           });
       </script>
       <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


       <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
       <script>
           $(document).ready(function() {
               $('.tags-selector').select2();
           });

       </script>

   @endsection


    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    @endsection