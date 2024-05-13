<?php 
include("../../includes/db_oops.php");

if(isset($_POST['checking_edit'])){
    $res_arr = [];
    $user_id = $_POST['user_id'];
    $cat_result = $my_db->query("SELECT * FROM users WHERE user_id='{$user_id}'");                              
    if($cat_result->num_rows > 0){
        foreach($cat_result as $row){
            array_push($res_arr, $row);
        }
        header('content-type: application/json');
        echo json_encode($res_arr);
    }else{
        echo $return = "<h4>No Record Found</h4>";
    }
}

if(isset($_POST['checking_update'])){
    $user_id = $_POST['user_id'];
    $usersData = $_POST['userData'];

    $query_result = $my_db->query("UPDATE users SET username='{$usersData[0]['value']}', firstname='{$usersData[1]['value']}', lastname='{$usersData[2]['value']}', user_email='{$usersData[3]['value']}', user_role='{$usersData[4]['value']}' WHERE user_id='{$user_id}'");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

if(isset($_POST['checking_delete'])){
    $user_id = $_POST['user_id'];
    $query_result = $my_db->query("DELETE FROM users WHERE user_id='{$user_id}'");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

if(isset($_POST['checking_update_to_admin'])){
    $user_id = $_POST['user_id'];
    $query_result = $my_db->query("UPDATE users SET user_role='Admin' WHERE user_id='{$user_id}'");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

if(isset($_POST['checking_update_to_sub'])){
    $user_id = $_POST['user_id'];
    $query_result = $my_db->query("UPDATE users SET user_role='Subscriber' WHERE user_id='{$user_id}'");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

?>