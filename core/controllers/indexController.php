<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * index Controller: controlador de registro, login y clave perdida
*/

class indexController {
   
    private static $instance;
    
    private function __construct() {
        $mode = isset($_GET['mode']) ? $_GET['mode'] : false;
        require('core/models/class.Access.php');
        switch($mode) {
            case 'login':
                $login = new Access();
                $login->Login();
            break;
            case 'reg':
                if(isset($_POST['faccion'])) {
                    $reg = new Access();
                    $reg->Register();
                } else {
                    $lng = new Lang();
                    $template = new Smarty();
                    $template->caching = true;
                    $template->assign(array(
                        'x_user' => $lng->x_user,
                        'x_pass' => $lng->x_pass,
                        'x_email' => $lng->x_email,
                        'x_registrarme' => $lng->x_registrarme
                    ));
                    $template->display('public/registro.xnv'); 
                }
            break;
            default:
                $lng = new Lang();
                $template = new Smarty();
                $template->caching = true;
                $template->assign(array(
                    'x_user' => $lng->x_user,
                    'x_pass' => $lng->x_pass,
                    'x_recordar' => $lng->x_recordar,
                    'x_submit' => $lng->x_submit
                ));
                $template->display('public/index.xnv');
            break;
        }

        unset($lng,$template);
    }
    
    public static function xnova() {
        if(!self::$instance instanceof self) {
            self::$instance = new self;
        } 
        return self::$instance;
    }
    
}

?>