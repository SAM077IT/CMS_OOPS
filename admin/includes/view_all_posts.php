<?php
include "delete_modal.php";

if(isset($_POST['checkBoxArray'])){
    foreach(($_POST['checkBoxArray']) as $posts_id){
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options){
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$posts_id}";
                $update_status_as_published = mysqli_query($conn, $query);
                confirmQuery($update_status_as_published);
            break;    

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$posts_id}";
                $update_status_as_draft = mysqli_query($conn, $query);
                confirmQuery($update_status_as_draft);
            break; 

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$posts_id}";
                $delete_post_as_bulk = mysqli_query($conn, $query);
                confirmQuery($delete_post_as_bulk);
            break; 

            case 'Clone':
                $query = "SELECT * FROM posts WHERE post_id = {$posts_id}";
                $clone_posts_query = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($clone_posts_query)){
                    $post_creator = $row['post_creator'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                    $post_date = $row['post_date'];
                }

                $query = "INSERT INTO posts (post_category_id, post_title, post_creator, post_date, post_image, post_content, post_tags, post_status) VALUES({$post_category_id}, '{$post_title}', '{$post_creator}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

                $create_clone_post_query = mysqli_query($conn, $query);
    
                confirmQuery($create_clone_post_query);

            break;    
        }
    }
}
?>

<form action="" method="post">

    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px">
            <select class="form-control" name="bulk_options" id="">
                <Option value="">Select Options</Option>
                <Option value="published">Publish</Option>
                <Option value="draft">Draft</Option>
                <Option value="delete">Delete</Option>
                <Option value="Clone">Clone</Option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_posts">Add New</a>
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Post Id</th>
                <th>Post Creator</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comment Count</th>
                <th>Date</th>
                <th>View Count</th>
                <th>view</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>                
        <tbody>
            <?php
            if($_SESSION['user_role'] == 'Admin'){

                //$query = "SELECT * FROM posts ORDER BY post_id DESC";
$query = "SELECT posts.post_id, posts.post_creator, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_date, posts.post_view_count, ";
$query .= "categories.cat_id, categories.cat_title ";
$query .= "FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY post_id DESC";
            }else{
$query = "SELECT posts.post_id, posts.post_creator, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_date, posts.post_view_count, ";
$query .= "categories.cat_id, categories.cat_title ";
$query .= "FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE posts.post_creator='{$_SESSION['firstname']}' ORDER BY post_id DESC";
            }
                $selectAllPosts = mysqli_query($conn, $query);
                $post_row_num = mysqli_num_rows($selectAllPosts);
                if($post_row_num == NULL){
                    echo "<script>alert('You do not have any post!!');</script>";
                    //echo "";
                }else{
                while($row = mysqli_fetch_assoc($selectAllPosts)){
                    $post_id = $row['post_id'];
                    $post_creator = $row['post_creator'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_date = $row['post_date'];
                    $post_view_count = $row['post_view_count'];
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<tr>";
                    echo "<th><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value={$post_id}></th>";
                    echo "<td>$post_id</td>";
                    echo "<td>$post_creator</td>";
                    echo "<td>$post_title</td>";

                    // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                    // $select_post_cat = mysqli_query($conn, $query);
                    // while($row = mysqli_fetch_assoc($select_post_cat)){
                    //     $cat_id = $row['cat_id'];
                    //     $cat_title = $row['cat_title'];
                    echo "<td>$cat_title</td>";
                    // }
                    echo "<td>$post_status</td>";
                    echo "<td><img width=100 src='../images/$post_image' alt='image'></td>";
                    echo "<td>$post_tags</td>";

                    $query_comm = "SELECT * FROM comments WHERE comment_post_id=$post_id";
                    $sent_comment_qu = mysqli_query($conn, $query_comm);
                    $count_comment = mysqli_num_rows($sent_comment_qu);
                    
                    echo "<td>$count_comment</td>";
                    echo "<td>$post_date</td>";
                    echo "<td>$post_view_count</td>";
                    echo "<td><a class='btn btn-primary' href ='../post.php?p_id={$post_id}'>View</a></td>";
                    echo "<td><a class='btn btn-primary' href ='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="post_id" value = "<?php echo $post_id; ?>">
                        <?php echo '<td><input onClick=\"javascript: return confirm("Are you SURE you want to delete this post?")\" class="btn btn-danger delete-link" type="submit" name ="delete" value="Delete"></td>';?>
                        
                    </form>
                    <?php
                    //echo "<td><a rel='$post_id' href='javascript:void(0)' class='btn btn-primary delete-link'>Delete</a></td>";
                    //echo "<td><a onClick=\"javascript: return confirm('Are you SURE you want to delete this post?')\" class='btn btn-primary' href ='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "</tr>";
                }
            }
            ?>                        
        </tbody>
    </table>
</form>

<?php 

if(isset($_POST["delete"])){
    if(isset($_SESSION['user_role'])){
        
        $the_post_id = $_POST["post_id"];
        echo $the_post_id;
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
        $delete_post_query = mysqli_query($conn, $query);
        Header("Location: ./posts.php");

    }
}
?>

<script>
    $(document).ready(function(){
        $(".delete-link").on('click', function(){

           //const id = $(this).attr("rel");
           
           //const delete_url = "posts.php?delete="+ id +"";

           $(".modal-delete").attr("href", "./posts.php");

           $("#myModal").modal('show');
        });

    });
</script>

