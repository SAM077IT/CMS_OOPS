<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php if($session->isAdmin()){ ?>
            <a class="navbar-brand" href="/cms_oops/admin/">CMS Admin</a>
        <?php }else{ ?>
            <a class="navbar-brand" href="/cms_oops/admin/dashboard.php">CMS Admin</a>
        <?php } ?>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="">Users Online: <span class="usersonline"></span></a></li>
        <li><a href="../index">Home Page</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php if($session->is_signed_in()){ echo " ". $session->username; }?>
            <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="/cms_oops/admin/dashboard.php"><i class="fa fa-fw fa-dashboard"></i>My Data</a>
            </li>
            <?php if($session->isAdmin()):?>
                <li>
                    <a href="/cms_oops/admin/"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
            <?php endif; ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown">
                    <i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="./posts.php">View All Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_posts">Add Post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>
            <li>
                <a href="./comment.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <?php if($session->isAdmin()):?>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo">
                        <i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="./users.php">View All Users</a>
                        </li>
                        <li>
                            <a href="users.php?source=add_user">Add User</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <li>
                <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>