<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * index.php gestión de controladores y de sesión general en todo el juego
*/

#Elementos globales
session_start();
require('core/models/class.Connect.php');
require('core/libs/SmartyEngine/Smarty.class.php');
require('lang/es.php');

if (isset($_GET['core'],$_SESSION['user']) and file_exists("core/controllers/".$_GET['core']."Controller.php")) {
    
    $id_user = $_SESSION['id'];
    $id_planet = $_SESSION['id_planet'];
    include("core/controllers/".$_GET['core']."Controller.php");
    $class = $_GET['core'] . 'Controller';
    $view = $class::xnova();
    
} else if ((!isset($_GET['core']) and isset($_SESSION['user'])) or 
           (isset($_GET['core']) and isset($_SESSION['user']) 
            and !file_exists("core/controllers/".$_GET['core']."Controller.php"))) {
    include("core/controllers/overviewController.php");
    $view = overviewController::xnova();
} else if (isset($_GET['core'],$_GET['mode']) and !isset($_SESSION['user'])) {
    include("core/controllers/indexController.php");
    $view = indexController::xnova();
} else {
    include("core/controllers/indexController.php");
    $view = indexController::xnova();
}

?>