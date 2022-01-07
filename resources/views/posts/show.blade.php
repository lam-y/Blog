@extends('main')

@section('title', '| '. $post->title)

@section('content')  

<!----------------------------------- Page Header ------------------------------------------------>
  <header class="masthead" style="background-image: url('{{ asset('img/post-bg.jpg') }}')">    <!-- منرجعلها وقت نخزن صور -->
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-heading" style="text-align: center;">
            <h1>{{$post->title}}</h1> 
            <br>         
            <span class="meta">Posted on:  {{$post->created_at}}</span>
            <br>
            <span class="meta"> @if($post->category_id != null)  Posted in: {{$post->category->name}}  @endif </span>  
          </div>
        </div>
      </div>
    </div>
  </header>


  <!---------------------------------- Main Content ------------------------------------------------>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">

        <!-- Show Success message when we add new post successfuly -->    <!-- عم يطالع الرسالة وقت بضغط على زر cancel -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif    
         
        <!------------------------------- post body ---------------------------------------------->
        @if($post->image != null)
          <div style="text-align: center;">
            <img src="{{ asset('images/' . $post->image) }}" />
          </div>
        @endif
                
        <p>
          {!! $post->body !!}
        </p>
                
        
      <!---------------------------- Edit and Delete buttons in show.blade -------------------------------------->      
      <br>
      <br>      
      @if(Auth::user())

      <!-- Edit button -->
        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-link btn-sm">
          <i class="fa fa-edit"></i>
            Edit
        </a>

        <!-- Delete button --> 
        <form action='{{ route('post.destroy', $post->id) }}' method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?')">
          @csrf  	
          @method('DELETE')
          <button class="btn btn-link btn-sm"> 
            <i class="fa fa-trash"></i>    
             Delete
          </button>      
        </form>        
        @endif    

  <!--------------------------------- Show Comments ----------------------------------------------->

        <!-- Show Comments -->
        <hr>
        <div class="row">
          <div class="col-md-8 ">
            <h3 style="margin-bottom: 40px"><span class="glyphicon glyphicon-comment"></span> Comments ({{$post->comments->where('approved', '=', '1')->count()}}) </h3>    
           
            @foreach ($post->comments as $comment)
              @if($comment->approved == 1)
                <div class="comment">
                  <div class="author-info">
                  <img class="comment-image" src="{{ asset('img/default-user-image.jpg') }}" />
                    <div class="comment-author-name">
                      <h4>{{ $comment->name }}</h4>
                      <p class="comment-time"> {{ $comment->created_at }}</p>                
                    </div>
                  </div>
    
                  <div class="comment-content">
                    {{ $comment->comment }}
                  </div>

                </div>
              @endif            
            @endforeach
          </div>
        </div>


        <!--------------------------------- Add a Comment form ----------------------------------------------->
        <hr>
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-8">
              <br>
              <h3><span class="glyphicon glyphicon-comment"></span> Add a comment </h3>
              <br>
              <form method="POST" action="{{ route('comment.store', $post->id) }}" enctype="multipart/form-data" data-parsley-validate >
                @csrf

                <div class="form-row ">
                  <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="name" placeholder="Name" required="" maxlength="255">
                  </div>
                  <div class="form-group col-md-6">
                    <input type="email" class="form-control" name="email" placeholder="Email" required="" maxlength="255" data-parsley-type="email">
                  </div>
                </div>

                <div class="form-row ">
                  <div class="form-group col-md-12">
                    <textarea rows="3" class="form-control" name="comment" placeholder="Comment" required="" maxlength="2000"></textarea>
                  </div>
                </div>

                <div class="form-row">
                  <button type="submit" class="btn btn-primary btn-sm">
                      submit
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>  
        
        <!--------------------------------- End Add a Comment form ----------------------------------------------->

      </div>
    </div>
  </div>

<hr>

@endsection 