<?php
/**
 * We just want to hash our password using the current DEFAULT algorithm.
 * This is presently BCRYPT, and will produce a 60 character result.
 *
 * Beware that DEFAULT may change over time, so you would want to prepare
 * By allowing your storage to expand past 60 characters (255 would be good)
 */
if(isset($_POST['submit'])){
	include('connection.php');
	session_start();
	$_SESSION['error'] = '';

	if(isset($_POST['username'])) {
		$username = $_POST['username'];
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
	
	$stmt = $mysqli->prepare("SELECT username FROM users WHERE username=? LIMIT 1");
	
	$stmt->bind_param('s', $username);
	$stmt->execute($stmt);
	
    $count = 0;
    while($stmt->fetch()){
        $count++;
    }
    if($count>0){
        $_SESSION['error'] = 'Error, username is not available.';
    } else {
	    if(empty($_SESSION['error'])) {
	        // Saul Goodman
	        $password_hash = password_hash("$password", PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO users(username,password) VALUES (?,?)");
            $stmt->bind_param("ss",$username,$password_hash);
            $stmt->execute();
            $_SESSION['result'] = 'Successfully registered! You may now log in.';
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
