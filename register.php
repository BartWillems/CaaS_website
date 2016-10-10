<?php
/**
 * We just want to hash our password using the current DEFAULT algorithm.
 * This is presently BCRYPT, and will produce a 60 character result.
 *
 * Beware that DEFAULT may change over time, so you would want to prepare
 * By allowing your storage to expand past 60 characters (255 would be good)
 */

if(isset($_POST['submit'])){
	include_once('connection.php');
	session_start();
	$_SESSION['error'] = '';
	
	// Check for existing user
	if ($stmt = mysqli_prepare($link, "SELECT username FROM users WHERE username=?")) {
	
		$username = "test";
	    /* bind parameters for markers */
	    mysqli_stmt_bind_param($stmt, "s", $username);
	
	    /* execute query */
	    mysqli_stmt_execute($stmt);
	
	    /* bind result variables */
	    mysqli_stmt_bind_result($stmt, $result);
	
	    /* fetch value */
	    mysqli_stmt_fetch($stmt);
	
	    /* close statement */
	    mysqli_stmt_close($stmt);
	}
	
	if(!empty($result)) {
	    $_SESSION['error'] = 'username already exists';
	} 
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
	
	// Saul Goodman
	if(empty($_SESSION['error'])) {
	    $password_hash = password_hash("$password", PASSWORD_DEFAULT);
		
		/* Prepared statement, stage 1: prepare */
		if (!($stmt = $mysqli->prepare("INSERT INTO users(username,password) VALUES (?,?)"))) {
		    $_SESSION['error'] = "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			header('Location: index.php');
		}
		
		/* Prepared statement, stage 2: bind and execute */
		if (!$stmt->bind_param("ss", $username, $password_hash)) {
		    $_SESSION['error'] = "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: index.php');
		}
		
		if (!$stmt->execute()) {
		    $_SESSION['error'] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: index.php');
		}
		
		/* explicit close recommended */
		$stmt->close();
		header('Location: index.php');
	} else {
		header('Location: index.php');
	}
}
