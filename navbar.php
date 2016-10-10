<?php
session_start();
?>
<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<h1>Login to Your Account</h1><br>
			<form method="post" action="register.php">
                <div id="form_fields">
				    <input type="text" name="username" placeholder="Username">
				    <input type="password" name="password" placeholder="Password">
                </div>
				<input type="submit" name="submit" class="login loginmodal-submit" value="Login">
			</form>
			<div class="login-help">
				<a href="#" id="register">Register</a>
			</div>
		</div>
	</div>
</div>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Start Bootstrap</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
            <ul class="nav navbar-nav" id="custom_navbar_register">
                <li>
                    <?php
                        if(isset($_SESSION['auth'])) {
                            if($_SESSION['auth'] == true) {
                            ?>
                                <a href="logout.php">Logout</a>
                            <?php
                            }
                        }
                    ?>
                    <a href="#" data-toggle="modal" data-target="#login-modal">Login or Register</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
