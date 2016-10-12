<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['request'])){
    switch($_POST['request']){
        case 'request_all_for_user':
            if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];
                getAllContainersByUser($username);
            }
            break;
    }
}

function getAllContainersByUser($username = -1){
    @include_once('connection.php');
    if($username === -1){
        echo json_encode("false");
    }
    $stmt = $mysqli->prepare("SELECT container_id, container_name, fq_container_name FROM containers WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($container_id, $container_name, $fq_container_name);
    $containers = array();

    $count = 0;
    while($stmt->fetch()){
        $containers[$count]["container_id"]     =$container_id;
        $containers[$count]["container_name"]   =$container_name;
        $containers[$count]["fq_container_name"]=$fq_container_name;
        $count++;
    }

    $stmt->free_result();
    $stmt->close();
    $mysqli->close();

    echo json_encode($containers);
}

?>
