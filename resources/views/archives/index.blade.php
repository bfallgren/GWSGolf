<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="utf-8">
        <title>GWSGolf - Archives</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" />

        <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css" />

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

         <!-- added for datatable export -->
   
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"> </script>
        <script src= "https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"> </script>
    </head>
    <body>
    <style>
    
    </style>

        <div class="container mt-2">    
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Score History</h2>
                    </div>
                </div>
            </div> 
            
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                </div>
            </div>

            <div class="row">
                <p>   </p>
            </div>
            
            <div class="tableFixHead">
                <div class="table-responsive">
                
                    <table style=width:100% class="row-border table" id="order_table">
                        <thead style=color:green>
                            <tr>
                                <th>Course</th>
                                <th>Date Played</th>
                                <th>Score</th>
                                <th>Tee</th>
                                <th>Holes</th>
                                <th>Diff</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </body>


    <script>
        $(document).ready(function(){
            $('.input-daterange').datepicker({
                todayBtn:'linked',
                todayHighlight:'true',
                format:'yyyy-mm-dd',
                autoclose:true
                });

            load_data();

            function load_data(from_date = '', to_date = '')
            {
                $('#order_table').DataTable({
                    processing: true,
                    serverSide: false,
                    dom: '<Blf<t>ip>', /* Buttons, Length and filter above, information and pagination below table: */
                    buttons: [
                    
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5] //Your Column value those you want
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5] //Your Column value those you want
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5] //Your Column value those you want
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5] //Your Column value those you want
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5] //Your Column value those you want
                        }
                    },
                    
                    ],
                    ajax: {
                        url:'{{ route("allscores") }}',
                        data:{from_date:from_date, to_date:to_date}
                    },
                    columns: [
                                                        
                            { data: 'name', name: 'courses.name', orderable: true, searchable: true, visible: true},
                            { data: 'date_played', name: 'date_played' },
                            { data: 'score', name: 'score' },
                            { data: 'tee', name: 'tee' },
                            { data: 'holes', name: 'holes' },
                            { data: 'diff', name: 'diff' },
                    ],
                    order: [[1, 'desc']]
                });
            }

            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if(from_date != '' &&  to_date != '')
                {
                $('#order_table').DataTable().destroy();
                load_data(from_date, to_date);
                }
                else
                {
                alert('Both Dates are required');
                }
            });

            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('#order_table').DataTable().destroy();
                load_data();
            });

        });

    </script>
</html>  

@endsection