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
  
    <h2>Clubs</h2>

    
    
    <form method="post" action="{{url('clubs')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-12"></div>
            <div class="form-group col-md-4">
              <label for="name">Name:</label>
              <input type="text" size="24" maxlength="24" class="form-control" name="name" required>
            </div>
            <div class="form-group col-md-4">
              <label for="vendor">Vendor:</label>
              <input type="text" size="24" maxlength="24" class="form-control" name="vendor"></input>
            </div>
            <div class="form-group col-md-4">
              <label for="loft">Loft:</label>
              <input type="number" class="form-control" name="loft" step=any></input>
            </div>
            <div class="form-group col-md-4">
              <label for="lie">Lie:</label>
              <input type="number" class="form-control" name="lie" step=any></input>
            </div>
            <div class="form-group col-md-4">
              <label for="length">Length:</label>
              <input type="number" class="form-control" name="length" step=any></input>
            </div>
            <div class="form-group col-md-4">
              <label for="vendswing_weight">Swing Weight:</label>
              <input type="text" size="2" maxlength="2" class="form-control" name="swing_weight"></input>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="/clubs" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

</body>

</html>
@endsection