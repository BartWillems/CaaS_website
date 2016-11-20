<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Computers</title>
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
    include_once('php_functions/connection.php');
    include_once('navbar.php');
?>
    <!-- Page Content -->
    <div class="container">
    <?php
    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true){
    ?>
    <div class="modal fade" id="add-computer-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <h1>Add a computer</h1><br>
                <div id="form_fields">
                    <input type="text" id="container_name" name="container_name" placeholder="Computer name">
                    <input type="password" id="password" name="container_name" placeholder="Password">
                    <input type="password" id="password_repeat" name="container_name" placeholder="Repeat password">
                </div>
                <input type="submit" name="submit" class="login loginmodal-submit" value="Add Computer" id="addComputerBtn">
                <br>
                <div id="addComputerResult"></div>
            </div>
        </div>
    </div>
        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Computers</h1>
            </div>
        </div>
        <!-- /.row -->
        <?php include_once('message_display.php'); ?>
        <!-- Projects Row -->
        <div id="containers">
            <div class="row" id="firstRow">
                <div class="col-md-4 portfolio-item">
                    <a href="#" data-toggle="modal" data-target="#add-computer-modal">
                        <div class="container_preview" id="container_preview_base">
                            <div class="container_preview_overlay">
                                <span class="glyphicon glyphicon-plus add_container_btn" aria-hidden="true"></span>
                            </div>
                        </div>
                    </a>
                    <h3>
                        <a href="#">Add a Computer</a>
                    </h3>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <hr>

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
    <!-- MyJS -->
    <script>
    $(document).ready(function(){
        var $window = $(window).bind('resize', function(){
            var height = $('#container_preview_base').width() / 1.75;
            $('.container_preview').height(height);
        }).trigger('resize');
    });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/javascript.js"></script>
    <script src="js/computerManager.js"></script>

</body>

</html>
