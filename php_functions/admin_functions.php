<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function setPortRange($begin_port=-1, $end_port=-1){
    if(($begin_port == -1 || $end_port == -1) || ($end_port < $begin_port)){
        $_SESSION['error'] = 'Invalid port range';
    } else {
        include_once('connection.php');
        $port_range = "$begin_port-$end_port";
        $stmt = $mysqli->prepare('UPDATE configuration SET port_range=? WHERE 1=1');
        $stmt->bind_param('s', $port_range);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }
}

?>
