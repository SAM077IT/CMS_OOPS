<?php include("../../includes/db_oops.php") ?>
<?php
    global $my_db;
    $res_arr = [];
    $cat_result = $my_db->query("SELECT * FROM categories");                              
    if($cat_result->num_rows > 0){
        foreach($cat_result as $row){
            array_push($res_arr, $row);
        }
        header('content-type: application/json');
        echo json_encode($res_arr);
    }else{
        echo $return = "<h4>No Record Found</h4>";
    }


?>