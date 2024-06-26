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
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                    <?php 
                    if(isset($_GET['source'])){
                        $source = escape($_GET['source']);
                    }
                    else { $source = ''; }

                    switch($source){
                        case 'add_posts';
                        include "includes/add_posts.php";
                        break;

                        case 'edit_post';
                        include "includes/edit_posts.php";
                        break;

                        default:
                        include "includes/view_all_posts.php";
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