<?php

// function escape($string){
//     global $my_db;
//     return $my_db->escape_string(trim($string));
// }

function imagePlaceholder($image = ''){
    if(!$image){
        return 'my_placeholder.png';
    }
    else{
        return $image;
    }
}

//===== DATABASE HELPER FUNCTIONS =====//

function query($query){
    global $conn;
    return mysqli_query($conn, $query);
}

function confirmQuery($result){
    global $conn;
    if(!$result){
        die("Query Failed! ". mysqli_error($conn));
    }
}

function recordCount($table){
    global $conn;
    $query = "SELECT * FROM " . $table;
    $select_all = mysqli_query($conn, $query);
    return mysqli_num_rows($select_all);
}

//=====  END OF DATABASE HELPER FUNCTIONS =====//

//=====  USER AUTHENTICATION HELPER FUNCTIONS =====//
function isLoggedIn(){

    if(isset($_SESSION['user_role'])){
        return true;
    }
   return false;
}

function getUsername(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

function LoggedInUserID(){
    if(isLoggedIn()){
        $query_result = query("SELECT * FROM users WHERE username ='" .$_SESSION['username']."'");
        $user = mysqli_fetch_array($query_result);
        if(mysqli_num_rows($query_result) >= 1){
            return $user['user_id'];
        }
    }
    return false;
}

function isAdmin(){
    global $conn;
    if(isLoggedIn()){
        
        $result = query("SELECT user_role FROM users WHERE user_id = ". LoggedInUserID() . "");
        confirmQuery($result);
  
        $row = mysqli_fetch_array($result);
    
        if($row['user_role'] == 'Admin'){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
        
    }
}

//=====  END OF USER AUTHENTICATION HELPER FUNCTIONS =====//

function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

function userLikedThisPost($post_id=''){
    $result = query("SELECT * FROM likes WHERE user_id=" .LoggedInUserID() . " AND post_id={$post_id}");
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostLikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirmQuery($result);
    echo mysqli_num_rows($result);
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}
//================ Category Helper FUNCTIONS ================//
function addCategories(){
    global $conn;
    if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        $user_id = LoggedInUserID();

        if($cat_title =="" || empty($cat_title)){
            echo "This field should not be empty";
        }
        else{
            $query = "INSERT INTO categories(cat_title, user_id)";
            $query.="VALUE('{$cat_title}', '$user_id')";
            $create_cat_query = mysqli_query($conn, $query);
            confirmQuery($create_cat_query);
        }
    }
}

function deleteCategories(){
    global $conn;
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        $del_query = mysqli_query($conn, $query);
        header("Location: categories.php");
    }
}
function getAllCategories(){
    if(isAdmin()){
        $cat_result = query("SELECT * FROM categories");
    }else{
        $cat_result = query("SELECT * FROM categories WHERE user_id =" . LoggedInUserID() . "");
    }
    confirmQuery($cat_result);
    while($row = mysqli_fetch_array($cat_result)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}' class='btn btn-primary'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}' class='btn btn-primary'>Edit</a></td>";
        echo "</tr>";                
        }
}

function userExists($username){
    global $conn;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function emailExists($email){
    global $conn;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($conn, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}
function register_user($username, $email, $password){

    global $conn;

        $username = mysqli_real_escape_string($conn, $username);
        $email    = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $password = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 8));
              
        $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query .= "VALUES('{$username}','{$email}', '{$password}', 'subscriber' )";
        $register_user_query = mysqli_query($conn, $query);

        confirmQuery($register_user_query);
}

 function login_user($username, $password){

     global $conn;

     $username = trim($username);
     $password = trim($password);

     $username = mysqli_real_escape_string($conn, $username);
     $password = mysqli_real_escape_string($conn, $password);

     $select_user = query("SELECT * FROM users WHERE username = '{$username}' ");
     confirmQuery($select_user);
     while ($row = mysqli_fetch_array($select_user)) {

         $db_user_id = $row['user_id'];
         $db_username = $row['username'];
         $db_user_password = $row['user_password'];
         $db_user_firstname = $row['firstname'];
         $db_user_lastname = $row['lastname'];
         $db_user_role = $row['user_role'];

         if(password_verify($password,$db_user_password)) {
             $_SESSION['user_id'] = $db_user_id;
             $_SESSION['username'] = $db_username;
             $_SESSION['firstname'] = $db_user_firstname;
             $_SESSION['lastname'] = $db_user_lastname;
             $_SESSION['user_role'] = $db_user_role;
            if($db_user_role == 'Admin'){
                redirect("/cms/admin");
            }else{
                redirect("/cms/admin/dashboard.php");
            }
         } else {
             return false;
         }
     }
     return true;
 }

function user_online(){

    if(isset($_GET['onlineusers'])){
        
        global $conn;
        if(!$conn){
            session_start();
            include("../includes/db.php");

            $session = session_id();
            $log_time = time();
            $time_out_sec = 60;
            $time_out = $log_time - $time_out_sec;

            $query = "SELECT * FROM users_online WHERE session_id = '$session'";
            $send_query = mysqli_query($conn, $query);
            $count_users = mysqli_num_rows($send_query);

            if($count_users == NULL){
                mysqli_query($conn, "INSERT INTO users_online (session_id, log_time) VALUES('{$session}', {$log_time})");
            }else{
                mysqli_query($conn, "UPDATE users_online SET log_time = {$log_time} WHERE session_id = '{$session}'");
            }
            $user_online_query = mysqli_query($conn, "SELECT * FROM users_online WHERE log_time > {$time_out}");
            echo $user_count_online = mysqli_num_rows($user_online_query);
        }
    }
}

user_online();

?>