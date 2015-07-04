<?php

$v = isset($_GET['view']) ? $_GET['view'] : null;

switch($v) {
    case 'reloj':
        $hora = date('G:m:s a',time());
        echo $hora;
    break;
    default:    
        header('location: ?core=index');
    break;
}

?>