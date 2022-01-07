@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
       <div class="col-md-10">
       <h3>All Posts ({{ $posts->count() }})</h3>
       </div>
   </div>
   <br>

   <div class="col-md-12">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Post</th>
            <th scope="col">created at</th>
            <th scope="col"> Operations</th>
          </tr>
        </thead>
        <tbody>
             <!-- Show all posts -->
            @foreach($posts as $post)   
                <tr>
                    <td scope="row" style="width:20%">
                      <a href='{{route('post.show', $post->id)}}'>
                        {{$post->title}}
                      </a>
                    </td>
                    <td style="width:50%">{!!  substr(strip_tags($post->body), 0, 200) !!} {{ strlen(strip_tags($post->body)) > 200 ? "..." : "" }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td style="width:20%">
                        <!-- Edit button -->
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-outline-success btn-sm">Edit</a>
                       
                        <!-- Delete button --> 
                        <form action='{{ route('post.destroy', $post->id) }}' method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf  	
                            @method('DELETE') 
                             <button class="btn btn-outline-danger btn-sm">Delete</button> 
                        </form>
                    </td>
                </tr>
            @endforeach           
        </tbody>
      </table>
   </div>
    

      <!-- Pagination -->
      <div class="pagination justify-content-center">
        {!! $posts->links() !!}
      </div>

</div>

@endsection