<!-- edit.blade.php -->
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
  
      <h2>Update Score</h2>
    
    <form method="post" action="{{action('ScoreController@update', $id)}}">
      @csrf
      <input name="_method" type="hidden" value="PATCH">
      <div class="row">      
          <div class="form-group col-md-4">
            <label for="course">Course:</label>
            <input  class="form-control" name="course" readonly value="{{$score_at_course->name}}" ></input>
           
          </div>
          <div class="form-group col-md-4">
            <label for="date_played">Date:</label>
            <input type="date" class="form-control" name="date_played" required value="{{$score->date_played}}" ></input>
          </div>
          <div class="form-group col-md-4">
            <label for="score">score:</label>
            <input type="number" class="form-control" name="score" min="0" max="120" required value="{{$score->score}}" ></input>
          </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
              <label for="tee">Tee:</label>
              <input  class="form-control" name="tee" readonly value="{{$score->tee}}"></input>
            </div>
            <div class="form-group col-md-4">
              <label for="holes">Holes:</label>
              <input type="number" class="form-control" name="holes" value = "18" required value="{{$score->holes}}" ></input>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/scores" class="btn btn-warning">Back to Scores</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->


</body>

</html>
@endsection