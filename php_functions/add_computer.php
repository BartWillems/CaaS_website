<?php
if(isset($_POST['addComputer'])){
    if(isset($_POST['container_name'])){
        echo json_encode(addContainer($_POST['container_name']));
    }
}

function addContainer($container_name){
    $dbResult = addContainerToDB($container_name);
    if($dbResult['success'] === true){
       $port = $dbResult['port'];
    } else {
       return $dbResult;
    }

}

function addContainerToDB($container_name = -1){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['username'])){
        include('sanitizer.php');
        $username = sanitize($_SESSION['username']);
        $container_name = sanitize($container_name);
    } else {
        http_response_code(500);
        return 'UNAUTHORIZED';
    }


    if($container_name === -1){
        http_response_code(500);
        return 'Input error; check your parameters';
    } else {
        $container_id = findAvailablePort();
        if(!is_numeric($container_id)){
            http_response_code(500);
            return $container_id; //the id is an error string from findAvailablePort in this case
        } else {
            include('connection.php');
            $fq_container_name = "dorowu/ubuntu-desktop-lxde-vnc-$username-$container_id";

            $stmt = $mysqli->prepare("SELECT container_name FROM containers WHERE username = ? AND container_name = ?");
            $stmt->bind_param('ss', $username, $container_name);
            if(!$stmt->execute()){
                http_response_code(500);
                $stmt->close();
                $mysqli->close();
                return 'Unable to execute statement';
            }
            $count = 0;
            while($stmt->fetch()){
                $count++;
            }

            if($count > 0) {
                http_response_code(500);
                $stmt->close();
                $mysqli->close();
                return 'You already have a container with that name';
            }


            $stmt = $mysqli->prepare("INSERT INTO containers(
                fq_container_name,username,container_name,container_id) 
                VALUES (?,?,?,?)");
            $stmt->bind_param("sssi",$fq_container_name, $username, $container_name, $container_id);
            if(!$stmt->execute()){
                http_response_code(500);
                $stmt->close();
                $mysqli->close();
                return 'Unable to execute statement';
            }
            $stmt->close();
            $mysqli->close();
            $result['success'] = true;
            $result['port'] = $container_id;
            return $result;
        }
    }
}

// Return either an available id/port or an error string
function findAvailablePort(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['username'])){
        return 'Unauthorized';
    }
    @include_once('connection.php');
    $stmt = $mysqli->prepare("SELECT container_id FROM containers");
    if(!$mysqli){
        return 'Database error';
    }
    $stmt->execute();
    $stmt->bind_result($container_id);
    $used_ports = array();
    while($stmt->fetch()){
        array_push($used_ports, $container_id);
    }
    $stmt->free_result();
    $stmt->close();

    $stmt = $mysqli->prepare('SELECT port_range FROM configuration LIMIT 1');
    $stmt->execute();
    $stmt->bind_result($port_range_db);
    while($stmt->fetch()){
        $port_range = explode('-',$port_range_db);
    }
    $stmt->close();
    $mysqli->close();

    /* return $port_range; */

    if(empty($used_ports)){
        return $port_range[0];
    }

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
