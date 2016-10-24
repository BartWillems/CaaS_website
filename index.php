<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <?php
    include_once('meta_includes.php');
    ?>
</head>

<body id="home_body">
<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['page'] = $_SERVER['PHP_SELF'];
    }
    include_once('navbar.php');
?>
    <!-- Page Content -->
    <div id="home_screen_banner">
        <div class="container">
            <?php include_once('message_display.php'); ?>
            <h1 class="page_title">Welcome to C.a.a.S.</h1>
            <h2 class="page_subtitle">The first free and open-source 'Computer as a Service' service</h2>
        </div>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/javascript.js"></script>

</body>

</html>
