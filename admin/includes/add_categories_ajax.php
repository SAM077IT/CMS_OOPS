<?php
include("../../includes/db_oops.php");

global $my_db;

if(isset($_POST['checking_add'])){
    $cat_title = $_POST['cat_title'];
    $user_id = $_POST['user_id'];
    $query = "INSERT INTO categories(cat_title, user_id) ";
    $query.="VALUE('{$cat_title}', '{$user_id}')";
    $my_db->query($query);
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

if(isset($_POST['checking_edit'])){
    $res_arr = [];
    $cat_id = $_POST['cat_id'];
    $cat_result = $my_db->query("SELECT * FROM categories WHERE cat_id='{$cat_id}'");                              
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
    $cat_id = $_POST['cat_id'];
    $query_result = $my_db->query("UPDATE categories SET cat_title='{$_POST['cat_title']}' WHERE cat_id='{$cat_id}'");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}

if(isset($_POST['checking_delete'])){
    $cat_id = $_POST['cat_id'];
    $query_result = $my_db->query("DELETE FROM categories WHERE cat_id='{$cat_id}'");
    $return = mysqli_affected_rows($my_db->conn) == 1 ? true : false;
    echo $return;
}
?>