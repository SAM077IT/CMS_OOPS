<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<body>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Posts
                    <small>By creator</small>
                </h1>
<?php
                if(ifItIsMethod('post')){
                    if(isset($_POST['submit'])){

                    $search = $_POST['search'];
        
                    if(isAdmin($_SESSION['username'])){
                        $search_query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                    }
                    else{
                        $search_query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' and post_status = 'published'";
                    }
                    
                    $select_search_Post = mysqli_query($conn, $search_query);
                    while($row = mysqli_fetch_assoc($select_search_Post)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_creator'];
                        $post_date = $row['post_date'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>
                <!-- First Blog Post -->
                <?php //if($post_status == 'published'):?>
                <h2>
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href=author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <a href="post/<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <?php //endif;?>
                <?php } ?>
                
                <hr>
                    <?php } }?>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <?php include "includes/sidebar.php" ?>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->

<?php include "includes/footer.php" ?>