<?php include "includes/header.php" ?>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>

                        <!-- add categories -->
                        <div class="col-lg-6">
                            <form action="" method="post" class="cat_form">
                                <div class="error"></div>
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input type="text" class="form-control cat_title" name="cat_title">
                                    <input type="hidden" id="user_id" value="<?=$_SESSION['user_id'] ?>">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary add_cat" name="submit" value="Add Category">
                                </div>
                            </form>

                            <!-- Edit categories -->
                            <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Edit Category</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="edit_error"></div>
                                            <div class="form-group">
                                                <label for="cat_title">Category Name</label>
                                                <input type="hidden" id="cat_id" value="">
                                                <input type="text" id="edit_cat_title" class="form-control" name="cat_title">
                                                <input type="hidden" id="user_id" value="<?=$_SESSION['user_id'] ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" id="cat_update" class="btn btn-primary">Update</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                            <th>Id</th>
                                            <th>Category Title</th>                            
                                    </tr>
                                </thead>
                                <tbody class="cat_data">
                    <!-- gets all categories -->

                    <!-- detete categories -->
                    <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"><strong>Warning!</strong> Are you want to delete the category?</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="cat_delete" class="btn btn-primary" data-dismiss="modal">Delete</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script>
        $(document).ready(function(){
            getCatData();

            $(".add_cat").click(function(e){
                e.preventDefault();
                let cat_title = $(".cat_title").val();
                if(cat_title ==""){
                    $(".error").append(`<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Warning!</strong> This field should not be empty!
                    </div>`)

                }else{
                $.ajax({
                    type: "POST",
                    url: "includes/add_categories_ajax.php",
                    data: {
                        'checking_add': true,
                        'cat_title': cat_title,
                        'user_id': $("#user_id").val()
                    },
                    success: (res) =>{
                        if(res){
                            $(".cat_data").html('');
                            $(".cat_form")[0].reset();
                            getCatData();  
                        }
                    }
                })
            }
            })
            //-- For Getting the cat data to view --
            $(document).on("click", "#edit_cat", function(e){
                e.preventDefault();
                let cat_id = $(this).closest('tr').find('#cat_id').text();
                $.ajax({
                    type: "POST",
                    url: "includes/add_categories_ajax.php",
                    data:{
                        'checking_edit': true,
                        'cat_id': cat_id
                    },
                    success: (res) =>{
                        $.each(res, function(key, cat_data){
                            $("#cat_id").val(cat_data['cat_id']);
                            $("#user_id").val(cat_data['user_id']);
                            $("#edit_cat_title").val(cat_data['cat_title']);
                        })
                        $("#edit_modal").modal("show");
                    }
                })
            })

            //-- Update cat Data -- 
            $("#cat_update").click(function(e){
                e.preventDefault();
                let edit_cat_title = $("#edit_cat_title").val();
                if(edit_cat_title ==""){
                    $("#edit_error").append(`<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Warning!</strong> This field should not be empty!
                    </div>`)

                }else{
                $.ajax({
                    type: "POST",
                    url: "includes/add_categories_ajax.php",
                    data: {
                        'checking_update': true,
                        'cat_id': $("#cat_id").val(),
                        'cat_title': edit_cat_title
                    },
                    success: (res) =>{
                        if(res){
                            $("#cat_update").attr("data-dismiss", "modal");
                            $(".cat_data").html('');
                            getCatData(); 
                        }
                    }
                })
            }
            })

            //-- Delete Category --//
            $(document).on("click", "#delete_cat", function(e){
                e.preventDefault();
                let cat_id = $(this).closest('tr').find('#cat_id').text();
                $("#delete_modal").modal("show");
                $("#cat_delete").click(function(e){
                    $.ajax({
                        type: "POST",
                        url: "includes/add_categories_ajax.php",
                        data: {
                        'checking_delete': true,
                        'cat_id': cat_id
                        },
                        success: (res) =>{
                            if(res){
                                $(".cat_data").html('');
                                getCatData();
                            
                            }
                        }
                    })
                })
            })
        })    

        function getCatData(){
            $.ajax({
                type: "GET",
                url: "includes/view_all_categories_ajax.php",
                success: function(res){
                    $.each(res, function(key, value){
                        $(".cat_data").append(`<tr>
                        <td id='cat_id'>${value['cat_id']}</td>
                        <td>${value['cat_title']}</td>
                        <td><a href='#' id='delete_cat' class='btn btn-primary'>Delete</a></td>
                        <td><a href='#' id='edit_cat' class='btn btn-primary'>Edit</a></td>
                        </tr>`)

                    })
                }
            })
        }   

    </script>

<?php include "includes/footer.php" ?>