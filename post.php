<?php include "includes/header.php"; ?>
<body>
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>
    <?php

    if(isset($_POST['liked'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //1 =  FETCHING THE RIGHT POST
        $postResult = $my_db->query("SELECT * FROM posts WHERE post_id=$post_id");
        $post = $postResult->fetch_array();
        $likes = $post['likes'];

        // 2 = UPDATE - INCREMENTING WITH LIKES
        $my_db->query("UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

        // 3 = CREATE LIKES FOR POST
        $my_db->query("INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
        exit();
    }   

    if(isset($_POST['unliked'])) {

        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //1 =  FETCHING THE RIGHT POST
        $postResult = $my_db->query("SELECT * FROM posts WHERE post_id=$post_id");
        $post = $postResult->fetch_array();
        $likes = $post['likes'];

        //2 = DELETE LIKES
        $my_db->query("DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");

        //3 = UPDATE WITH DECREMENTING WITH LIKES
        $my_db->query("UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
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
                $my_db->query("UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $the_post_id");

                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] = 'Admin'){
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                }
                else{
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                }
                $select_All_Post = $my_db->query($query);
                $row_count = $select_All_Post->num_rows;
                if($row_count < 1){
                    echo "<h1 class = 'text-center'>No posts available now!</h1>";
                }else{
                    while ($row = $select_All_Post->fetch_array()) {
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
                            by <a href="/cms_oops/author_posts?author=<?php echo $post_creator; ?> 
                            &p_id=<?php echo $post_id; ?>">
                            <?php echo $post_creator; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> 
                            <?php echo $post_date; ?>
                        </p>
                        <hr>
                        <div class = "img-placeholder"><img class="img-responsive" src="/cms_oops/images/<?php echo imagePlaceholder($post_image); ?>" alt=""></div>
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <h4>
                        <?php if($session->is_signed_in()){ ?>
                    <span class="pull-right">
<a class ="<?php echo $my_db->userLikedThisPost($the_post_id, $_SESSION['user_id']) ? 'unlike' : 'like'?>" href=""><i class='bi bi-hand-thumbs-up-fill'></i><?php echo $my_db->userLikedThisPost($the_post_id, $_SESSION['user_id']) ? ' Unlike' : ' Like' ?></a>
                            Like: <?php $my_db->getPostLikes($the_post_id);?>
                        </span>
                        <?php }else{?>
                            <span class="pull-right">You need to <a href="/cms_oops/login">Login</a> to like <br>
                            Like: <?php $my_db->getPostLikes($the_post_id);?></span>
                        <?php } ?>
                        </h4>
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
                                $my_db->query("INSERT INTO comments (comment_post_id, comment_author, comment_email,     comment_content, In_response_to, comment_status, comment_date) VALUES({$the_post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', '{$post_title}','Unapproved', now())");
                                //$create_comment_query = mysqli_query($conn, $query);

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
    $all_comment_query = $my_db->query("SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'Approved' ORDER BY comment_id DESC");
    while ($row = $all_comment_query->fetch_array()) {
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

                    <?php 
                    } 
                    ?>
                    <?php   
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
        const user_id = <?php echo $_SESSION['user_id']; ?>;
        //Liking...................
        $('.like').click(function(){
            console.log("Liked");
            $.ajax({
                url: "/cms_oops/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                },
                success: (res) =>{
                    console.log(res);
                }
            });
        });

        //Unliking...................
        $('.unlike').click(function(){
            $.ajax({
                url: "/cms_oops/post.php?p_id=<?php echo $the_post_id; ?>",
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
