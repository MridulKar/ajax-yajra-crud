<!DOCTYPE html>
<html>
<head>
  <title>Laravel 8 DataTable Ajax Books CRUD Example</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- data table css -->
  <link  href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- data table js -->
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

</head>
<body>

<div class="container mt-4">
  
  <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>

  <div class="card">

    <div class="card-header text-center font-weight-bold">
      <h2>Laravel 8 Ajax CRUD with DataTable</h2>
    </div>

    <div class="card-body">

        <table class="table table-bordered" id="datatable-ajax-crud">
           <thead>
              <tr>
                 <th>Id</th>
                 <th>Image</th>
                 <th>Book Title</th>
                 <th>Code</th>
                 <th>Author</th>
                 <th>Status</th>
                 <th>Status update</th>
                 <th>Created at</th>
                 <th>Action</th>
              </tr>
           </thead>
        </table>
    </div>

  </div>
  <!-- boostrap add and edit book model -->
    <div class="modal fade" id="ajax-book-model" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxBookModel"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Book Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="title" name="title" placeholder="Enter Book Name" maxlength="50" required="">
                </div>
              </div>  

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Book Code</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="code" name="code" placeholder="Enter Book Code" maxlength="50" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Book Author</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="author" name="author" placeholder="Enter author Name" required="">
                </div>
              </div>             

               <div class="form-group">
                <label class="col-sm-2 control-label">Book Image</label>
                <div class="col-sm-6 pull-left">
                  <input type="file" class="form-control" id="image" name="image" required="">
                </div>               
                <div class="col-sm-6 pull-right">
                    
                  <img id="preview-image" src="{{ asset('upload/images/' . \App\Models\Book::first()->image) }}"
                        alt="preview image" style="max-height: 250px;">
                </div>
              </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->

<script type="text/javascript">
     
 $(document).ready( function () {

//=== ajax csrf starts ===
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//=== ajax csrf ends ===



//=== image preview before upload starts ===
    $('#image').change(function(){
    //selecting the input field with id= "image", including jquery change() method
    let reader = new FileReader();
    //creating a object named FileReader(), can access the files of input field with type="file"
    reader.onload = (e) => {
    //FileReader.onload is a handler for FileReader.load_event,
    //this event executed everytime when the reading operation is successfully completed.
      $('#preview-image').attr('src', e.target.result);
      //selecting the img tag with id="preview-image"
      //image of input field named with id= "image" will be shown here in
    }

    reader.readAsDataURL(this.files[0]); 
    //read only 1st image
  
   });
//=== image preview before upload ends ===



//===  get data from database table and display with html table with pagination ===
    $('#datatable-ajax-crud').DataTable({
      //selecting the table with id="datatable-ajax-crud" and including Datatable in it
           processing: true,
           serverSide: true,
           ajax: "{{ url('ajax-crud-image-upload') }}",
           columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    //{ data: 'id', name: 'id', 'visible': false},
                    { data: 'image', name: 'image' , orderable: false},
                    { data: 'title', name: 'title' },
                    { data: 'code', name: 'code' },
                    { data: 'author', name: 'author' },
                    { data: 'status', name: 'status' },
                    { data: 'active', name: 'active' },
                    { data: 'created_at', name: 'created_at', 'visible': false},
                    { data: 'action', name: 'action', orderable: false},
                 ]
    });

//=== add, edit, delete data using ajax with datatable ===
    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Add Book");
       $('#ajax-book-model').modal('show');
       $("#image").attr("required", "true");
       $('#id').val('');
       $('#preview-image').attr('src', 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg');


    });
 
    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');
         
        //=== ajax edit ===
        $.ajax({
            type:"POST",
            url: "{{ url('edit-book') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Book");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#title').val(res.title);
              $('#code').val(res.code);
              $('#author').val(res.author);
              $('#image').removeAttr('required');

           }
        });

    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
         
        //=== ajax delete ===
        $.ajax({
            type:"POST",
            url: "{{ url('delete-book') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){

              var oTable = $('#datatable-ajax-crud').dataTable();
              oTable.fnDraw(false);
           }
        });
       }

    });



    

   $('#addEditBookForm').submit(function(e) {

     e.preventDefault();
  
     var formData = new FormData(this);
//=== ajax add or update ===  
     $.ajax({
        type:'POST',
        url: "{{ url('add-update-book')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
          $("#ajax-book-model").modal('hide');
          var oTable = $('#datatable-ajax-crud').dataTable();
          oTable.fnDraw(false);
          $("#btn-save").html('Submit');
          $("#btn-save"). attr("disabled", false);
        },
        error: function(data){
           console.log(data);
         }
       });
   });
});
</script>
</div>  
</body>
</html>