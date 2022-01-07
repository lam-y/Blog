@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
       <div class="col-md-12">
           <h3>All Categories ({{$categories->count()}})</h3>
       </div>
   </div>
   <br>

   <!-- Show Success message when we update a category successfuly -->
   @if ($message = Session::get('success'))
   <div class="alert alert-success">
       <p>{{ $message }}</p>
   </div>
   @endif

   <!--   Categories table  -->
   <div class="row col-md-12">
    <div class="col" style="margin-right: 65px">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>            
                <th scope="col"> Operations</th>
              </tr>
            </thead>
            <tbody>
                 <!-- Show all categories -->
                  @foreach($categories as $category)   
                    <tr>
                    <td scope="row" style="width:20%"> {{ $category->name }}</td>                   
                    <td style="width:20%">
                    
                    <!-- Edit button -->
                    <a href="#" class="btn btn-outline-success btn-sm" id="editBtn" data-toggle="modal" data-target="#editModal">Edit</a>

                        <!-- open edit dialog or edit modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">                           
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form id="editForm" action="#" >  
                                    @csrf    
                                    @method('PUT')    
                                    <div class="form-group">
                                      <label for="name-text" class="col-form-label">Name: </label>
                                      <input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}">                                     
                                      <input type="text" class="form-control" name="newName" id="newName" value="{{ $category->name }}">
                                    </div>                                  
                                    </div>

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                
                                      <button type="submit" id="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </form>                                  
                              </div>
                            </div>                        
                          </div>
                   
                        
                        <!-- Delete button --> 
                        <form action="{{ route('categories.destroy', $category->id) }}" method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category?')">
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

<!--  -->
             
       
<!--  -->


    
           <!-- Another Div for Add New Category -->
           <div class="col-md-4" style="background-color: rgb(248, 248, 165); padding: 25px; height: 200px">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf 
                <h3 style="margin-bottom: 15px; text-align: center">New Category</h3>               
                    <label>Name: </label>
                    <input type="text" name="name" />
                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 15px"> Add </button>
            </form>
         </div>

   </div>

   

</div> 

<!-- -------------------------------------------------------------------------------------- -->
@section('script')
  <script>

    $(document).ready(function(){

      $(document).on("click", "#submit", function (e) {
        e.preventDefault();

        var id = $('#category_id').val();
        //var category_id = $(this).attr('category_id').val();
        var url = "{{ route('categories.update', "+id+") }}";

          $.ajax({
            url: url,
            type: 'PUT',
            data: {
              _token:'{{ csrf_token() }}',
               name : $('#newName').val(),
            },
            success: function (response) {
              console.log(response);
              alert("Data Updated");
              window.location.reload();
            },
            error:function(error){
              console.log(error);
            }
          });
        });
    });

  </script>
@endsection

@endsection