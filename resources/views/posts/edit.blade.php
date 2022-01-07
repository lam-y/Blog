@extends('main')

@section('title', '| Edit Post')

@section('scripts')
  {{Html::script('js/parsley.min.js')}}


@section('stylesheets')
  {{Html::style('css/parsley.css')}}
  <!-- for editor api -->	
	<script src="//cdn.tinymce.com/4/tinymce.min.js" ></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			plugins: 'link',
			menubar: false
		});
  </script>
  
@endsection

@section('content') 

<!-- Page Header -->
<header class="masthead" style="background-image: url('{{ asset('img/post-bg.jpg') }}')">
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
	    <div class="col-md-8 col-md-10 mx-auto">
			  
            <h1>Edit post</h1>
			<hr>
			
			@if ($errors->any())
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
            
            <form method="POST" action='{{ route('post.update',$post->id) }}' enctype="multipart/form-data">
                @csrf  	
                @method('PUT')

                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" class="form-control" name="title" data-parsley-required="true" value= "{{$post->title}}" />                        
                    </div>

                    <div class="form-group">
                      <label for="category">Category </label>
                      <select class="form-control" name="category" selected="{{ $post->category_id }}">
                        <option value="0"> </option>
                        @foreach ($categories as $category)
                      <option value="{{ $category->id }}" {{ ($category->id == $post->category_id) ? 'selected' : '' }}> {{ $category->name }}</option>
                        @endforeach	
                      </select>					  
                  </div>
            
                    <div class="file-loading">
                      <label for="title">Image</label>  
                    <img src="{{ asset('images/' . $post->image) }}" width="150" height="150" alt="" />             
                      <input type="file" class="form-control" name="image" accept="image/*" class="form-control"  value="{{$post->image}}" />
                    </div>
                    
                    <br>
                    <div class="form-group">
                        <label for="description">Post Body *</label>
                        <textarea rows="5" class="form-control" name="body" data-parsley-required="true" >{{$post->body}}</textarea>                        
                    </div>
                    
                    <div class="form-group">
                        <p>* - required fields</p>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                        <a href="{{ route('post.show', $post->id) }}" name="cancel" class="btn btn-default" >
                            Cancel
                        </a>
                    </div>
                    
                </form>
                   		
		</div>
	</div>
</div>

<hr>

@endsection
    
