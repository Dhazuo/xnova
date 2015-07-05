<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * overview Controller: controlador de la visión general del juego
*/

class overviewController {    
    
    private static $instance;
    
    private function __construct() {
    
        require('core/models/class.User.php');
        require('core/models/implement.Menu.php');
        require('core/models/class.Planet.php');
        require('core/models/implement.Topnav.php');
        
        global $id_user, $id_planet;  
        
        $lng = new Lang();
        $menu = new Menu($id_user);
        $topnav = new Topnav($id_planet,$id_user);
        $user = new User($id_user);
        $planet = new Planet($id_planet);        
                
        require('core/functions/class.UpdateStats.php');
        $update = new UpdateStats();
        
        $db = new Connect();
        $sql = $db->query("SELECT COUNT(*) id FROM usuarios;");
        $total_rank = $db->recorrer($sql);
        $db->liberar($sql);
        $db->close();
        $template = new Smarty();
        $template->assign(array(
            'usuario_email' => $user->UserEmail(),
            'usuario_faccion' => $user->UserFaction(),
            'usuario_puntos' => $user->UserPoints(),
            'usuario_top' => $user->TopUser(),
            'total_rank' => number_format($total_rank[0],'0',',','.'),
            'campos' => $planet->PlanetFields(),
            'diametro' => $planet->PlanetDiameter(),
            'temperatura' => $planet->PlanetTemperature(),
            'p' => $planet->PlanetOrbit(),
            's' => $planet->PlanetSystem(),
            'nombre_planeta' => $planet->PlanetName(),
            'imagen_planeta' => $planet->PlanetImage()
        ));
        $template->display('overview/overview.xnv');
    }
    
    public static function xnova() {
        if(!self::$instance instanceof self) {
            self::$instance = new self;
        } 
        return self::$instance;
    }
    
}

?>