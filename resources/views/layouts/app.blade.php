<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'My Health') }}</title>

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}" defer></script> --> 

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> 

    <!-- using font-awesome (free/solid) icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
    
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- added for datatable export -->
   
    <script src= "https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"> </script>
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
    <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"> </script>
    <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"> </script>

    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    
</head>
    <body>
        
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-green shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        @guest
                             <!-- not authenticated -->
                        @else
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item dropdown">
                                <a class="dropdown-item" href="{{URL::route('golfcourses')}}" style="position:relative; top:10px">Courses </a>
                            </li>
                            @if (Auth::user()->name != 'Admin' && Auth::user()->name != 'admin')
                                <li class="nav-item dropdown">
                                    <a class="dropdown-item" href="{{URL::route('allscores')}}" style="position:relative; top:10px">Archives </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a class="dropdown-item" href="" style="position:relative; top:10px">Galleries</a>
                            </li>
                            
                        </ul>
                        @endguest

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                           
                            
                            
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"
                                    style="position:relative; top:5px; right:0px">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}"  
                                        style="position:relative; top:5px; right:0px">{{ __('Register') }}
                                            
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                                    style="position:relative; top:5px; right:-10px"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} 
                                    </a>

                                    
                                    
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @if (Auth::user()->name != 'Admin' && Auth::user()->name != 'admin')
                                            <a class="dropdown-item" href="{{URL::route('golfclubs')}}">Clubs
                                        @endif
                                        <a class="dropdown-item" href="{{URL::route('myclub')}}">Home Club
                                        @if (Auth::user()->name != 'Admin' && Auth::user()->name != 'admin')
                                            <a class="dropdown-item" href="{{URL::route('golfscores')}}">Scores
                                        @endif
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link " href="#" style="position:relative; top:5px; right:-10px" 
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> Help
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal" 
                                    data-target="#about">About</button>
                                    <button class="dropdown-item btn btn-warning btn-sm" id="myBtn" data-toggle="modal" 
                                    data-target="#slope">Rating vs. Slope</button>
                                </div>                
                                  
                            </li>

                            <!-- About Modal -->
                            <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">About GWS Golf (Version {{ env('APP_VER') }})</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                
                                                <div class="col-md-3">
                                                    <p> <h5> 'Good Walk Spoiled' Golf features:
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Golf Course / ratings - maintenance and lookup</p>
                                                    <p>Golf Score tracking</p>
                                                    <p>Personal golf equipment inventory</p>
                                                    <p>Home Club information</p>
                                                    <p>Statistical Analysis (coming soon)</p>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p> <h5> Build Resources:
                                                </div>
                                                <div class="col-md-9">
                                                    <p>Laravel=> {{ App::Version()}}</p>
                                                    <p>{!! get_package_json2('bootstrap')!!}</p>
                                                    <p>{!! get_package_json2('jquery')!!}</p>
                                                    <p>{!! get_package_json2('laravel-mix')!!}</p>
                                                    <p>{!! get_package_json2('vue')!!}</p>
                                                    <p>{!! php_ver() !!}
                                                    <p>FontAwesome=> v.5.7.1</p>
                                                    {!! mysql_db_ver() !!}
                                                    <br></br> 
                                                    <br></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p> <h5> Credits:
                                                </div>
                                                <div class="col-md-9">
                                                    <p>Stackoverflow.com</p>
                                                    <p>AppDividend.com</p>
                                                    <p>Medium.com</p>
                                                    <p>LaravelDocs</p>
                                                    <p>itsolutionstuff.com</p>
                                                    <p>ministackoverflow.com</p>
                                                    <p>laravel-news.com</p>
                                                    <p>easylaravelbook.com</p>
                                                    <p>auth0.com</p>
                                                    <p>snipe.net</p>
                                                    <p>codexworld.com</p>
                                                    <p>tutorialspoint.com</p>
                                                    <p>incoder.com</p>
                                                    <p>laravelcode.com</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="background-color: lightgreen">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <!-- Slope Modal -->
                            <div class="modal fade" id="slope" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Course Rating vs Slope Rating</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                
                                                <div class="col-md-3">
                                                    <p> <h5> ' What is a "Course Rating"? </p>
                                                </div>
                                                <div class="col-md-9">
                                                    <p>The quick answer is that it's a single number indicating the difficulty of a golf course to an expert golfer, a "par golfer". </p>
                                                    <p>The figure is used when calculating handicaps.

                                                    <p>The Course Rating is a number, close to par for the course, and is expressed with a single decimal digit. </p>
                                                    <p>For example: If par for a course is 72, it's Course Rating might be 71.4.</p>

                                                    <p>Rating values go up with difficulty.</p>

                                                    <p>Actually, for any given golf course, you can expect to see three (or even more) values for the Course Rating. </p>
                                                    <p>Each value corresponds to a different tee.</p>

                                                    <p>For example: On this same course, the Course Rating for golfers who play from the men's blue tees might be 72.8. </p>
                                                    <p>From the men's white tees, the Course Rating might be 71.0. The ladies' red tees may be rated at 73.3.</p>

                                                    <p>These figures are almost always printed on the score card. </p>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <p> <h5> ' What is a "Slope Rating"? </p>
                                                </div>
                                                <div class="col-md-9">
                                                    <p>The quick (and overly simplistic) answer is that it's a single number indicating the difficulty of a golf course to a "bogey golfer".  </p>
                                                    <p> The figure is used when calculating handicaps. 

                                                    <p>The Course Slope value is a two- or three-digit integer, always between 55 and 155, with 113 being the average or "standard" value.  </p>
                                                    <p>Slope values increase with difficulty. But there is a catch that we'll discuss shortly. </p>

                                                    <p>There will be one Course Slope for each Course Rating. The blue men's tees might have a Course Slope of 123. </p>

                                                    <p>The white men's tees: 119 and the men's red tees perhaps a 114.  </p>
                                                    <p>These figures are almost always printed on the score card in the United States. </p>

                                                    <p> Course Slope is a creation of The United States Golf Association and has been licensed to the Royal Canadian Golf Association. </p>
                                                    <p>Courses outside of the United States and Canada (and their protectorates) will probably not have a Slope rating. </p>

                                                    <p>For more information , see http://www.leaderboard.com/abcs.htm</p>
                                                    <br>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="modal-footer" style="background-color: lightgreen">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </ul>
                    </div>
                </div>
            </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>
</html>
