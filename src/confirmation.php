<?php
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $email = $_GET['email'];
    $key = $_GET['key'];
    $result = $mysqli->query('SELECT `key` FROM users WHERE email = "' . $email . '" AND key = "' . $key . '"');
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $mysqli->query('UPDATE users SET `valid` = 1 WHERE email = "' . $email . '"');
            header('Location: /index.php');
        }
    } else {
        echo 'Invalid verification key.';
    }
}
?>
