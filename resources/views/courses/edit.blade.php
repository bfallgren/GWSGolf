<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>courses</title>
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
  
    <h2>Courses</h2>
        
    <form method="post" action="{{action('CourseController@update', $id)}}">
      @csrf
      <input name="_method" type="hidden" value="PATCH">
      <div class="row">
        <div class="col-md-12"></div>
          <div class="form-group col-md-3">
            <label for="name">Name:</label>
            <input type="text" size="64" maxlength="64" class="form-control" name="name" required value="{{$course->name}}">
          </div>
          <div class="form-group col-md-3">
            <label for="City">City:</label>
            <input type="text" size="24" maxlength="24" class="form-control" name="city" value="{{$course->city}}"></input>
          </div>
          <div class="form-group col-md-3">
            <label for="state">State:</label>
            <input type="text" size="12" maxlength="12" class="form-control" name="state" value="{{$course->state}}"></input>
          </div>
          <div class="form-group col-md-3">
            <label for="image">Scorecard Avatar Location:</label>
            <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="image" value="{{$course->image}}"></input>
          </div>
          
      </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/courses" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

</body>

</html>
@endsection