<?php 
if(isset($_POST["create_user"])){

    $username = escape($_POST["username"]);
    $user_role = escape($_POST["user_role"]);
    $firstname = escape($_POST["firstname"]);
    $lastname = escape($_POST["lastname"]);
    // $user_image = $_FILES["user_image"]["name"];
    // $post_image_temp = $_FILES["image"]["tmp_name"];
    $user_email = escape($_POST["user_email"]);
    $user_password = escape($_POST["user_password"]);
    //$date = date("d-m-y");
    $user_password = password_hash("$user_password", PASSWORD_BCRYPT, ["cost" => 8]);
    //move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO users (username, user_password, firstname, lastname, user_email, user_role, reg_date) VALUES('{$username}', '{$user_password}', '{$firstname}', '{$lastname}','{$user_email}','{$user_role}', now())";

    $create_user_query = mysqli_query($conn, $query);
    
    confirmQuery($create_user_query);
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_role">User Role</label>
        <select name="user_role" id="">
            <option value= >Select Option</option>
            <option value=Admin >Admin</option>
            <option value=Subscriber >Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="tags">First Name</label>
        <input type="text" class="form-control" name="firstname">
    </div>
    <div class="form-group">
        <label for="tags">Last Name</label>
        <input type="text" class="form-control" name="lastname">
    </div>
    <div class="form-group">
        <label for="tags">Email</label>
        <input type="text" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" class="form-control" name="user_image">
    </div>
    <div class="form-group">
        <label for="status">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User" onclick ="user_added_alert();">
    </div>
</form>