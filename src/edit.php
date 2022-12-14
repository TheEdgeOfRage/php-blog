<?php
require_once 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Post</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/edit.css">
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

            <?php
                if($_SERVER['REQUEST_METHOD'] == "GET") {
                    $id = $_GET['id'];

                    $sqlquery = 'SELECT `Title`, `Text` FROM posts WHERE `Post_id` = '.$id;
                    $data = $mysqli->query($sqlquery);
                    $row = $data->fetch_assoc();

                    $title = $row['Title'];
                    $text = $row['Text'];
                }
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $title = $_POST['title'];
                    $text = $_POST['text'];
                }
            ?>

            <p>Edit your post</p>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="row">
                    <div class="col-sm-10">
                        <input type="text" name="title" value="<?php echo $title;?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <textarea name="text" rows="8"><?php echo $text;?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7"></div>
                    <div class="col-sm-3">
                        <input type="submit" value="Post" id="submit">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                    </div>
                </div>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $id = $_POST['id'];
                    $data = $mysqli->query('SELECT `id` FROM users u JOIN posts ON user_id = u.id WHERE post_id = '.$id);
                    $row = $data->fetch_assoc();
                    if ($row['id'] == $_SESSION['userid']) {
                        if($title && $text) {
                            $sqlquery = 'UPDATE posts SET `title`="'.$title.'",`text` = "'.$text.'" WHERE `post_id` = '.$id;

                            if ($mysqli->query($sqlquery) === TRUE) {
                                echo '<br><p id="success">Post edited successfully!</p>';
                                sleep(2);
                                header('Location: index.php');
                            } else {
                                echo '<br><div id="error">Error: ' . $sqlquery . '<br>' . $mysqli->error . '</div>';
                            }
                        } else {
                                echo '<p id="error">Please fill in both fields<p>';
                        }
                    } else {
                        echo '<p id="error">This is not your post</p>';
                    }
                }
            ?>
        </div>
    </body>
</html>
