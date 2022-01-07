@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
       <div class="col-md-10">
           <h3>All Comments ({{$comments->count()}}) </h3>
       </div>
   </div>
   <br>

   <div class="col-md-12">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">post</th>
            <th scope="col">name</th>
            <th scope="col">email</th>
            <th scope="col">comment</th>            
            <th scope="col">created at</th>
            <th scope="col"> Operations</th>
          </tr>
        </thead>
        <tbody>
             <!-- Show all posts -->
            @foreach($comments as $comment)   
                <tr>
                    <td scope="row" style="width:15%"> <a href='{{route('post.show', $comment->post_id)}}'> {{$comment->title}}</a> </td> 
                    <td> {{ $comment->name }} </td>
                    <td style="width:15%"> {{ $comment->email }} </td>
                    <td style="width:30%">{{ $comment->comment }} </td>                    
                    <td>{{ $comment->created_at }}</td>
                    <td style="width:20%">                        
                        @if ($comment->approved == 0)
                            <!-- Approve button -->
                            <a href="{{ route('comment.approve', $comment->id) }}" class="btn btn-outline-info btn-sm">Approve</a>

                            <!-- Decline button --> 
                            <form action="{{ route('comment.delete', $comment->id) }}" method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                @csrf  	
                                @method('DELETE') 
                                <button class="btn btn-outline-dark btn-sm">Decline</button> 
                            </form>

                        @else 
                            <!-- Decline button --> 
                            <form action="{{ route('comment.delete', $comment->id) }}" method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                @csrf  	
                                @method('DELETE') 
                                <button class="btn btn-outline-danger btn-sm">Delete</button> 
                            </form>
                        @endif

                       
                       
                        
                    </td>
                </tr>
            @endforeach           
        </tbody>
      </table>
   </div>
    

      <!-- Pagination -->
      <div class="pagination justify-content-center">
        {!! $comments->links() !!}
      </div>

</div>

@endsection