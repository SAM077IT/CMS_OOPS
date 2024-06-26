<?php 
if(isset($_POST["create-post"])){

    $post_title = escape($_POST["title"]);
    $post_category_id = escape($_POST["post-category"]);
    $post_creator = escape($_SESSION['username']);
    $post_status = escape($_POST["status"]);
    $user_id = $_SESSION['user_id'];
    $post_image = $_FILES["image"]["name"];
    $post_image_temp = $_FILES["image"]["tmp_name"];

    $post_tags = escape($_POST["post-tags"]);
    $post_content = escape($_POST["post-content"]);
    $post_date = date("d-m-y");
    $post_comment_count = 0;
    $post_view_count = 0;
    move_uploaded_file($post_image_temp, "../images/$post_image");

    $my_db->query("INSERT INTO posts (user_id, post_category_id, post_title, post_creator, post_date, post_image, post_content, post_tags, post_comment_count, post_status, post_view_count) VALUES({$user_id}, {$post_category_id}, '{$post_title}', '{$post_creator}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', {$post_comment_count}, '{$post_status}', {$post_view_count})");

    echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id={$my_db->conn->insert_id}'>View Post</a> OR <a href='posts.php'>View all posts</a></p>";
}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="post-category">Post Category</label>
        <select name="post-category" id="">
            <?php //echo $post_category_id; 
                $edit_query = $my_db->query("SELECT * FROM categories");

                while($row = $edit_query->fetch_assoc()){
                    $edit_cat_id = $row['cat_id'];
                    $edit_cat_title = $row['cat_title'];

                    echo "<option value='$edit_cat_id'>{$edit_cat_title}</option>";
                }          
            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div> -->
    <div class="form-group">
        <select name="status" id="">
            <option value="Draft">Post Status</option>
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>
        </select>
    </div>        
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="post-tags">
    </div>
    <div class="form-group">
        <label for="summernote">Content</label>
        <textarea type="text" class="form-control" id="summernote" name="post-content" cols="30" rows="10">
        </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create-post" value="Publish Post">
    </div>

</form>