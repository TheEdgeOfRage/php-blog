<?php
require_once 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/profile.css">
        <link rel="icon" href="favicon.png">
    </head>
    <body>
        <div class="container">
            <div class="row links">
                <div class="col-sm-1 col-md-1" id="index">
                    <a href="index.php"><center><span class="glyphicon glyphicon-home"></span></center>Home</a>
                </div>
                <div class="col-sm-1 col-md-1" id="profile">
                    <a href="profile.php"><center><span class="glyphicon glyphicon-user"></span></center>Profile</a>
                </div>
                <?php
                    if(!isset($_SESSION['userid'])){
                        echo '
                            <div class="col-sm-1 col-md-1" id="login">
                                <a href="login.php"><center><span class="glyphicon glyphicon-log-in"></span></center>Login</a>
                            </div>
                            <div class="col-sm-1 col-md-1" id="register">
                                <a href="register.php"><center><span class="glyphicon glyphicon-registration-mark"></span></center>Register</a>
                            </div>';
                    } else {
                        echo '
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <a href="post.php">
                                    <div id="newpost"><p><span class="glyphicon glyphicon-pencil" id="newglyph"></span>New Post</p></div>
                                </a>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5"></div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="username">
                                ' . $_SESSION['username'] . '
                            </div>
                            <div class="col-sm-1 col-md-1" id="login">
                                <a href="logout.php"><center><span class="glyphicon glyphicon-log-out"></span></center>Logout</a>
                            </div>';
                    }
                ?>
            </div>

            <div class="col-sm-1"></div>

            <div id="posts" class="col-sm-10">
                <?php
                    $id = $_GET['id'];
                    $data = mysqli_query($mysqli, 'SELECT `username` FROM users WHERE `id` = '.$id);
                    $row = $data->fetch_assoc();
                    $username = $row['username'];
                    echo '<p id="title">'.$username.'\'s Posts</p>';

                    $sqlquery = 'SELECT `post_id`, `user_id`, `title`, `text`, `date`, `username` FROM posts JOIN users u ON user_id = u.id WHERE user_id = \''.$id.'\'ORDER BY `date` DESC';
                    $data = $mysqli->query($sqlquery);
                    if (mysqli_num_rows($data) > 0) {
                        while($row = $data->fetch_assoc()) {
                            if($id == $_SESSION['userid']) {
                                echo '<a href="edit.php?id='.$row['post_id'].'" class="btn btn-info btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit</a>';
                            }
                            echo '
                                <div class="post-title">
                                    <p>'.$row['title'].'<span class="date">'.$row['date'].'</span></p>
                                </div>
                                <div class="post-text">
                                    '.$row['text'].'
                                    <a href="profile.php?id=\''.$row['user_id'].'\'" class="author">'.$row['username'].'</a>
                                </div>';
                        }
                    } else {
                        echo 'User has not submitted any posts yet';
                    }
                ?>
            </div>
        </div>
    </body>
</html>
