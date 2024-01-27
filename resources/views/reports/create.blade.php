<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>Clubs</title>
     <link href="{{ asset('css/app.css') }}" media="all" rel="stylesheet" type="text/css" />
   
    <!-- using font-awesome (free/solid) icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">
    
     <!-- Latest compiled and minified CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    
     <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
<body>

 <div class="container">
          
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div>
    @endif

    @if (!empty($alertMsg))
      <div class="alert alert-danger">
        <p>{{ $alertMsg }}</p>
      </div>
    @endif
  
    <h2> New Score </h2>
    
    
    <form method="post" action="{{action('ScoreController@store')}}">
        @csrf
        <div class="row">      
            <div class="form-group col-md-4">
            <label for="course">Course:</label>
            <select name="course" class="form-control" id="mySelect" >
              <option value="">--Select Course--</option>
                @foreach ($course as $course => $value)
                  <option > {{ $value }}</option>   
                @endforeach
            </select>
            </div>
            <div class="form-group col-md-4">
              <label for="date_played">Date:</label>
              <input type="date" class="form-control" name="date_played" required ></input>
            </div>
            <div class="form-group col-md-4">
              <label for="score">score:</label>
              <input type="number" class="form-control" name="score" min="0" max="120" required ></input>
            </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
          <label for="tee">Tee:</label>
            <select name="tee" class="form-control">
              <option value="tee">--Select Tee--</option>
                
            </select>
          </div>
          <div>
             <input type="hidden" id ="courseTee" name="courseTee">
          </div>
          <div class="form-group col-md-4">
            <label for="holes">Holes:</label>
            <input type="number" class="form-control" name="holes" value = "18" required ></input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="/scores" class="btn btn-warning">Back to Scores</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

<script type="text/javascript">
  jQuery(document).ready(function()
  {
    jQuery('select[name="course"]').on('change',function() {
      
     var courseName = jQuery(this).val();
     if (courseName)
      {
        var cid = null;
        jQuery.ajax({
          url : '/scores/getCourseID/' +courseName,
          type : "GET",
          dataType : "json",
          success:function(data)
          {
            cid = data;
            jQuery.ajax({
              url : '/scores/getTee/' +cid,
              type : "GET",
              dataType : "json",
              success:function(data)
              {
                jQuery('select[name="tee"]').empty();
                jQuery.each(data, function(key,value) {
                  $('select[name="tee"]').append('<option value="'+ key + '">'+ value +'</option>');
                  var y = value;
                  document.getElementById('courseTee').value = y;
                });   
                if (!$.trim(data)){   
                  //alert("What follows is blank: " + data);
                  Swal.fire("Whoa!", 'You must add Course Ratings first - GO BACK', "warning");
                }
              }
            }); 
          }
        });
      }
        else
        {
          $('select[name="tee"]').empty();

        }
      });
  });    

  </script>

</body>

</html>
@endsection