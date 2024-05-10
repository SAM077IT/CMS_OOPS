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
                    if(isset($_GET['p_id'])){
                        $the_post_id = $_GET['p_id'];
                        $query_post_count_up="UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $the_post_id";
                        $post_count_up = mysqli_query($conn, $query_post_count_up);
                    
                        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                        $select_All_Post = mysqli_query($conn, $query);
                        if(!$select_All_Post){
                            die("Query Failed! ". mysqli_error($conn));
                        }
                        while($row = mysqli_fetch_assoc($select_All_Post)){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];
                        ?>                

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
                <?php } 
            }
            else{

                header("Location: index.php");
            }?>
                                <!-- Blog Comments -->
                <?php 
                if(isset($_POST['create_comment'])){
                    $the_post_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];

                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, 	comment_content, In_response_to, comment_status, comment_date) VALUES({$the_post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', '{$post_title}','Unapproved', now())";

                    $create_comment_query = mysqli_query($conn, $query);

                    $query1 = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id";

                    $update_comment_count = mysqli_query($conn, $query1);
                     
                    header("Location:post.php?p_id=$the_post_id");
                    
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
                        <button type="submit" name="create_comment" class="btn btn-primary" onclick ="formValidation()">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
<?php 
$query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
$select_comment_query = mysqli_query($conn, $query);
if(!$select_comment_query){
    die('Query Failed' . mysqli_error($conn));
}

while($row = mysqli_fetch_array($select_comment_query)){
    $comment_author = $row['comment_author'];
    $comment_content = $row['comment_content'];
    $comment_date = $row['comment_date'];
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


<?php } ?>
                <!-- Comment -->
                

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