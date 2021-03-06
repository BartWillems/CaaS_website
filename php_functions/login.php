<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('connection.php');
include('sanitizer.php');
$_SESSION['error'] = '';
if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['password'])){
        $_SESSION['error'] = 'Both login and password fields are required';
    } else {
        $username = sanitize($_POST['username']);
        $password = $_POST['password'];

        $stmt = $mysqli->prepare('SELECT password FROM users WHERE username = ? ORDER BY username LIMIT 1');
        $stmt->bind_param('s', $username);

        if(!$stmt->execute()){
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            $_SESSION['error'] = 'Database error';
            header('location: index.php');
        }
        $stmt->store_result();
        $stmt->bind_result($password_verify);

        $auth = false;
        while($stmt->fetch()){
            //  Received password, password from db
            if(password_verify($password,$password_verify)){
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['username'] = $username;
                $_SESSION['result'] = "Welcome, $username";
                $auth = true;
            } else {
                $_SESSION['error'] = 'Incorrect username or password.';
            }
        }

        if(!$auth){
            $_SESSION['error'] = 'Incorrect username or password.';
        }

        $stmt->free_result();
        $stmt->close();
        $mysqli->close();
    }
    if (isset($_SESSION['page'])){
        $page = str_replace('"', '', $_SESSION['page']);
        header("location: $page");
    } else {
        header('location: index.php');
    }
}

?>
