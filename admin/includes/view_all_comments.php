<?php
if(isset($_POST['checkBoxArray'])){
    foreach(($_POST['checkBoxArray']) as $comments_id){
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options){
            case 'approve':
                $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$comments_id}";
                $update_status_as_approve = mysqli_query($conn, $query);
                confirmQuery($update_status_as_approve);
            break;    

            case 'unapprove':
                $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$comments_id}";
                $update_status_as_unapprove = mysqli_query($conn, $query);
                confirmQuery($update_status_as_unapprove);
            break; 

            case 'delete':
                $query = "DELETE FROM comments WHERE comment_id = {$comments_id}";
                $delete_comment_as_bulk = mysqli_query($conn, $query);
                confirmQuery($delete_comment_as_bulk);
            break; 
        }
    }
}
?>
<!-- detete Comment Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><strong>Warning!</strong> Are you want to delete the comment?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="comment_delete" class="btn btn-primary" data-dismiss="modal">Delete</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px">
            <select class="form-control" name="bulk_options" id="">
                <Option value="">Select Options</Option>
                <Option value="approve">Approve</Option>
                <Option value="unapprove">Unapprove</Option>
                <Option value="delete">Delete</Option>

            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
        </div>
        <div class="col-xs-4" id="updateToApproved"></div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Comment Id</th>
                <th>Comment Post Id</th>
                <th>Comment Author</th>
                <th>Comment Email</th>
                <th>Comment Content</th>
                <th>In Response To</th>
                <th>Comment Status</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Comment Date</th>
                <th>Action</th>
            </tr>
        </thead>                
        <tbody id="comments_data">
        <?php
        if($session->isAdmin()){
            $selectAllComment = $my_db->query("SELECT * FROM comments");
        }
        else{
            $selectAllComment = $my_db->query("SELECT * FROM comments INNER JOIN posts ON comments.comment_post_id = posts.post_id AND posts.user_id =" . $_SESSION['user_id'] . "");
        }
            while($row = $selectAllComment->fetch_assoc()){
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_email = $row['comment_email'];
                $comment_comment = $row['comment_content'];
                $comment_response_to = $row['In_response_to'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
            }
        ?>                        
        </tbody>
    </table>
</form>
<a href=""></a>
<?php 


// if(isset($_GET["unapprove"])){
//     $the_comment_id = escape($_GET["unapprove"]);
    
    
//     header("Location: comment.php");
// }

?>


<script>
$(document).ready(function(){
    getCommentsData();

    //-- Delete Comments --//
    $(document).on("click", "#delete_comment", function(e){
        e.preventDefault();
        let comment_id = $(this).closest('tr').find('#comment_id').text();
        $("#delete_modal").modal("show");
        $("#comment_delete").click(function(e){
            $.ajax({
                type: "POST",
                url: "includes/update_comment_ajax.php",
                data: {
                    'checking_delete': true,
                    'comment_id': comment_id
                },
                success: (res) =>{
                    if(res){
                        $("#comments_data").html('');
                        getCommentsData();
                            
                    }
                }
            })
        })
    })

    //-- Change the comment status To Approved --//
    $(document).on("click", "#changeToApproved", function(e){
        e.preventDefault();
        let comment_id = $(this).closest('tr').find('#comment_id').text();
        $.ajax({
            type: "POST",
            url: "includes/update_comment_ajax.php",
            data: {
                'checking_update_to_approved': true,
                'comment_id': comment_id
            },
            success: (res) =>{
                console.log(res);
                if(res){
                    $("#updateToApproved").append(`<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> The comment status is updated to Approved!
                    </div>`);
                    $("#comments_data").html('');
                    getCommentsData();
                            
                }
            }
        })
    })

    //-- Change the comment status To Unapproved --//
    $(document).on("click", "#changeToUnapproved", function(e){
        e.preventDefault();
        let comment_id = $(this).closest('tr').find('#comment_id').text();
        $.ajax({
            type: "POST",
            url: "includes/update_comment_ajax.php",
            data: {
                'checking_update_to_unapproved': true,
                'comment_id': comment_id
            },
            success: (res) =>{
                if(res){
                    $("#updateToApproved").append(`<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> The comment status is updated to Unapproved!
                    </div>`);
                    $("#comments_data").html('');
                    getCommentsData();
                            
                }
            }
        })
    })

})
function getCommentsData(){
    $.ajax({
        type: "GET",
        url: "includes/view_all_comments_ajax.php",
                success: function(res){
                $.each(res, function(key, value){
                $("#comments_data").append(`<tr>
                <th><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value=${value['comment_id']}></th>
                <td id='comment_id'>${value['comment_id']}</td>
                <td>${value['comment_post_id']}</td>
                <td>${value['comment_author']}</td>
                <td>${value['comment_email']}</td>
                <td>${value['comment_content']}</td>
                <td><a href='../post.php?p_id=${value['comment_post_id']}'>${value['In_response_to']}</a></td>
                <td>${value['comment_status']}</td>
                <td><a href ='#' id='changeToApproved'>Approve</a></td>
                <td><a href ='#' id='changeToUnapproved'>Unapprove</a></td>
                <td>${value['comment_date']}</td>
                <td><a href ='#' id='delete_comment'>Delete</a></td>
            </tr>`)

                    })
                }
            })
}
</script>