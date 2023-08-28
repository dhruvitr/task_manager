<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laravel Task Manager</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  
  <style>
    #draggable { 
        width: 150px;
        height: 150px;
        padding: 0.5em;
    }
  </style>
</head>
<body class="bg-light">
<div class="container">
  <div class="row">
    <div class="col-md-12">
        <h2 class="text-center pb-3 pt-1">Sortable Task Manager</h2>
        <div class="row">
            <h5 class="d-block pb-3 pt-1">Name: Dhruvit Rajpura</h5>
        </div>
        <div class="row">
            <h6 class="d-block pb-3 pt-1">GitHub: https://github.com/dhruvitr/task_manager/tree/master</h6>
        </div>
        
        
        <div class="row">
            <div class="col-md-12 py-3 px-0">
                <div class="btn btn-primary float-right" data-toggle="modal" data-target="#taskModal">
                    + ADD TASK
                </div>
            </div>
            <div class="col-md-12 p-3 bg-dark ">
                <ul class="list-group shadow-lg connectedSortable" id="padding-item-drop">
                  @if(!empty($tasks) && $tasks->count())
                    @foreach($tasks as $key=>$value)
                      <li class="list-group-item" item-id="{{ $value->id }}">
                        <span class="list-group-item-editable" data-name="{{ $value->name }}" data-type="text" data-pk="{{ $value->id }}" data-title="Enter name" >
                            {{ $value->name }}
                        </span>
                        <span class="float-right"> 
                            <button class="btn btn-sm btn-danger delete" data-id="{{ $value->id }}" >DELETE</button>
                        </span>
                      </li>
                    @endforeach
                  @endif
                </ul>
            </div>
        </div>
    </div>
  </div>
</div>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
    <script>$.fn.poshytip={defaults:null}</script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
  <script>
  $( function() {
    $.fn.editable.defaults.mode = 'inline';
  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    }); 
  
    $('.list-group-item-editable').editable({
           url: "{{ route('update.task') }}",
           type: $(this).attr("data-type"),
           pk: $(this).attr("data-pk"),
           name: $(this).attr("data-name"),
           title: $(this).attr("data-title")
    });

    $( "#padding-item-drop" ).sortable({
      connectWith: ".connectedSortable",
      opacity: 0.5,
    }).disableSelection();

    $( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
        var panddingArr = [];

        $("#padding-item-drop li").each(function( index ) {
          panddingArr[index] = $(this).attr('item-id');
        });

        $.ajax({
            url: "{{ route('sort.task') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {panddingArr:panddingArr},
            success: function(data) {
              console.log('success');
            }
        });
    });

    $(".delete").on("click", function(e){
        $.ajax({
            url: "{{ route('delete.task') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {id: $(this).attr('data-id')},
            success: function(data) {
                $(this).closest('li').remove();
            }
        });
    })
          
  });
</script>


<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">New Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('create.task') }}" method="POST">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="name" class="control-label">Title</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <!-- button -->
          <div class="float-right">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>
</body>
</html>