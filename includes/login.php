<?php //include "db.php"; ?>
<?php include "init.php"; ?>
<?php //session_start(); ?>
<?php
// if(isset($_POST['login'])){
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     $username = mysqli_real_escape_string($conn,$username);
//     $password = mysqli_real_escape_string($conn,$password);

//     $query = "Select * FROM users WHERE username = '{$username}' ";
//     $select_user_query = mysqli_query($conn, $query);
//     if(!$select_user_query){
//         die("QUERY FAILED". mysqli_error($conn));
//     }

//     while($row = mysqli_fetch_array($select_user_query)){
//         $db_user_id = $row['user_id'];
//         $db_username = $row['username'];
//         $db_password = $row['user_password'];
//         $db_user_firstname = $row['firstname'];
//         $db_user_role = $row['user_role'];

//     }

//     if(password_verify($password, $db_password)){
//         $_SESSION['username'] = $db_username;
//         $_SESSION['firstname'] = $db_user_firstname;
//         $_SESSION['user_role'] = $db_user_role;
//         header("Location: ../admin");
//     }
//     else{
//         header("Location: ../index.php");
//     }
// }

// if($session->is_signed_in()){
//     redirect("../index.php");
// }
if(isset($_POST['submit'])){
    $username = trim($_POST['username']);     
    $password = trim($_POST['password']);

    //check to database for the user
    $user_found = User::verify_user($username, $password);
    var_dump($user_found);
    // if($user_found){
    //     $session->login($username);
    //     header("Location: ../admin");
    // }else{
    //     header("Location: ../index.php");
    // }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Welcome to Subscriber page</h1>
    <br>
    <br>
    <h4>Username: <?php echo $username; ?></h4>
    <h4>Password: <?php echo $password; ?></h4>
    <h4>DB_Password: <?php echo $db_password; ?></h4>
    <h4>Password_hash: <?php echo $pass_hash; ?></h4>
</body>
</html>