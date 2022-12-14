<?php
require_once 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/search.css">
        <link rel="icon" href="favicon.png">
    </head>
    <body>
        <div class="container">
            <div class="row links">
                <div class="col-sm-1 col-md-1" id="index">
                    <a href="index.php"><center><span class="glyphicon glyphicon-home"></span></center>Home</a>
                </div>
                <?php
                    if(!isset($_SESSION['userid'])) {
                        echo '
                            <div class="col-sm-1 col-md-1" id="login">
                                <a href="login.php"><center><span class="glyphicon glyphicon-log-in"></span></center>Login</a>
                            </div>
                            <div class="col-sm-1 col-md-1" id="register">
                                <a href="register.php"><center><span class="glyphicon glyphicon-registration-mark"></span></center>Register</a>
                            </div>
                            <div class="col-sm-1 col-md-1"></div>';
                    } else {
                        echo '
                            <div class="col-sm-1 col-md-1" id="profile">
                                <a href="profile.php?id='.$_SESSION['userid'].'"><center><span class="glyphicon glyphicon-user"></span></center>Profile</a>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <a href="post.php">
                                    <div id="newpost"><p><span class="glyphicon glyphicon-pencil" id="newglyph"></span>New Post</p></div>
                                </a>
                            </div>';
                    }
                ?>

                <form method="get" action="search.php">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="search" placeholder="Search for users or posts" id="searchbar">
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <input type="submit" value="Search" id="searchbutton">
                    </div>
                </form>

                <?php
                    if(isset($_SESSION['userid'])) {
                        echo '
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="username">
                                ' . $_SESSION['username'] . '
                            </div>
                            <div class="col-sm-1 col-md-1" id="login">
                                <a href="logout.php"><center><span class="glyphicon glyphicon-log-out"></span></center>Logout</a>
                            </div>';
                    }
                ?>
            </div>

            <ul class="nav nav-tabs">
                <li id="menu-posts" class="active"><a href="#">Posts</a></li>
                <li id="menu-users"><a href="#">Users</a></li>
            </ul>

            <div id="results">
                <div class="res-posts">
                    <?php
                        $sqlquery = 'SELECT `user_id`, `title`, `text`, `date`, `username` FROM posts JOIN users u ON user_id = u.id WHERE `title` LIKE "%' .$_GET['search']. '%"';
                        $data = $mysqli->query($sqlquery);
                        if (mysqli_num_rows($data) > 0) {
                            while($row = $data->fetch_assoc())
                                echo '
                                    <div class="post-title">
                                        <p>'.$row['title'].'<span class="date">'.$row['date'].'</span></p>
                                    </div>
                                    <div class="post-text">
                                        '.$row['text'].'
                                        <a href="profile.php?id='.$row['user_id'].'" class="author">'.$row['username'].'</a>
                                    </div>';
                        } else {
                            echo '<p>No post found</p>';
                        }
                    ?>
                </div>
                <div class="res-users">
                    <?php
                        $sqlquery = 'SELECT `Id`, `Name`, `Username` FROM users WHERE Username LIKE "%'.$_GET['search'].'%" ORDER BY `Username` ASC';
                        $data = mysqli_query($mysqli, $sqlquery);
                        if (mysqli_num_rows($data) > 0) {
                            do {
                                echo '<div class="row">';
                                for ($i=0; $i < 3 && $row = $data->fetch_assoc(); $i++) {
                                    echo '
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <a href="profile.php?id='.$row['id'].'">
                                                <div class="user">
                                                        <div class="name">'.$row['name'].'</div>
                                                        <div class="username">'.$row['username'].'</div>
                                                </div>
                                            </a>
                                        </div>';
                                }
                                echo '</div>';
                            } while($row = $data->fetch_assoc());
                        } else {
                            echo '<p>No user found</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <script src="//code.jquery.com/jquery.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="js/search.js"></script>
    </body>
</html>
