<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>Home Club</title>
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
  
    <h2>Home Club Profile</h2>
    <br>   
    <div class="row"> 
      <div class="col-md-9">
          <a title='Add Home Club' data-toggle='tooltip' href="/homeclub/create" span class='fas fa-plus-square'style='font-size: 3em; color:green'></span></a>
       </div>
    </div>
 
    @include('home_clubs.modal')
    <table class="table table-bordered table-striped table-hover category-table" data-toggle="dataTable" data-form="deleteForm">
        <tr style='font-size: 10; color:green'>
         
            <th width="150px">Course Name</th>
            <th width="100px">Average Daily Fee</th>
            <th width="100px">Annual Membership Fee</th>
            <th width="100px">Shop Credit</th>
            <th width="100px">Scorecard Avatar</th>
            <th width="30px">Action</th>
        </tr>
       
        @if ($data->isNotEmpty()) 
              @if($data->count())
                @foreach($data as $row)
                    <tr>
                        <td>{{$row->name}}</td>
                        <td>${{number_format($row->avg_daily_fee,2)}}</td>
                        <td>${{number_format($row->annual_membership_fee,2)}}</td>
                        <td>${{number_format($row->shop_credit,2)}} </td>
                        <td><a title='Click for full image, back button to return' data-toggle='tooltip' 
                        href="/images/courses/{{$row->image}}"><img src="/images/courses/{{$row->image}}" 
                        width="88" height="50" ></a></td>
                        <!-- EDIT button -->
                        <td align="left"><a title='Edit Home Club' data-toggle='tooltip' href="{{action('HomeClubController@edit', $row->id)}}" span class='fas fa-edit'style='font-size: 18px; color:orange; margin-left:10px'></span></a>
                        
                        <!-- DELETE button -->                
                        
                        {!! Form::model($row, ['method' => 'delete', 'route' => ['homeclub.destroy', $row->id], 'class' =>'form-inline form-delete']) !!}
                        {!! Form::hidden('id', $row->id) !!}
                        {!! Form::button('<i class="fa fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-critical btn-md delete', 'style' => 'color:red', 'name' => 'delete_modal', 'title' => 'Delete Record'] )  !!}
                        {!! Form::close() !!}
                        </td>
                        
                    </tr>
                @endforeach

              @endif
        @endif
      </table>
      <div class="row" style='font-size: 6; color:green'>
      <div class="col-md-2">
          <p width="75px">(Current Year)</p>
        </div>
        <div class="col-md-1">
          <p width="75px">Rounds Played</p>
        </div>
        <div class="col-md-1"> 
            <p>Average Score</p>
          </div>
          <div class="col-md-1">
            <p>Rounds Under 90</p>
          </div>
          <div class="col-md-1">
            <p>Low Round</p>
          </div>
          <div class="col-md-1">
            <p">Lowest Diff</p>
          </div>
          <div class="col-md-1">
            <p>Cost of Rounds Played</p>
          </div>
        </div>
        @if (Auth::user()->name == 'Admin' || Auth::user()->name == 'admin')
        <div class="row" style='font-size: 6; color:green'>
        <div class="col-md-2">
          </div>
          <div class="col-md-1">
           @if(isset($scores)) <p width="75px">{{$scores->count() }}</p> @endif
          </div>
          <div class="col-md-4">
          </div>
          <div class="col-md-1">
            @if(isset($cost_of_rounds)) <p>${{number_format($cost_of_rounds,2)}} @endif
          </div>
        </div>
        @else
        <div class="row" style='font-size: 6; color:green'>
          <div class="col-md-2">
          </div>
          <div class="col-md-1">
           @if(isset($scores)) <p width="75px">{{$scores->count() }}</p> @endif
          </div>
          <div class="col-md-1"> 
            @if(isset($avgscore)) <p>{{number_format($avgscore,2)}}</p> @endif
          </div>
          <div class="col-md-1">
            @if(isset($under90)) <p>{{ $under90->count() }}</p> @endif
          </div>
          <div class="col-md-1">
            @if(isset($lowround)) <p>{{ $lowround }}</p> @endif
          </div>
          <div class="col-md-1">
            @if(isset($lowdiff)) <p>{{ $lowdiff }}</p> @endif
          </div>
          <div class="col-md-1">
            @if(isset($cost_of_rounds)) <p>${{number_format($cost_of_rounds,2)}} @endif
          </div>
        </div>
        @endif
 </div> <!-- container / end -->

</body>

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