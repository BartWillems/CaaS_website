<?php
if(isset($_POST['submit'])){
    include('connection.php');
    include('sanitizer.php');
    session_start();
    $_SESSION['error'] = '';

    if(isset($_POST['username'])) {
        $username = sanitize(strtolower($_POST['username']));
    } else {
        $_SESSION['error'] = "username is empty";
    }

    if(isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $_SESSION['error'] = "password is empty";
    }

    if(isset($_POST['password_match'])) {
        $password_match = $_POST['password_match'];
    } else {
        $_SESSION['error'] = "passwords don't match";
    }

    if(!$mysqli){
        $_SESSION['error'] = 'Database error';
        if (isset($_SESSION['page'])){
            $page = str_replace('"', "", $_SESSION['page']);
            header("location: $page");
        } else {
            header("location: index.php");
        }
    }

    $stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ? LIMIT 1");

    $stmt->bind_param('s', $username);
    if(!$stmt->execute()){
        $stmt->close();
        $mysqli->close();
        $_SESSION['error'] = 'Unexpected database error';
        if (isset($_SESSION['page'])){
            $page = str_replace('"', "", $_SESSION['page']);
            header("location: $page");
        } else {
            header("location: index.php");
        }
    } else {
        $count = 0;
        while($stmt->fetch()){
            $count++;
        }
    }

    if($count>0){
        $_SESSION['error'] = 'Error, username is not available.';
    } else {
        if(empty($_SESSION['error'])) {
            // Saul Goodman
            // password_hash with  the parameter PASSWORD_DEFAULT generates a 60character bcrypt string with the salt included
            $password_hash = password_hash("$password", PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO users(username,password) VALUES (?,?)");
            $stmt->bind_param("ss",$username,$password_hash);
            if($stmt->execute()){
                $_SESSION['result'] = 'Successfully registered! Please wait for your administrator for approval.';
            } else {
                $_SESSION['error'] = 'Unexpected error while registering.';
            }
        }
    }
    $stmt->close();
    $mysqli->close();
    if (isset($_SESSION['page'])){
        $page = str_replace('"', "", $_SESSION['page']);
        header("location: $page");
    } else {
        header("location: index.php");
    }
}
