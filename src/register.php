<?php
require_once 'header.php';
require_once 'mail.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordconf = $_POST['passwordconf'];
    $name = $_POST['name'];

    if (empty($email) || empty($username) || empty($password))
        echo '<br>Please fill in all required fields';
    elseif ($password != $passwordconf)
        echo '<br>Passwords do not match';
    else {
        $key = '';
        for ($i=0; $i < 16; $i++)
            $key = $key . rand(0,9);

        $password = sha1($password);
        $sql = 'INSERT INTO `users` (`username`, `email`, `password`, `name`, `key`) VALUES ("' . $username . '", "' . $email . '", "' . $password . '", "' . $name . '", "' . $key . '")';
        if ($mysqli->query($sql) === TRUE) {
            if($m = sendMail($email, $key)) {
                $m->Subject = 'RageBlog Email Confirmation';
                $m->Body = '<html><head><title>RageBlog Email Confirmation</title></head><body><p>Click the following link to confirm your email address:</p><p><a href = "http://theedgeofrage.noip.me/confirmation.php?email=' . $email . '&key=' . $key . '">Confirm</a></p></body></html>';
                $m->AltBody = 'Copy the following link into your ULR bar to confirm your email address: http://theedgeofrage.noip.me/confirmation.php?email=' . $email . '&key=' . $key;
                if($m->send())
                    echo '<br>Confirmation mail sent, check your inbox for instructions';
                else
                    echo '<br>Error sending Email';
            } else
                echo '<br>Error: ' . $conn->error;
        } else
            echo 'Invalid Email address';
    }
    die();
}
// mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/register.css">
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
                        Name:
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="text" name="name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        Email:*
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="text" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        Username:*
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="text" name="username">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        Password:*
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="password" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        Confirm pass:*
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="password" name="passwordconf">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <input type="submit" value="Register">
                    </div>
                </div>
            </form>
            <p>* Required Fields</p>
        </div>
    </body>
</html>
