<?php
include("../../includes/db_oops.php");

if(isset($_POST['checking_delete'])){
    $comment_id = $_POST['comment_id'];

    $query_result = $my_db->query("DELETE FROM comments WHERE comment_id = {$comment_id}");
    $my_db->query("UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = $comment_post_id");

    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

if(isset($_POST['checking_update_to_approved'])){
    $comment_id = $_POST['comment_id'];
    $my_db->query("UPDATE comments SET comment_status='Approved' WHERE comment_id = {$comment_id}");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

if(isset($_POST['checking_update_to_unapproved'])){
    $comment_id = $_POST['comment_id'];
    $my_db->query("UPDATE comments SET comment_status='Unapproved' WHERE comment_id = {$comment_id}");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

?>