<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>Clubs</title>
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
        
    <form method="post" action="{{action('CourseRatingController@store')}}">
        @csrf
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4">
            <label for="tee">Tee:</label>
            <input type="text" size="16" maxlength="16" class="form-control" name="tee" required ></input>
          </div>
          <div class="form-group col-md-4">
            <label for="slope">Slope:</label>
            <input type="number" class="form-control" name="slope" step="0.01" min="55" max="155" placeholder="155" required ></input>
          </div>
          <div class="form-group col-md-4">
            <label for="rating">Rating:</label>
            <input type="number" class="form-control" name="rating" step="0.01" min="0" max="999" placeholder="72" required ></input>
          </div>
          <div class="form-group col-md-4">
            <label for="yardage">Yardage:</label>
            <input type="number" class="form-control" name="yardage"  min="0" max="7500"></input>
          </div>
        
        </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="/ratings/{{$param}}" class="btn btn-warning">Back to Course Ratings</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

</body>

</html>
@endsection