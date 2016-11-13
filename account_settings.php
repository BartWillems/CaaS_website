<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account Settings</title>
    <?php
    include_once('meta_includes.php');
    ?>
</head>

<body>
<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['page'] = $_SERVER['PHP_SELF'];
    }
    include_once('navbar.php');
?>
    <!-- Page Content -->
    <div class="container">
	<?php
    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true){
	?>
    <!-- Page Header -->
    <?php include_once('message_display.php'); ?>
    <h1 class="page-header text">Account Settings</h1>
    <h3 class="text"> Change password </h3>
    <form method="POST" action="php_functions/password.php">
        <div class="form-group">
            <label for="pwd" class="text">Current Password:</label>
            <input type="password" placeholder="Enter your current password" class="form-control" id="pwd" name="pwd">
        </div>
        <br>
        <div class="form-group">
            <label for="new_pwd" class="text">New Password:</label>
            <input type="password" placeholder="Enter a new password" class="form-control" id="new_pwd" name="new_pwd">
        </div>
        <div class="form-group">
            <label for="rep_pwd" class="text">Repeat:</label>
            <input type="password" placeholder="Repeat your password" class="form-control" id="rep_pwd" name="rep_pwd">
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>
    <?php
    include_once('footer.php');
    } else {
    ?>
        <h1 class="page_title"> You need to be authenticated to see this page </h1>
    <?php
    }
    ?>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/javascript.js"></script>

</body>

</html>
