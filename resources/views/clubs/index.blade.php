<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>GWSGolf - Clubs</title>
     
             
  </head>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h2>Clubs</h2>
          </div>
          <div class="pull-right mb-2">
            <a class="btn btn-success" href="{{ route('clubs.create') }}"> Add Club</a>
          </div>
        </div>
      </div>
        
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
    
      <div class="card-body">

        <table style=width:100% class="row-border table" id="datatable-crud">
          <thead style=color:green>
            <tr>
              <th>Name</th>
              <th>Vendor</th>
              <th>Loft</th>
              <th>Lie</th>
              <th>Length</th>
              <th>Swing Wt.</th>
              <th>Yardage</th>
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
        </div>
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
           serverSide: true,
          
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
                    columns: [0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
              {
                  extend: 'pdf',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6] //Your Column value those you want
                  }
              },
             
            ],
                       
           ajax: "{{ url('clubs') }}",
           columns: [
                                       
                    { data: 'name', name: 'name'},
                    { data: 'vendor', name: 'vendor' },
                    { data: 'loft', name: 'loft' },
                    { data: 'lie', name: 'lie' },
                    { data: 'length', name: 'length' },
                    { data: 'swing_weight', name: 'swing_weight' },
                    { data: 'yardage', name: 'yardage' },

                    {data: 'action', name: 'action', orderable: false},
                 ],

                 columnDefs: [
                    { "targets": 0, "width":"30%"},
                    { "targets": 1, "width":"30%"}
                     
                  ],

                 order: [[2, 'asc']]
              
      });

    var table = $('#datatable-crud').DataTable() ; 
    //console.log('table :', table);

    $('#datatable-crud').on('click', 'tr', function() {
    table.row(this).nodes().to$().addClass('larger-font')
    }) ;     
    var row_id;

    // Delete action
    $(document).on('click', '.deleteButton', function(){
        row_id = $(this).attr('id');
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
            url:"/clubs/" + row_id,
         
        });
            $.ajax({
                beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                },
            success:function(data)
            {
                setTimeout(function(){
                    $('#deleteModal').modal('hide');
                    $('#datatable-crud').DataTable().ajax.reload();
                }, 1000);
            }
        });
    });


});

  

</script>
</html>  

@endsection