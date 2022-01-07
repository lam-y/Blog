@extends('main')

@section('title', '| Create New Post')

@section('scripts')
<script src="jquery.js"></script>
<script src="{{ asset('parsley.min.js') }}" ></script>

@section('stylesheets')
<link href="{{asset('parsley.css')}}" rel="stylesheet">

	<!-- for editor api -->	
	<script src="//cdn.tinymce.com/4/tinymce.min.js" ></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			plugins: 'link',
			menubar: false,			
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
			  
		<h1>Create post</h1>
		<hr>
		
		<!-- Show errors when we add a new post -->
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
			
		<!-- The form-->
		<form method="POST" action='{{ route('post.store') }}' enctype="multipart/form-data" data-parsley-validate >		<!--route('post.store') -->
			@csrf  			
	   	
    		    <div class="form-group">
    		        <label for="title">Title *</label>
				<input type="text" class="form-control" name="title" value="{{ old('title')}}" required="" maxlength="255" />
				</div>

				<div class="form-group">
    		        <label for="category">Category </label>
					<select class="form-control" name="category">
						<option value="0"> </option>
						@foreach ($categories as $category)
							<option value="{{ $category->id }}">{{ $category->name }}</option>
						@endforeach	
					</select>					  
				</div>

				<div class="form-group">
    		        <label for="image">Image </label>
					<input type="file" class="form-control" name="image" accept="image/*" />
				</div>
		
    		    
    		    <div class="form-group">
    		        <label for="description">Post Body *</label>
					<textarea rows="10" class="form-control" name="body" ></textarea>
    		    </div>
    		    
    		    <div class="form-group">
    		        <p>* - required fields</p>
    		    </div>
    		    
    		    <div class="form-group">
    		        <button type="submit" class="btn btn-primary">
    		            Create
    		        </button>
    		        <a href="{{ route('post.index') }}" name="cancel" class="btn btn-default" >
    		            Cancel
					</a>
    		    </div>
    		    
            </form>
                   		
		</div>
	</div>
</div>

<hr>


@endsection
    
