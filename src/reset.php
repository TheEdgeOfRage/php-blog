<?php
require_once 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="icon" href="favicon.png">
    </head>
    <body>
        <div class="container">
            <div class="row links">
                <div class="col-sm-1 col-md-1" id="index">
                    <a href="index.php"><center><span class="glyphicon glyphicon-home"></span></center>Home</a>
                </div>
                <div class="col-sm-1 col-md-1" id="login">
                    <a href="login.php"><center><span class="glyphicon glyphicon-log-in"></span></center>Login</a>
                </div>
                <div class="col-sm-1 col-md-1" id="register">
                    <a href="register.php"><center><span class="glyphicon glyphicon-registration-mark"></span></center>Register</a>
                </div>
            </div>

            <form action="reset.php" method="post" accept-charset="utf-8">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <input id="password" type="password" name="password" placeholder="Please enter your new password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <input id="passwordconf" type="password" name="passwordconf" placeholder="Confirm your new password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <center><input type="submit" value="Reset Password"></center>
                        <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
                        <input type="hidden" name="key" value="<?php echo $_GET['key'];?>">
                    </div>
                </div>
            </form>

            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST') {

                    if($_POST['password'] == $_POST['passwordconf']) {
                        $sqlquery = 'UPDATE users SET `password`="'.sha1($_POST['password']).'" WHERE `email` = "'.$_POST['email']. '" AND `key` = "'.$_POST['key'].'"';
                        if ($mysqli->query($sqlquery) === TRUE) {
                            echo 'Password successfully reset. Please log in to condinue';
                        } else {
                            echo 'Something went wrong';
                        }
                    } else {
                        header('Location: reset.php?email='.$_POST["email"].'&key='.$_POST["key"].'&error=1');
                    }
                } else if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['error']) {
                    echo 'Passwords do not match, try again';
                }
            ?>
        </div>
    </body>
</html>
