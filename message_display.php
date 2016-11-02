<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
    $error_msg = $_SESSION['error'];
    echo '<br>';
    echo '<div class="alert alert-danger">';
        echo "<strong>Whoops!</strong> $error_msg";
    echo '</div>';
    $_SESSION['error'] = NULL;
}
if(isset($_SESSION['result']) && !empty($_SESSION['result'])){
    $result_msg = $_SESSION['result'];
    echo '<br>';
    echo '<div class="alert alert-success">';
        echo $result_msg;
    echo '</div>';
    $_SESSION['result'] = NULL;
}
?>
