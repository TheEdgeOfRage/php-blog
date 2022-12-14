<?php
require_once 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
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
                                    <div id="newpost"><span class="glyphicon glyphicon-pencil" id="newglyph"></span>New Post</div>
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
                    <div class="col-sm-1 col-md-1">
                        <a href="logout.php"><center><span class="glyphicon glyphicon-log-out"></span></center>Logout</a>
                    </div>';
                    }
                ?>
            </div>

            <div class="col-sm-1"></div>

            <div id="posts" class="col-sm-10">
                <?php
                    $sqlquery = 'SELECT `user_id`, `title`, `text`, `date`, `username` FROM posts JOIN users u ON user_id = u.id ORDER BY `date` DESC';
                    $data = $mysqli->query($sqlquery);
                    while($row = $data->fetch_assoc()) {
                        echo '
                        <div class="post-title">
                            <p>'.$row['title'].'<span class="date">'.$row['date'].'</span></p>
                        </div>
                        <div class="post-text">
                            '.$row['text'].'
                            <a href="profile.php?id='.$row['user_id'].'" class="author">'.$row['username'].'</a>
                        </div>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>
