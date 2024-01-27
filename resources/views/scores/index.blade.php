<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>GWSGolf - Scores</title>
     
    </head>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h2>Scores</h2>
          </div>
          <div class="pull-right mb-2">
            <a class="btn btn-success" href="{{ route('scores.create') }}"> Add Score</a>
          </div>
        </div>
      </div> 
      
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
    
      <div class="card-body">

          @if ($scores->isNotEmpty()) 
              @if($scores->count())
      
                <div id="stats">
                    <div class="row" style=color:green> 
                      <div class="col-md-1">                      
                      </div>
                      <div class="col-md-2">
                          <p> Scores:</p>
                      </div>
                      <div class="col-md-2">
                          <p> Under 90:</p>
                      </div>
                      <div class="col-md-2">
                          <p> Avg Score:</p>
                      </div>
                      <div class="col-md-2">
                          <p> Low Round:</p>
                      </div>
                      <div class="col-md-2">
                          <p> Low Diff:</p>
                      </div>
                      <div class="col-md-1">
                          <p> Index:</p>
                      </div>
                    </div>
                
                    <div class="row"> 
                      <div class="col-md-1">
                      
                      </div>
                      <div class="col-md-2">
                          <b> {{ $scores->count() }} </b>
                      </div>
                      <div class="col-md-2">
                          <b> {{ $under90->count() }} </b>
                      </div>
                      <div class="col-md-2">
                          <b> {{number_format($avgscore,2)}} </b>
                      </div>
                      <div class="col-md-2">
                          <b> {{ $lowround }} </b>
                      </div>
                      <div class="col-md-2">
                          <b> {{ $lowdiff }} </b>
                      </div>
                      <div class="col-md-1">
                          <b> {{ $avg }} </b>
                      </div>
                    </div>
                    <div class="row">
                      <p>
                    </div>
                </div>
              @endif
          @endif


          <table style=width:100% class="row-border table" id="datatable-crud">
            <thead style=color:green>
              <tr>
                <th>Course</th>
                <th>Date Played</th>
                <th>Score</th>
                <th>Combined?</th>
                <th>Tee</th>
                <th>Holes</th>
                <th>Diff</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>

      </div>


      <!-- Delete Area Modal -->


<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this record?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </sdiv>
    </div>
</div>

  </body>

 

<script type="text/javascript">

  
 $(document).ready( function () {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#datatable-crud').DataTable({
           
           processing: true,
           serverSide: false, /* disabled for sql join */
           "info": false,
           dom: '<Blf<t>ip>', /* Buttons, Length and filter above, information and pagination below table: */
            buttons: [
             
              {
                  extend: 'copy',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
              {
                  extend: 'csv',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
              {
                  extend: 'pdf',
                  exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
             
            ],
                       
           ajax: "{{ url('scores') }}",
           columns: [
                                       
                    { data: 'name', name: 'courses.name', orderable: true, searchable: true, visible: true},
                    { data: 'date_played', name: 'date_played' },
                    { data: 'score', name: 'score' },
                    { data: 'combined', name: 'combined' },
                    { data: 'tee', name: 'tee' },
                    { data: 'holes', name: 'holes' },
                    { data: 'diff', name: 'diff' },

                    {data: 'action', name: 'action', orderable: false},
                 ],

                 columnDefs: [
                    { "targets": 0, "width":"30%"},
                    { "targets": 1, "width":"20%"},
                    { "targets": 3, "width":"5%",
                        "render": function (data, type, col, meta) {
                            
                            if ( data == "1" )
                                {return '<center> <i class="fas fa-check-circle fa-2xl"></i>';}
                            else 
                                { return ' ';}
                        } 
                    }, 
                     
                  ],

                 order: [[1, 'desc']]
              
      });

    var table = $('#datatable-crud').DataTable() ; 
    //console.log('table :', table);

    $('#datatable-crud').on('click', 'tr', function() {
    table.row(this).nodes().to$().addClass('larger-font')
    }) ;     
    var row_id;
    var $tr;
    var $button = $(this);

    // Delete action
    $(document).on('click', '.deleteButton', function(){
        row_id = $(this).attr('id');
        $tr = $(this).closest('tr'); //here we hold a reference to the clicked tr which will be later used to delete the ro
        $('#deleteModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
       
            type: "POST",
            data:{
            _method:"DELETE"
            },
            url:"/scores/" + row_id,
         
        });
            $.ajax({
                beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                },
            success:function(data)
            {
                setTimeout(function(){
                    $('#deleteModal').modal('hide');
                    $tr.find('td').fadeOut(1000,function(){ 
                            $tr.remove();   
                          }); 
                       
                  // $('#datatable-crud').DataTable().ajax.reload(); 
                  // DataTables warning: table id=datatable-crud - Invalid JSON response. 
                }, 1000);
            }
        });
    });


});

  

</script>
</html>  

@endsection