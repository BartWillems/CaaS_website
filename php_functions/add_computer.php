<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['error'] = NULL;
$_SESSION['result'] = NULL; 

if(isset($_POST['container_name'])){
    if(isset($_SESSION['username'])){
        include('sanitizer.php');
        $username = sanitize($_SESSION['username']);
        $container_name = sanitize($_POST['container_name']);
        addContainer($container_name, $username);
        if (isset($_SESSION['page'])){
            $page = str_replace('"', "", $_SESSION['page']);
            header("location: $page");
        } else {
            header("location: computers.php");
        }
    }
}

function addContainer($container_name = -1,  $username = -1){
    if($container_name === -1 || $username === -1){
        $_SESSION['error'] = 'Input error; check your parameters';
    } else {
        include_once('connection.php');

        $container_id = findAvailablePort();
        if(!is_numeric($container_id)){
            $_SESSION['error'] = $container_id; //the id is a string in this case
        } else {
            $fq_container_name = "dorowu/ubuntu-desktop-lxde-vnc-$username-$container_id";

            $stmt = $mysqli->prepare("SELECT container_name FROM containers WHERE username = ?");
            $stmt->bind_param('s', $container_name_db);
            while($stmt->fetch()){
                $_SESSION['error'] = 'You already have a container with that name';
            }

            if($_SESSION['error'] == NULL){
                $stmt = $mysqli->prepare("INSERT INTO containers(
                    fq_container_name,username,container_name,container_id) 
                    VALUES (?,?,?,?)");
                $stmt->bind_param("sssi",$fq_container_name, $username, $container_name, $container_id);
                $stmt->execute();
                $stmt->close();
                $mysqli->close();
                $_SESSION['result'] = 'Successfully registered! You may now log in.';
            }
        }
    }
}

// Return either an available id/port or an error string
function findAvailablePort(){
    include_once('connection.php');
    $stmt = $mysqli->prepare("SELECT container_id FROM containers");
    $stmt->execute();
    $stmt->bind_result($container_id);
    $used_ports = array();
    while($stmt->fetch){
        array_push($used_ports, $container_id);
    }
    $stmt->free_result();
    $stmt->close();

    $stmt = $mysqli->prepare('SELECT port_range FROM configuration LIMIT 1');
    $stmt->execute();
    $stmt->bind_result($port_range_db);
    while($stmt->fetch){
        $port_range = explode("-",$port_range_db);
    }
    $stmt->close();
    $mysqli->close();

    $begin_port = $port_range[0];
    $end_port = $port_range[1];
    for($i = $begin_port; $i<$end_port; $i++){
        if(!in_array($i, $used_ports)){
            return $i;
        }
    }

    return 'No more ports available, ask your admin to extend the port range!';
}

?>
