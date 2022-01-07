@extends('main')

@section('title', '| Homepage')

@section('content')    

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('{{ asset('img/book-bg.jpg') }}')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>مدونة مما قرأت</h1>
            <span class="subheading">اقرأ وارتقِ</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        
      <!-- Show Success message when we delete a post successfuly -->
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
          <p>{{ $message }}</p>
      </div>
      @endif

      <!-- Show all posts -->
      @foreach($posts as $post)    
        <a href='{{route('post.show', $post->id)}}'>    
            <h2 class="post-title" style="text-align:right;" >
                {{$post->title}}
            </h2>
        </a>

        <p class="post-meta" style="color: rgb(156, 162, 168); text-align:right; margin-top: 5px"> @if($post->category_id != null)  التصنيف:  {{$post->category->name}}  @endif </p>

        <div class="post-preview">
          @if($post->image != null)
            <div style="text-align: center;">
              <img src="{{ asset('images/' . $post->image) }}" />
            </div>
          @endif

        
            <p>
               {!!  substr($post->body, 0, 500) !!} {{ strlen(strip_tags($post->body)) > 500 ? "..." : "" }}
               <br>
               <br>
               <a type="button" href='{{route('post.show', $post->id)}}' class="btn btn-light" style="text-align: right;" dir="rtl">أكمل القراءة..</a>      
            </p>                            

          <p class="post-meta">Posted on {{$post->created_at}} </p>
        </div>
        <hr>
      @endforeach

      </div>
    </div>

     <!-- Pagination -->
     <div style="text-align: center">
      <div class="pagination justify-content-center">
        {!! $posts->links() !!}
      </div>
     </div>

  </div>
    
  <hr>

  
  @endsection
