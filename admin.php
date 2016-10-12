<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION['page'] = $_SERVER['PHP_SELF'];
}
if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin'){
    http_response_code(404);
    header("HTTP/1.0 404 Not Found");
    header("Location: 404.html");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <?php
    include_once('meta_includes.php');
    ?>
</head>

<body>
<?php
    include_once('connection.php');
    include_once('navbar.php');
?>
    <!-- Page Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Admin Panel</h1>
            </div>
        </div>
        <!-- /.row -->


    <?php include_once('footer.php'); ?>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/javascript.js"></script>

</body>

</html>
