<?php
require_once 'header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $data = $mysqli->query('SELECT `id`, `password`, `valid` FROM users WHERE username = "' . $username . '"');

    if (mysqli_num_rows($data) > 0) {
        $row = $data->fetch_assoc();
        if($row['password'] == $password){
            if($row['valid'] == 1){
                $_SESSION['username'] = $username;
                $_SESSION['userid'] = $row['id'];
                header('Location: /index.php');
            } else {
                echo '<br>Please validate your email address first';
            }
        } else {
            echo '<br>Wrong username or password';
        }
    } else {
        echo '<br>No account with that username, please <a href="register.php">register</a> first';
    }
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/login.css">
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

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        Username:
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <input type="text" name="username">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        Password:
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <input type="password" name="password">
                    </div>
                </div>
                <div class="row finish">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="forgotten">
                        <a href="forgot.php">Forgot your password?</a>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <input type="submit" value="Login" id="submit">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
