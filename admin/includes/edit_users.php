<?php 

if(isset($_GET['u_id'])){
    $edit_user_id = escape($_GET['u_id']);
    }
$query = "SELECT * FROM users WHERE user_id = $edit_user_id";
$selectUsersById = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($selectUsersById)){
    $user_id = escape($row['user_id']);
    $username = escape($row['username']);
    $firstname = escape($row['firstname']);
    $lastname = escape($row['lastname']);
    $user_email = escape($row['user_email']);
    $user_password = escape($row['user_password']);
    $user_role = escape($row['user_role']);
}

if(isset($_POST["edit_user"])){

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
    $query = "UPDATE users SET ";
    $query .="username= '{$username}', ";
    $query .="user_password = '{$user_password}', ";
    $query .="firstname = '{$firstname}', ";
    $query .="lastname = '{$lastname}', ";
    $query .="user_email = '{$user_email}', ";
    $query .="user_role = '{$user_role}' ";
    $query .="WHERE user_id = {$edit_user_id}";

    $update_user = mysqli_query($conn, $query);

    confirmQuery($update_user);
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_role">User Role</label>
        <select name="user_role" id="">
            <option value=<?php echo $user_role; ?> ><?php echo $user_role; ?></option>
            <?php 
            if($user_role == "Admin"){
                echo "<option value='Subscriber'>Subscriber</option>";
            }
            else{
                echo "<option value='Admin'>Admin</option>";
            }           
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="tags">First Name</label>
        <input type="text"  value="<?php echo $firstname; ?>" class="form-control" name="firstname">
    </div>
    <div class="form-group">
        <label for="tags">Last Name</label>
        <input type="text"  value="<?php echo $lastname; ?>" class="form-control" name="lastname">
    </div>
    <div class="form-group">
        <label for="tags">Email</label>
        <input type="text"  value="<?php echo $user_email; ?>" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" class="form-control" name="user_image">
    </div>
    <div class="form-group">
        <label for="status">Password</label>
        <input type="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
</form>