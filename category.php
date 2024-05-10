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
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <?php
                    if(isset($_GET['category'])){
                        $the_post_fr_cat = $_GET['category'];
                        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] = 'Admin'){
                            $query = "SELECT * FROM posts WHERE post_category_id = $the_post_fr_cat";
                        }
                        else{
                            $query = "SELECT * FROM posts WHERE post_category_id = $the_post_fr_cat AND post_status = 'published'";
                        }
                    $selectAllPost = mysqli_query($conn, $query);
                    if(mysqli_num_rows($selectAllPost) < 1){
                        echo "<h1 class = 'text-center'>No posts available now!</h1>";
                    }else{
                    while($row = mysqli_fetch_assoc($selectAllPost)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_creator'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        ?>
                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author_posts?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="/cms/images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <?php } } }else{

                    header(Location: index);
                }?>
                
                <hr>
                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
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