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
        <tbody>
        <?php
        if(isAdmin()){
            $selectAllComment = query("SELECT * FROM comments");
        }
        else{
            $selectAllComment = query("SELECT * FROM comments INNER JOIN posts ON comments.comment_post_id = posts.post_id AND posts.user_id =" . LoggedInUserID() . "");
        }
            while($row = mysqli_fetch_assoc($selectAllComment)){
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_email = $row['comment_email'];
                $comment_comment = $row['comment_content'];
                $comment_response_to = $row['In_response_to'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
            echo "<tr>";
                echo "<th><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value={$comment_id}></th>";
                echo "<td>$comment_id</td>";
                echo "<td>$comment_post_id</td>";
                echo "<td>$comment_author</td>";
                echo "<td>$comment_email</td>";
                echo "<td>$comment_comment</td>";
                echo "<td><a href='../post.php?p_id=$comment_post_id'>$comment_response_to</a></td>";
                echo "<td>$comment_status</td>";
                echo "<td><a href ='comment.php?approve={$comment_id}'>Approve</a></td>";
                echo "<td><a href ='comment.php?unapprove={$comment_id}'>Unapprove</a></td>";
                echo "<td>$comment_date</td>";
                echo "<td><a href ='comment.php?delete={$comment_id}'>Delete</a></td>";
            echo "</tr>";
            }
        ?>                        
        </tbody>
    </table>
</form>
<a href=""></a>
<?php 
if(isset($_GET["approve"])){
    $the_comment_id = escape($_GET["approve"]);

    $query = "UPDATE comments SET comment_status='approved' WHERE comment_id = {$the_comment_id}";
    $approve_comment_query = mysqli_query($conn, $query);
    header("Location: comment.php");
}

if(isset($_GET["unapprove"])){
    $the_comment_id = escape($_GET["unapprove"]);
    
    $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id = {$the_comment_id}";
    $unapprove_comment_query = mysqli_query($conn, $query);
    header("Location: comment.php");
}

if(isset($_GET["delete"])){
    $the_comment_id = escape($_GET["delete"]);
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
    $delete_comment_query = mysqli_query($conn, $query);

    $query1 = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = $comment_post_id";
    $update_comment_count = mysqli_query($conn, $query1);
    header("Location: comment.php");
}

?>
