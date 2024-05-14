<?php
include("../../includes/db_oops.php");
include("../../includes/session.php");
global $my_db;
$res_arr = [];
if($session->isAdmin()){
    $user_result = $my_db->query("SELECT * FROM comments");
}
else{
    $user_result = $my_db->query("SELECT * FROM comments INNER JOIN posts ON comments.comment_post_id = posts.post_id AND posts.user_id =" . LoggedInUserID() . "");
}                            
if($user_result->num_rows > 0){
    foreach($user_result as $row){
        array_push($res_arr, $row);
    }
    header('content-type: application/json');
    echo json_encode($res_arr);
}else{
    echo $return = "<h4>No Record Found</h4>";
}


?>