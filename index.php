<?php //include "includes/db.php";
//include "includes/db_oops.php"  ?>
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
                    <small>By creators</small>
                </h1>
                <?php
                if($session->is_signed_in() && $session->isAdmin()){
                    $num_rows = $my_db->query("SELECT * FROM posts");
                }
                else{
                    $num_rows = $my_db->query("SELECT * FROM posts WHERE post_status = 'published'");
                }
                $row_count = $num_rows->num_rows;
                if($row_count < 1){
                    echo "<h1 class = 'text-center'>No posts available now!</h1>";
                }else{

                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = "";
                    }
                    if($page == "" || $page == 1){
                        $page_1 = 0;
                    }else{
                        $page_1 = ($page * 5) - 5;
                    }
                    if($session->is_signed_in() && $session->isAdmin()){
                        $result = $my_db->query("SELECT * FROM posts LIMIT $page_1, 5");
                       }
                    else{
                        $result = $my_db->query("SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, 5");
                    }
                    while($row = $result->fetch_array()){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_creator'];
                        $post_date = $row['post_date'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>
                <!-- First Blog Post -->
                <h2>
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href=author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <a href="post/<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <?php //endif;?>
                <?php } ?>
                
                <hr>
                <!-- Pager -->
                <ul class="pager">
                    <?php
                    for($i = 1; $i <= ceil($row_count/5); $i = $i + 1){
                    ?>
                    <li>
                        <?php 
                        if($i == $page){
                            echo"<a class='active_link' href='index?page={$i}'>{$i}</a>";

                        }else if($i >= 1){
                            echo"<a href='index?page={$i}'>{$i}</a>";
                        }
                        ?>
                    </li>

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