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
    include_once('connection.php');
    include_once('navbar.php');
?>
    <!-- Page Content -->
    <div class="container">
	<?php
    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true){
	?>
        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Account Settings</h1>
            </div>
        </div>
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
