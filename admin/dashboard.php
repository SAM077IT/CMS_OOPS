<?php include "includes/header.php";?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>  
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to the Admin Dashboard
                        <small> <?php echo $session->getUsername(); ?></small>
                    </h1>
                </div>
            </div>
       
            <!---------- /.row ------------------>  
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php
                                    $select_post_per_user = $my_db->query("SELECT * FROM posts WHERE user_id = {$_SESSION['user_id']}");
                                    echo  "<div class='huge'>{$select_post_per_user->num_rows}</div>";
                                
                                    ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $select_user_posts_comments = $my_db->query("SELECT * FROM posts INNER JOIN comments ON comments.comment_post_id = posts.post_id AND posts.user_id =" . $_SESSION['user_id'] . "");
                                        echo  "<div class='huge'>{$select_user_posts_comments->num_rows}</div>"
                                    ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comment.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $select_cat_per_user = $my_db->query("SELECT * FROM categories WHERE user_id = {$_SESSION['user_id']}");
                                    echo  "<div class='huge'>{$select_cat_per_user->num_rows}</div>";
                                    ?>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-------------- /.row -------------->                  
            <?php
                $category_count_all =  $my_db->query("SELECT * FROM categories WHERE user_id =" . $_SESSION['user_id'] . "");
                $category_count=$category_count_all->num_rows;
                $post_count_all = $my_db->query("SELECT * FROM posts WHERE user_id =" . $_SESSION['user_id'] . "");
                $post_count = $post_count_all->num_rows;
                $comment_count_all = $my_db->query("SELECT * FROM posts INNER JOIN comments ON comments.comment_post_id = posts.post_id AND posts.user_id =" . $_SESSION['user_id'] . "");
                $comment_count = $comment_count_all->num_rows;
                $posts_query_result =$my_db->query("SELECT * FROM posts WHERE post_status = 'published' AND user_id =" . $_SESSION['user_id'] . "");
                $post_published_count = $posts_query_result->num_rows;                                  
                $draft_posts_query = $my_db->query("SELECT * FROM posts WHERE post_status = 'draft' AND user_id =" . $_SESSION['user_id'] . "");
                $post_draft_count = $draft_posts_query->num_rows;

                $unapproved_comment_query = $my_db->query("SELECT * FROM posts INNER JOIN comments ON comments.comment_post_id = posts.post_id AND posts.user_id =" . $_SESSION['user_id'] . " AND comments.comment_status = 'unapproved'");
                $unapproved_comment_count = $unapproved_comment_query->num_rows;
            ?>
            <div class="row">
                                
                <script type="text/javascript">
                    google.load("visualization", "1.1", {packages:["bar"]});
                    google.setOnLoadCallback(drawChart);
                    function drawChart(){
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],       
                            <?php                                   
                                $element_text = ['All Posts','Active Posts','Draft Posts', 'All Comments','Approved Comments','Unapproved Comments', 'Categories'];       
                                $element_count = [$post_count,$post_published_count, $post_draft_count, $comment_count,$comment_count - $unapproved_comment_count ,$unapproved_comment_count, $category_count];
                                for($i =0;$i < 7; $i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                }                                                        
                            ?>        
                        ]);

                        const options = {
                            chart: {
                            title: '',
                            subtitle: '',
                            }
                        };
                        const chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                        chart.draw(data, options);
                    }
                </script>                             
            <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>     
    <!-- /#page-wrapper -->
<div>
<!-- /#id-wrapper -->  
<?php include "includes/footer.php" ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script>
    $(document).ready(function(){
        const pusher =   new Pusher('a202fba63a209863ab62', {
            cluster: 'us2',
            encrypted: true
        });
        const notificationChannel =  pusher.subscribe('notifications');
        notificationChannel.bind('new_user', function(notification){
            const message = notification.message;
            toastr.success(`${message} just registered`);
        });
    });
</script>
