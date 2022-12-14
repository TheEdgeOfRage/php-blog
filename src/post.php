<?php
require_once 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>New Post</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/post.css">
        <link rel="icon" href="favicon.png">

        <script type="text/javascript" src="/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: "textarea"
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row links">
                <div class="col-sm-1 col-md-1" id="index">
                    <a href="index.php"><center><span class="glyphicon glyphicon-home"></span></center>Home</a>
                </div>
                <?php
                    echo '
                        <div class="col-sm-1 col-md-1" id="profile">
                            <a href="profile.php?id='.$_SESSION['userid'].'"><center><span class="glyphicon glyphicon-user"></span></center>Profile</a>
                        </div>
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7"></div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="username">
                            ' . $_SESSION['username'] . '
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <a href="logout.php"><center><span class="glyphicon glyphicon-log-out"></span></center>Logout</a>
                        </div>';
                ?>
            </div>

            <p>Write a new post</p>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="row">
                    <div class="col-sm-10">
                        <input type="text" name="title">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <textarea name="text" rows="8"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7"></div>
                    <div class="col-sm-3">
                        <input type="submit" value="Post" id="submit">
                    </div>
                </div>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST"){
                    $title = $_POST['title'];
                    $text = $_POST['text'];
                    $sqlquery = '';

                    if($title || $text) {
                        $sqlquery = 'INSERT INTO `posts` (`Title`,`Text`,`Date`,`User_id`) VALUES ("'.$title.'","'.$text.'","'.date('y-m-d H:i').'",'.$_SESSION['userid'].')';

                        if($mysqli->query($sqlquery)) {
                            echo '<p id="success">Post successfull!</p>';
                            sleep(2);
                            header('Location: index.php');
                        } else {
                            echo '<p>Error '.$mysqli->errno . ': ' . $mysqli->error.'</p>';
                        }
                    } else {
                        echo 'Please fill in both fields';
                    }
                }
            ?>
        </div>
    </body>
</html>
