<?php

if(isset($_POST['getPortRange'])){
    echo json_encode(getPortRange());
}

if(isset($_POST['setPortRange'])){
    if(isset($_POST['beginPort']) && isset($_POST['endPort'])){
        echo json_encode(setPortRange($_POST['beginPort'], $_POST['endPort']));
    } else {
        echo json_encode('Invalid input');
    }
}

function getPortRange(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin'){
        http_response_code(500);
        return 'UNAUTHORIZED';
    }

    include_once('connection.php');
    if(!$mysqli){
        http_response_code(500);
        return 'Database error';
    }
    $stmt = $mysqli->prepare('SELECT port_range FROM configuration LIMIT 1');
    if(!$stmt->execute()){
        http_response_code(500);
        $stmt->close();
        $mysqli->close();
        return 'Database execution error';
    }
    $stmt->bind_result($port_range_result);
    $port_range = array();
    while($stmt->fetch()){
        $port_range_result = explode('-', $port_range_result);
        if(count($port_range_result) === 2){
            $port_range['begin_port'] = $port_range_result[0];
            $port_range['end_port']   = $port_range_result[1];
        } else {
            $port_range = NULL;
        }
    }

    if($port_range === NULL){
        http_response_code(500);
        $stmt->close();
        $mysqli->close();
        return 'Invalid port range';
    } else {
        $stmt->close();
        $mysqli->close();
        return $port_range;
    }

}

function setPortRange($begin_port=-1, $end_port=-1){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin'){
        http_response_code(500);
        return 'UNAUTHORIZED';
    }

    if(($begin_port == -1 || $end_port == -1) || ($end_port < $begin_port) || ($begin_port <= 1024)){
        http_response_code(500);
        return 'Invalid port range';
    } else {
        include_once('connection.php');
        if(!$mysqli){
            http_response_code(500);
            return 'Database error';
        }
        $port_range = "$begin_port-$end_port";
        $stmt = $mysqli->prepare('UPDATE configuration SET port_range=? WHERE 1=1');
        $stmt->bind_param('s', $port_range);
        if($stmt->execute()){
            $stmt->close();
            $mysqli->close();
            return true;
        } else {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            return 'Unable to execute statement';
        }
    }
}

?>
