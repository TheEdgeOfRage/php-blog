<?php
require_once 'header.php';
require_once 'mail.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Request Password reset</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/forgot.css">
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

            <div class="row text">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <center><p>Please insert your email address</p></center>
                </div>
            </div>

            <form action="forgot.php" method="post" accept-charset="utf-8">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <input id="textfield" type="text" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <center><input type="submit" value="Reset Password"></center>
                    </div>
                </div>
            </form>

            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if ($m = sendMail($_POST['email'])) {
                        $data = $mysqli->query('SELECT `key` FROM users WHERE email = "' . $_POST['email'] . '"');
                        $row = $data->fetch_assoc();

                        if(mysqli_num_rows($data) > 0){
                            $m->Subject = 'RageBlog password reset';
                            $m->Body = '<html><head><title>RageBlog password reset</title></head><body><p>Click the following link to reset your password:</p><p><a href = "http://theedgeofrage.noip.me/reset.php?email=' . $_POST['email'] . '&key=' . $row['key'] . '">Reset</a></p><p>If you have not requested a password reset, you can safely ignore this message and continue using your old password.</p></body></html>';
                            $m->AltBody = 'Copy the following link into your ULR bar to confirm your email address: http://theedgeofrage.noip.me/confirmation.php?email=' . $_POST['email'] . '&key=' . $row['key']. ' If you have not requested a password reset, you can safely ignore this message and continue using your old password.';
                            if($m->send()) {
                                echo '<br>Reset request sent, check your inbox and follow the instructions';
                            } else {
                                echo '<br>Error sending Email';
                            }
                        } else {
                            echo 'This email address is not registered';
                        }
                    } else {
                        echo 'Invalid Email address';
                    }
                }
            ?>
        </div>
    </body>
</html>
