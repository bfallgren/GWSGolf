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
  
    
    <h2>Update Home Club Profile</h2>

    <form method="post" action="{{action('HomeClubController@update', $id)}}">
      @csrf
      <input name="_method" type="hidden" value="PATCH">
      <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-3">
            <label for="course">Course:</label>
            <select name="course" class="form-control" id="mySelect" >
              <option value="">--Select Course--</option>
                @foreach ($course as $course => $value)
                  <option > {{ $value }}</option>   
                @endforeach
            </select>
            </div>
          <div class="form-group col-md-3">
            <label for="avg_daily_fee">Average Daily Fee:</label>
            <input type="number" class="form-control" name="avg_daily_fee" required 
            value="{{$data->avg_daily_fee}}"></input>
          </div>
          <div class="form-group col-md-3">
            <label for="annual_membership_fee">Annual Membership Fee:</label>
            <input type="number" class="form-control" name="annual_membership_fee" required 
            value="{{$data->annual_membership_fee}}"></input>
          </div>
          <div class="form-group col-md-3">
            <label for="shop_credit">Shop Credit:</label>
            <input type="number" class="form-control" name="shop_credit" required 
            value="{{$data->shop_credit}}"></input>
          </div>
          <div class="form-group col-md-3">
            <label for="image">Scorecard Avatar Location:</label>
            <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="image" value="{{$data->image}}"></input>
          </div>
        
        </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/homeclub" class="btn btn-warning">Back to Home Club Profile</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

</body>

</html>
@endsection