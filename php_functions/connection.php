 <?php
 $servername = 'localhost';
 $db_username = 'CaaS_admin';
 $db_password = 'toor';
 $database = 'CaaS';

 // Create connection
 $mysqli = mysqli_connect($servername, $db_username, $db_password, $database);

 // Check connection
 if ($mysqli == NULL) {
    die('Connection failed: ' . mysqli_connect_error());
 }
 ?> 
