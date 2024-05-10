<?php 

if(isset($_GET['p_id'])){
$edit_post_id = escape($_GET['p_id']);
}

$query = "SELECT * FROM posts WHERE post_id = $edit_post_id";
$selectPostsById = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($selectPostsById)){
    $post_id = $row['post_id'];
    $post_author = $row['post_creator'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_comment_count	= $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_view_count = $row['post_view_count'];
    

// echo "<tr>";
//     echo "<td>$post_id</td>";
//     echo "<td>$post_author</td>";
//     echo "<td>$post_title</td>";
//     echo "<td>$post_category_id</td>";
//     echo "<td>$post_status</td>";
//     echo "<td><img width=100 src='../images/$post_image' alt='image'></td>";
//     echo "<td>$post_tags</td>";
//     echo "<td>$post_comment_count</td>";
//     echo "<td>$post_date</td>";
//     echo "<td><a href ='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
//     echo "<td><a href ='posts.php?delete={$post_id}'>Delete</a></td>";
// echo "</tr>";
}
$query_get_cat = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                $select_post_cat = mysqli_query($conn, $query_get_cat);
                while($row = mysqli_fetch_assoc($select_post_cat)){
                    $cat_id_pre = $row['cat_id'];
                    $cat_title_pre = $row['cat_title'];
                }
if(isset($_POST["update-post"])){

    $post_title = escape($_POST["title"]);
    $post_category_id = escape($_POST["post-category"]);
    $post_author = escape($_POST["author"]);
    $post_status = escape($_POST["status"]);

    $post_image = $_FILES["image"]["name"];
    $post_image_temp = $_FILES["image"]["tmp_name"];

    $post_tags = escape($_POST["post-tags"]);
    $post_content = escape($_POST["post-content"]);
    $post_view_count = escape($_POST["post_view_count"]);

    move_uploaded_file($post_image_temp, "../images/$post_image");
    if(empty($post_image)){
        $query = "SELECT * FROM posts WHERE post_id = $edit_post_id";
        $select_image = mysqli_query($conn, $query);
        confirmQuery($select_image);
        while($row = mysqli_fetch_array($select_image)){
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .="post_title = '{$post_title}', ";
    $query .="post_category_id = '{$post_category_id}', ";
    $query .="post_date = now(), ";
    $query .="post_creator = '{$post_author}', ";
    $query .="post_status = '{$post_status}', ";
    $query .="post_tags = '{$post_tags}', ";
    $query .="post_content = '{$post_content}', ";
    $query .="post_image = '{$post_image}', ";
    $query .="post_view_count = '{$post_view_count}' ";
    $query .="WHERE post_id = {$post_id} ";

    $update_post = mysqli_query($conn, $query);

    confirmQuery($update_post);

    echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id={$edit_post_id}'>View Post</a> OR <a href='posts.php'>View all posts</a></p>";
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="post-category">Post Category</label>
        <select name="post-category" id="">
            <?php 
                $query = "SELECT * FROM categories";
                $edit_query = mysqli_query($conn, $query);
                confirmQuery($edit_query);

                while($row = mysqli_fetch_array($edit_query)){
                    $edit_cat_id = $row['cat_id'];
                    $edit_cat_title = $row['cat_title'];
                    if($edit_cat_id == $cat_id_pre){
                        echo "<option selected value='$edit_cat_id'>{$edit_cat_title}</option>";
                    }else{
                        echo "<option value='$edit_cat_id'>{$edit_cat_title}</option>";
                    } 
                }  
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" value="<?php echo $post_author; ?>" class="form-control" name="author">
    </div>
    <div class="form-group">
        <label for="status">Post Status</label>
        <select name="status" id="">
            <option value= "Draft"><?php echo $post_status; ?></option>
            <?php 
            if($post_status == "Draft"){
                echo "<option value='Published'>Published</option>";
            }
            else{
                echo "<option value='Draft'>Draft</option>";
            }           
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image"></label>
        <img src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post-tags">
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea type="text" id="summernote" class="form-control" name="post-content" cols="30" rows="10"><?php echo $post_content; ?>
        </textarea>
    </div>
    <div class="form-group">
        <label for="post_view_count"> Want to reset Post View Count</label>
        <select name="post_view_count" id="">
            <option value= <?php echo $post_view_count; ?>><?php echo $post_view_count; ?></option>
            <option value= 0 ><?php echo 0; ?></option>
        </select>
        <br>
        <input type="submit" class="btn btn-primary" name="update-post" value="Publish Post">
    </div>
</form>