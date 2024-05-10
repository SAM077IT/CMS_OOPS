<?php include "includes/header.php" ?>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Author</small>
                    </h1>
                    <?php 
                    if(isset($_SESSION['user_id'])){
                        $user_in_admin = user::find_user_by_id($_SESSION['user_id']);
                        $username = $user_in_admin->username;
                        $firstname = $user_in_admin->firstname;
                        $lastname = $user_in_admin->lastname;
                        $user_email = $user_in_admin->user_email;
                        $user_password = $user_in_admin->user_password;
                        $user_role = $user_in_admin->user_role;

                        }

                        if(isset($_POST["edit_user"])){
                            $user->username = escape($_POST["username"]);
                            $user->user_role = escape($_POST["user_role"]);
                            $user->firstname = escape($_POST["firstname"]);
                            $user->lastname = escape($_POST["lastname"]);
                            // $user_image = $_FILES["user_image"]["name"];
                            // $post_image_temp = $_FILES["image"]["tmp_name"];
                            $user->user_email = escape($_POST["user_email"]);
                            $user_password = escape($_POST["user_password"]);
                            //$date = date("d-m-y");
                            $user->user_password = password_hash("$user_password", PASSWORD_BCRYPT, ["cost" => 8]);
                            //move_uploaded_file($post_image_temp, "../images/$post_image");
                            $user->update_user($_SESSION['user_id']);
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
            <option value= ><?php echo $user_role; ?></option>
            <?php 
            if($user_role == "Admin"){
                echo "<option value='Subscriber'>Subscriber</option>";
            }
            else{
                //echo "<option value='Admin'>Admin</option>";
            }           
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="tags">First Name</label>
        <input type="text" value="<?php echo $firstname; ?>" class="form-control" name="firstname">
    </div>
    <div class="form-group">
        <label for="tags">Last Name</label>
        <input type="text" value="<?php echo $lastname; ?>" class="form-control" name="lastname">
    </div>
    <div class="form-group">
        <label for="tags">Email</label>
        <input type="text" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
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
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile Data">
    </div>
</form>
                </div>          
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

<?php include "includes/footer.php" ?>