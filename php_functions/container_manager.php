<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['request'])){
    switch($_POST['request']){
        case 'request_all_for_user':
            if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];
                echo json_encode(getAllContainersByUser($username));
            }
            break;
    }
}

if(isset($_GET['start'])){
    startContainer($_GET['name'], $_GET['port']);
}

function startContainer($name, $port){
    if(!isset($_SESSION['username'])){
        http_response_code(500);
        return 'UNAUTHORIZED';
    }
    $name = escapeshellcmd($name);
    $port = escapeshellcmd($port);
    exec("bash /usr/local/bin/containerManager.sh --action start --containerName $name --containerPort $port", $output, $returnValue);
    if($returnValue != 0){
        $_SESSION['error'] = "Something went wrong while starting the container... error code: $returnValue";
        header('Location: computers.php');
    }
    header('Location: /computers/' . $port  . '/vnc.html');
}

function stopContainer($name, $port){
    if(!isset($_SESSION['username'])){
        http_response_code(500);
        return 'UNAUTHORIZED';
    }
    if($_SESSION['username'] ==  getContainerUsernameById($port) || $_SESSION['username'] == 'admin'){
        $name = escapeshellcmd($name);
        $port = escapeshellcmd($port);
        exec("bash /usr/local/bin/containerManager.sh --action start --containerName $name --containerPort $port", $output, $returnValue);
        if($returnValue != 0){
            http_response_code(500);
            return "Something went wrong while starting the container... error code: $returnValue";
        }
        return true;
    } else {
        http_response_code(500);
        return 'UNAUTHORIZED';
    }
}

function getContainerUsernameById($port){
    if(!isset($_SESSION['username'])){
        http_response_code(500);
        return 'UNAUTHORIZED';
    }
    @include_once('connection.php');
    if(!isset($mysqli)){
        return 'Database error';
    }
    $stmt = $mysqli->prepare('SELECT username FROM containers WHERE container_id = ?');
    $stmt->bind_param('i', $port);
    if(!$stmt->execute()){
        $stmt->close();
        $mysqli->close();
        return 'Unable to fetch data';
    }
    $stmt->bind_result($username_db);
    while($stmt->fetch()){
        $username = $username_db;
    }
    $stmt->free_result();
    $stmt->close();
    $mysqli->close();
    return $username;
}

function getAllContainersByUser($username = -1){
    @include_once('connection.php');
    if($username === -1){
        echo json_encode("false");
    } else {
        $stmt = $mysqli->prepare('SELECT container_id, container_name, fq_container_name FROM containers WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($container_id, $container_name, $fq_container_name);
        $containers = array();

        $count = 0;
        while($stmt->fetch()){
            $containers[$count]['container_id']     =$container_id;
            $containers[$count]['container_name']   =$container_name;
            $containers[$count]['fq_container_name']=$fq_container_name;
            $count++;
        }

        $stmt->free_result();
        $stmt->close();
        $mysqli->close();

        return $containers;
    }
}

?>
