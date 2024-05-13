<?php

if(isset($_POST['checkBoxArray'])){
    foreach(($_POST['checkBoxArray']) as $bulk_user_id){
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options){
            case 'Admin':
                $my_db->query("UPDATE users SET user_role='{$bulk_options}' WHERE user_id = {$bulk_user_id}");
            break;

            case 'Subscriber':
                $my_db->query("UPDATE users SET user_role='{$bulk_options}' WHERE user_id = {$bulk_user_id}");
            break; 

            case 'delete':
                $my_db->query("DELETE FROM users WHERE user_id = {$bulk_user_id}");
            break; 
        }
    }
}
?>
<form action="" method="" id="edit_form">
    <!-- Modal for Editing users -->
    <div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit User Details</h4>
                </div>
                <div class="modal-body">
                    <div id="edit_error"></div>           
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="edit_username" class="form-control" name="username">
                    <label style="padding-top:12px">First Name</label>
                    <input type="text" id="edit_firstname" class="form-control" name="firstname">
                    <label style="padding-top:12px">Last Name</label>
                    <input type="text" id="edit_lastname" class="form-control" name="lastname">
                    <label style="padding-top:12px">User Email</label>
                    <input type="text" id="edit_email" class="form-control" name="email">
                    <label style="padding-top:12px">User Role</label>
                    <input type="text" id="edit_role" class="form-control" name="user_role">
                    <input type="hidden" id="user_id" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="user_update" class="btn btn-primary">Update</button>
            </div>
        </div>    
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>

<!-- detete user modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><strong>Warning!</strong> Are you want to delete the user?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="user_delete" class="btn btn-primary" data-dismiss="modal">Delete</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<form action="" method="post" id="">

    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px">
            <select class="form-control" name="bulk_options" id="">
                <Option value="">Select Options</Option>
                <Option value="Admin">Admin</Option>
                <Option value="Subscriber">Subscriber</Option>
                <Option value="delete">Delete</Option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
        </div>
        <div class="col-xs-6" id="updateToAdmin"></div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>User Email</th>
                <th>Role</th>
                <th>Date</th>
                <th>Change Role</th>
                <th>Change Role</th>
                <th>Edit user</th>
                <th>Delete</th>
            </tr>
        </thead>                
        <tbody id="users_data">                      
        </tbody>
    </table>
</form>

<script>
$(document).ready(function(){
    getUserData();

    //-- For Getting the users data to view in the edit form --
    $(document).on("click", "#edit_user", function(e){
        e.preventDefault();
        let user_id = $(this).closest('tr').find('#user_id').text();
        let user_role = $(this).closest('tr').find('#user_role').text();
        $.ajax({
            type: "POST",
            url: "includes/edit_users_ajax.php",
            data:{
                'checking_edit': true,
                'user_id': user_id
            },
            success: (res) =>{
                $.each(res, function(key, user_data){
                    $("#cat_id").val(user_data['cat_id']);
                    $("#user_id").val(user_data['user_id']);
                    $("#edit_username").val(user_data['username']);
                    $("#edit_firstname").val(user_data['firstname']);
                    $("#edit_lastname").val(user_data['lastname']);
                    $("#edit_email").val(user_data['user_email']);
                    $("#edit_role").val(user_data['user_role']);
                })
                $("#edit_user_modal").modal("show");
            }
        })
    })

    //-- Update User Data====
    $("#user_update").click(function(e){
        e.preventDefault();
        let inputArr = $("#edit_form").serializeArray();
        
        if(inputArr[0]['value'] =="" || inputArr[4]['value'] ==""){
            $("#edit_error").append(`<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> Username and Role fields should not be empty!
            </div>`);
        }else{
            $.ajax({
                type: "POST",
                url: "includes/edit_users_ajax.php",
                data: {
                    'checking_update': true,
                    'user_id': $("#user_id").val(),
                    'userData':inputArr
                },
                success: (res) =>{
                    if(res){
                        $("#user_update").attr("data-dismiss", "modal");
                        $("#users_data").html('');
                        getUserData();
                    }
                }
            })
        }
    })

    //-- Delete Category --//
    $(document).on("click", "#delete_user", function(e){
        e.preventDefault();
        let user_id = $(this).closest('tr').find('#user_id').text();
        $("#delete_modal").modal("show");
        $("#user_delete").click(function(e){
            $.ajax({
                type: "POST",
                url: "includes/edit_users_ajax.php",
                data: {
                    'checking_delete': true,
                    'user_id': user_id
                },
                success: (res) =>{
                    if(res){
                        $("#users_data").html('');
                        getUserData();
                            
                    }
                }
            })
        })
    })

    //-- Change the user role To Admin --//
    $(document).on("click", "#changeToAdmin", function(e){
        e.preventDefault();
        let user_id = $(this).closest('tr').find('#user_id').text();
        $.ajax({
            type: "POST",
            url: "includes/edit_users_ajax.php",
            data: {
                'checking_update_to_admin': true,
                'user_id': user_id
            },
            success: (res) =>{
                if(res){
                    $("#updateToAdmin").append(`<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> The user role is updated to Admin!
                    </div>`);
                    $("#users_data").html('');
                    getUserData();
                            
                }
            }
        })
    })

    //-- Change the user role To Subcriber --//
    $(document).on("click", "#changeToSub", function(e){
        e.preventDefault();
        let user_id = $(this).closest('tr').find('#user_id').text();
        $.ajax({
            type: "POST",
            url: "includes/edit_users_ajax.php",
            data: {
                'checking_update_to_sub': true,
                'user_id': user_id
            },
            success: (res) =>{
                if(res){
                    $("#updateToAdmin").append(`<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> The user role is updated to Subscriber!
                    </div>`);
                    $("#users_data").html('');
                    getUserData();
                            
                }
            }
        })
    })

})
function getUserData(){
    $.ajax({
        type: "GET",
        url: "includes/view_all_users_ajax.php",
                success: function(res){
                $.each(res, function(key, value){
                $("#users_data").append(`<tr>
                <th><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value=${value['user_id']}></th>
                <td id='user_id'>${value['user_id']}</td>
                <td>${value['username']}</td>
                <td>${value['firstname']}</td>
                <td>${value['lastname']}</td>
                <td>${value['user_email']}</td>
                <td id='user_role'>${value['user_role']}</td>
                <td>${value['reg_date']}</td>
                <td><a href='#' id='changeToSub'>Subscriber</a></td>
                <td><a href='#' id='changeToAdmin'>Admin</a></td>
                <td><a href ='#' id='edit_user'>Edit</a></td>
                <td><a href='' id='delete_user'>Delete</a></td>
            </tr>`)

                    })
                }
            })
}
</script>


