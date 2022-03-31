<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>course rating</title>
     <link href="{{ asset('css/app.css') }}" media="all" rel="stylesheet" type="text/css" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
<body>

 <div class="container">
          
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div>
    @endif
  
    <h2>Course Ratings for {{ $course->name }}</h2>
    <div class=topPage>
      <form>
          {{ csrf_field() }}
          <label>Items Per Page</label>
          <select id="pagination" >
              <option value="5" @if($items == 5) selected @endif >5</option>
              <option value="10" @if($items == 10) selected @endif >10</option>
              <option value="25" @if($items == 25) selected @endif >25</option>
          </select>
        </form> 
        {{ $rating->appends(compact('items'))->onEachSide(1)->links() }}
    </div>
    <br>
    
    
    <div class="row"> 
      <div class="col-md-9">
          <a title='Add Course Rating' data-toggle='tooltip' href="/ratings/create" span class='fas fa-plus-square'style='font-size: 3em; color:green'></span></a>
       </div>
       <div class="col-md-3">
       <a href="/courses" class="btn btn-warning">Back to Courses</a>
        </div>
      </div>
 
    @include('course_ratings.modal')
    <table class="table table-bordered table-striped table-hover category-table" data-toggle="dataTable" data-form="deleteForm">
        <tr style='font-size: 10; color:green'>
         
            <th width="80px">Tee</th>
            <th width="90px">Slope</th>
            <th width="100px">Rating</th>
            <th width="100px">Yardage</th>
            <th width="40px">Edit</th>
            <th width="40px">Del.</th>
        </tr>
        @if($rating->count())
            @foreach($rating as $rating)
                <tr>
                  
                    <td>{{$rating->tee}}</td>
                    <td>{{$rating->slope}}</td>
                    <td>{{$rating->rating}}</td>
                    <td>{{$rating->yardage}}</td>
                    <!-- EDIT button -->
                    <td align="left"><a title='Edit Rating' data-toggle='tooltip' href="{{action('CourseRatingController@edit', $rating->id)}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
                    
                    <!-- DELETE button -->                
                    <td align="left">
                    {!! Form::model($rating, ['method' => 'delete', 'route' => ['ratings.destroy', $rating->id], 'class' =>'form-inline form-delete']) !!}
                    {!! Form::hidden('id', $rating->id) !!}
                    {!! Form::button('<i class="fa fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-critical btn-sm delete', 'style' => 'color:red', 'name' => 'delete_modal'] )  !!}
                    {!! Form::close() !!}
                    </td>
                    
                </tr>
            @endforeach

        @endif
    </table>
 </div> <!-- container / end -->

</body>

<script>
  // pagination script
    document.getElementById('pagination').onchange = function() { 
        window.location = "{{URL::route('courserating')}}?items=" + this.value; 
    }; 
</script>

<script type="text/javascript">
// delete modal
  $(document).ready(function () {
       $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
           e.preventDefault();
           var $form=$(this);
           $('#confirm').modal({ backdrop: 'static', keyboard: false })
                   .on('click', '#delete-btn', function(){
                       $form.submit();
                   });
       });
   });
</script>

</html>
@endsection