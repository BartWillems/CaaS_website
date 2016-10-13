<?php
function sanitize($string){
    return str_replace("\\","\\\\",strip_tags($string));
}

?>
