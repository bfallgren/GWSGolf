@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>A Good Walk Spoiled</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
      
	    <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
      
        <style>
           .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }
            }
        </style>
    </head>
<body>
    <div class="flex-center position-ref full-height">
            
            <div class="content">
                <div class="container">
                    <h2> A Good Walk Spoiled</h2>
                    <img src="images/Pebble Beach No. 7.jpg" alt="HTML5 Icon"width="1024" height="524" >
                </div>              
            </div>
    </div>
        
</body>
</html>
@endsection