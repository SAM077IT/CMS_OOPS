
<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>
    <form action="/cms_oops/search" method="post">
        <div class="input-group">
            <input type="text" name="search" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit" name="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form> <!--Search form -->
</div>

<!-- Blog Login Well -->
<div class="well">
    <?php if(isset($_SESSION['user_role'])):?>
        <h4>Logged in as <?php echo $_SESSION['username'];?></h4>
        <a href="/cms_oops/includes/logout.php" class="btn btn-primary">Logout</a>
    <?php else: ?>
    <h4>Login</h4>
    <form action="/cms_oops/login" method="post">
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <span class="input-group-btn">
            <button class="btn btn-primary" style="margin-right:50px" name="login" type="submit">Login</button>
            <button class="btn btn-primary"><a style="color:#FAEBD7" href="forgot_password.php">Forgot Password</a></button>
        </span>
    </form> <!--Login form -->
    <?php endif; ?>
</div>

<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-unstyled">
            <?php
                
                $selectAllCat = $my_db->query("SELECT * FROM categories");
                while($row = $selectAllCat->fetch_assoc()){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                }                
            ?>            
            </ul>
        </div>
    </div>
</div>