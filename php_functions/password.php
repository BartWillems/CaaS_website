<?php
error_reporting(-1);
ini_set('display_errors', 'On');
if(isset($_POST['submit'])){
    session_start();
    $_SESSION['errors'] = '';
    $username = $_SESSION['username'];
    if(isset($_POST['pwd']) && isset($_POST['new_pwd']) && isset($_POST['rep_pwd'])) {
        if($_POST['new_pwd'] == $_POST['rep_pwd']) {
            @include('connection.php');

            $password = $_POST['pwd'];
            $stmt = $mysqli->prepare('SELECT password FROM users WHERE username = ? ORDER BY username LIMIT 1');
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($password_verify);

            $auth = false;
            while($stmt->fetch()){
                //  Received password, password from db
                if(password_verify($password,$password_verify)){
                    $auth = true;
                } else {
                    $_SESSION['error'] = 'Incorrect password.';
                }
            }
            $stmt->close();
            if($auth){
                $password = $_POST['new_pwd'];
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $mysqli->prepare('UPDATE users SET password = ? WHERE username = ?');
                $stmt->bind_param('ss',$password_hash, $username);
                if($stmt->execute()){
                    //Success
                    $_SESSION['result'] = 'Your password has been succesfully changed!';
                } else {
                    //No Success
                    $_SESSION['error'] = 'Something went wrong.';
                }
            }
            $stmt->close();
            $mysqli->close();
        } else {
            $_SESSION['error'] = 'The passwords you entered do not match';
        }
    } else {
        $_SESSION['error'] = 'All fields must be entered.';
    }
    header('location: ../account_settings.php');
}
