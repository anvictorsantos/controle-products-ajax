<!DOCTYPE html>
<html>
<head>
    <title>Laravel 6 Ajax CRUD tutorial using Datatable</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
    
<div class="container">
    <h1>Laravel 6 Ajax CRUD tutorial using Datatable</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Criar Novo Produto</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Nome</th>
                <th>Detalhes</th>
                <th width="280px">Ação</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nome</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Detalhes</label>
                        <div class="col-sm-12">
                            <textarea id="detail" name="detail" required="" placeholder="Enter Details" class="form-control"></textarea>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
</body>
    
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'detail', name: 'detail'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewProduct').click(function() {
            $("#saveBtn").val("create-product");
            $("#product_id").val('');
            $("#productForm").val("reset");
            $("#modelHeading").val("Criar Novo Produto");
            $("#ajaxModel").modal("show");
        });

        $("body").on("click", ".editProduct", function() {
            var product_id = $(this).data("id");
            $.get("{{ route('product.index') }}" + "/" + product_id + "/edit", function(data) {
                $("#modelHeading").html("Editar Produto");
                $("#saveBtn").val("edit-user");
                $("#ajaxModel").modal("show");
                $("#product_id").val(data.id);
                $("#name").val(data.name);
                $("#detail").val(data.detail);
            });
        });

        $("#saveBtn").click(function(e) {
            e.preventDefault();
            $(this).html("Enviando...");

            $.ajax({
                data: $("#productForm").serialize(),
                url: "{{ route('product.index') }}",
                type: "POST",
                dataType: "json",
                success: function(data) {
                    $("#productForm").trigger("reset");
                    $("#ajaxModel").modal("hide");
                    table.draw();
                },
                error: function(data) {
                    console.log("Error:", data);
                    $("#saveBtn").html("Salvar Mudanças");
                }
            });
        });

        $("body").on("click", ".deleteProduct", function() {
            var product_id = $(this).data("id");
            confirm("Você tem certeza que deseja deletar ?");

            $.ajax({
                type: "DELETE",
                url: "{{ route('product.index') }}" + "/" + product_id,
                success: function(data) {
                    table.draw();
                },
                error: function(data) {
                    console.log("Error:", data);
                }
            });
        });
    });
</script>
</html>