<?php
include "../includes/db_oops.php";
//=====  USER AUTHENTICATION HELPER FUNCTIONS =====//
// function isLoggedIn(){

//     if(isset($_SESSION['user_role'])){
//         return true;
//     }
//    return false;
// }

// function getUsername(){
//     return isset($_SESSION['username']) ? $_SESSION['username'] : null;
// }

// function LoggedInUserID(){
//     if(isLoggedIn()){
//         $query_result = query("SELECT * FROM users WHERE username ='" .$_SESSION['username']."'");
//         $user = mysqli_fetch_array($query_result);
//         if(mysqli_num_rows($query_result) >= 1){
//             return $user['user_id'];
//         }
//     }
//     return false;
// }


//=====  END OF USER AUTHENTICATION HELPER FUNCTIONS =====//

// function ifItIsMethod($method=null){

//     if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
//         return true;
//     }
//     return false;
// }



//================ Category Helper FUNCTIONS ================//

//  function login_user($username, $password){

//      global $conn;

//      $username = trim($username);
//      $password = trim($password);

//      $username = mysqli_real_escape_string($conn, $username);
//      $password = mysqli_real_escape_string($conn, $password);

//      $select_user = query("SELECT * FROM users WHERE username = '{$username}' ");
//      confirmQuery($select_user);
//      while ($row = mysqli_fetch_array($select_user)) {

//          $db_user_id = $row['user_id'];
//          $db_username = $row['username'];
//          $db_user_password = $row['user_password'];
//          $db_user_firstname = $row['firstname'];
//          $db_user_lastname = $row['lastname'];
//          $db_user_role = $row['user_role'];

//          if(password_verify($password,$db_user_password)) {
//              $_SESSION['user_id'] = $db_user_id;
//              $_SESSION['username'] = $db_username;
//              $_SESSION['firstname'] = $db_user_firstname;
//              $_SESSION['lastname'] = $db_user_lastname;
//              $_SESSION['user_role'] = $db_user_role;
//             if($db_user_role == 'Admin'){
//                 redirect("/cms/admin");
//             }else{
//                 redirect("/cms/admin/dashboard.php");
//             }
//          } else {
//              return false;
//          }
//      }
//      return true;
//  }

function user_online(){

    if(isset($_REQUEST['onlineusers'])){
       
        global $my_db;
        session_start();
            $session = session_id();
            $log_time = time();
            $time_out_sec = 60;
            $time_out = $log_time - $time_out_sec;
    
            $send_query = $my_db->query("SELECT * FROM users_online WHERE session_id = '$session'");
            $count_users = $send_query->num_rows;
    
            if($count_users == NULL){
                $my_db->query("INSERT INTO users_online (session_id, log_time) VALUES('{$session}', {$log_time})");
            }else{
                $my_db->query("UPDATE users_online SET log_time = {$log_time} WHERE session_id = '{$session}'");
            }
            $user_online_query = $my_db->query("SELECT * FROM users_online WHERE log_time > {$time_out}");
            echo $user_online_query->num_rows;
            }
        
    }
user_online();

?>