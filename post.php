<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<body>
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>
    <?php

    if(isset($_POST['liked'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //1 =  FETCHING THE RIGHT POST
        $query = "SELECT * FROM posts WHERE post_id=$post_id";
        $postResult = mysqli_query($conn, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];

        // 2 = UPDATE - INCREMENTING WITH LIKES
        mysqli_query($conn, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

        // 3 = CREATE LIKES FOR POST
        mysqli_query($conn, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
        exit();
    }   

    if(isset($_POST['unliked'])) {

        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //1 =  FETCHING THE RIGHT POST
        $query = "SELECT * FROM posts WHERE post_id=$post_id";
        $postResult = mysqli_query($conn, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];

        //2 = DELETE LIKES
        mysqli_query($conn, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");

        //3 = UPDATE WITH DECREMENTING WITH LIKES
        mysqli_query($conn, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
        exit();
    }
    ?>
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
            if (isset($_GET["p_id"])) {
                $the_post_id = $_GET["p_id"];
                $query_post_count_up = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $the_post_id";
                $post_count_up = mysqli_query($conn, $query_post_count_up);

                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] = 'Admin'){
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                }
                else{
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                }
        
                $select_All_Post = mysqli_query($conn, $query);
                confirmQuery($select_All_Post);
                $row_count = mysqli_num_rows($select_All_Post);
                if($row_count < 1){
                    echo "<h1 class = 'text-center'>No posts available now!</h1>";
                }else{
                    while ($row = mysqli_fetch_array($select_All_Post)) {
                        $post_id      = $row["post_id"];
                        $post_title   = $row["post_title"];
                        $post_creator  = $row["post_creator"];
                        $post_date    = $row["post_date"];
                        $post_image   = $row["post_image"];
                        $post_content = $row["post_content"];
                        ?>                
                        <!-- First Blog Post -->
                        <h2>
                            <a href="#">
                            <?php echo $post_title; ?></a>      
                        </h2>
                        <p class="lead">
                            by <a href="/cms/author_posts?author=<?php echo $post_creator; ?> 
                            &p_id=<?php echo $post_id; ?>">
                            <?php echo $post_creator; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> 
                            <?php echo $post_date; ?>
                        </p>
                        <hr>
                        <div class = "img-placeholder"><img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt=""></div>
                        <hr>
                        <p><?php echo $post_content; ?><h4>
                        <?php if(isLoggedIn()){ ?>
                            <p class="pull-right"><a class ="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like' ?>" href=""><i class='bi bi-hand-thumbs-up-fill'></i><?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like' ?></a><br><br>
                            Like: <?php getPostLikes($the_post_id);?>
                        <?php }else{?>
                            <p class="pull-right">You need to <a href="/cms/login">Login</a> to like <br><br>
                            Like: <?php getPostLikes($the_post_id);?></p>
                        <?php } ?>
                        </h4></p> 
                        <hr><br><br>
                
                    <?php } ?>        
                               <!-- Blog Comments -->
                    <?php
                        if(isset($_POST["create_comment"])) {
                            $the_post_id = $_GET["p_id"];
                            $comment_author  = $_POST["comment_author"];
                            $comment_email   = $_POST["comment_email"];
                            $comment_content = $_POST["comment_content"];
                            if (!empty($_POST['comment_author']) && !empty($_POST['comment_email']) && !empty($_POST['comment_content'])) {
                                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email,     comment_content, In_response_to, comment_status, comment_date) VALUES({$the_post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', '{$post_title}','Unapproved', now())";
                                $create_comment_query = mysqli_query($conn, $query);

                            } else { 
                                echo "<script>alert('Fields cannot be empty');</script>";
                            }
                        }
                    ?>

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form action="" method="POST" role="form" >
                            <div class="form-group">
                                <input type="text" class="form-control" name="comment_author" id="nameOfAuthor" placeholder="Enter your Name:">
                            </div>
                            <div class="form-group">
                            <input type="email" id="emailOfAuthor" class="form-control" name="comment_email" placeholder="Enter your Email id:">
                            </div>
                            <div class="form-group">
                                <textarea name="comment_content" id="comment_content" placeholder="Enter your comment:" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" name="create_comment" class="btn btn-primary" >Submit</button>
                        </form>
                    </div>
                    <hr>
                    <!-- Posted Comments -->
                    <?php
                        $all_comment_query = query("SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'approve' ORDER BY comment_id DESC");
                        confirmQuery($all_comment_query); 
                        while ($row = mysqli_fetch_array($all_comment_query)) {
                            $comment_author  = $row["comment_author"];
                            $comment_content = $row["comment_content"];
                            $comment_date    = $row["comment_date"];
                    ?>
                    <div class="media">
                        
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                            </h4>
                            <?php echo $comment_content; ?>

                        </div>
                    </div>

                    <?php } 
                    //<!-- Posted Comments -->//
                } //--END OF FETCHING PRODUCTS-----//  
            } //--END OF P_ID---//
            else{
            header("Location: index.php");
            die;
            }
?>
                <!-- Comment -->
                
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
                <?php
include "includes/sidebar.php";
?>
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

<script>
    $(document).ready(function(){
        const post_id = <?php echo $the_post_id; ?>;
        const user_id = <?php echo LoggedInUserID(); ?>;
        //Liking...................
        $('.like').click(function(){
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });

        //Unliking...................
        $('.unlike').click(function(){
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });

    });
</script>        

<?php
include "includes/footer.php";
?>
