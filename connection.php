 <?php
 $servername = 'localhost';
 $username = 'CaaS_admin';
 $password = 'toor';
 $database = 'CaaS';

 // Create connection
 $mysqli = mysqli_connect($servername, $username, $password, $database);

 // Check connection
 if (!$mysqli) {
    die('Connection failed: ' . mysqli_connect_error());
 }
 ?> 
