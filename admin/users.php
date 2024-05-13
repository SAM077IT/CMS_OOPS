<?php include "includes/header.php" ?>

<?php 
if(!$session->isAdmin($_SESSION['user_id'])){
    header("Location: index.php");
}
?>
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
                    if(isset($_GET['source'])){
                        $source = escape($_GET['source']);
                    }
                    else { $source = ''; }

                    switch($source){
                        case 'add_user';
                        include "includes/add_users.php";
                        break;

                        default:
                        include "includes/view_all_users.php";
                        break;
                    }
                    ?>
                </div>          
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

<?php include "includes/footer.php" ?>