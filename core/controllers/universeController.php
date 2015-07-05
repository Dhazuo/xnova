<?php

class universeController {
    
    private static $instance;
    private $system_id;
    
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
            
        $db = new Connect();
        $sql = $db->query("SELECT sistema FROM planetas WHERE id_planeta='$id_planet' LIMIT 1;");    
        $system = $db->recorrer($sql);
        $db->liberar($sql);
        if(isset($_GET['sistema']) and is_numeric($_GET['sistema']) 
           and $_GET['sistema'] > 0 and $_GET['sistema'] <= 700) {
            $this->system_id = intval($_GET['sistema']);
        } else {
            $this->system_id = intval($system['sistema']);
        } 
        unset($system,$sql);
        
        $x = 1;
        while ($x<16) {
            $sql = $db->query("SELECT SQL_BIG_RESULT DISTINCT id_planeta, pos, nombre, imagen, usuario, id_dueno 
            FROM planetas JOIN usuarios 
            ON planetas.id_dueno=usuarios.id WHERE sistema='$this->system_id' 
            AND pos='$x' ORDER BY pos ASC LIMIT 1;");
            $rec = $db->recorrer($sql);
            $o_s = "&o=$x&s=$this->system_id";
            $db->liberar($sql);
             if($x != $rec['pos']) {
                    if($x == 1 or $x == 5 or $x == 9 or $x == 13) {
                        $universe[] = array(
                            'posicion' => $x,
                            'nombre' => 'Brecha',
                            'imagen' => 'brecha_espacio',
                            'usuario' => 'Agujero de gusano',
                            'escombros' => 'no_in',
                            'luna' => 'no_in',
                            'habitado' => 'deshabitado',
                            'accion' => '<a href=\'?core=fleets&mision=saltar'. $o_s .'\'>'. $lng->x_saltar .'</a>'
                        );                         
                    } else {
                       $universe[] = array(
                            'posicion' => $x,
                            'nombre' => 'Planeta Habitable',
                            'imagen' => 'planeta_desconocido',
                            'usuario' => 'La atmósfera es apta para colonizar',
                            'escombros' => 'no_in',
                            'luna' => 'no_in',
                            'habitado' => 'deshabitado',
                            'accion' => '<a href=\'?view=flotas&mision=colonizar'. $o_s .'\'>'. $lng->x_colonizar .'</a>'
                        );   
                    }
                } else {
                    if($rec['id_dueno'] == $id_user and $rec['id_planeta'] != $id_planet ) {
                       $universe[] = array(
                        'posicion' => $rec['pos'],
                        'nombre' => $rec['nombre'],
                        'imagen' => $rec['imagen'],
                        'usuario' => $rec['usuario'],
                        'escombros' => 'no_es',
                        'luna' => 'no_es',     
                        'habitado' => 'habitado',
                        'accion' => '<a href=\'?view=flotas&mision=transportar'. $o_s .'\'>'. $lng->x_transportar .'</a> |
                                    <a href=\'?view=flotas&mision=desplegar'. $o_s .'\'>'. $lng->x_desplegar .'</a>'
                        );
                    } else if ($rec['id_planeta'] == $id_planet and $rec['id_dueno'] == $id_user) {
                        $universe[] = array(
                        'posicion' => $rec['pos'],
                        'nombre' => $rec['nombre'],
                        'imagen' => $rec['imagen'],
                        'usuario' => $rec['usuario'],
                        'escombros' => 'no_es',
                        'luna' => 'no_es',     
                        'habitado' => 'habitado',
                        'accion' => '<br />'. $lng->x_no_hay .''
                        ); 
                    } else {
                        $universe[] = array(
                        'posicion' => $rec['pos'],
                        'nombre' => $rec['nombre'],
                        'imagen' => $rec['imagen'],
                        'usuario' => $rec['usuario'],
                        'escombros' => 'no_es',
                        'luna' => 'no_es',     
                        'habitado' => 'habitado',
                        'accion' => '<a href=\'?view=flotas&mision=transportar'. $o_s .'\'>'. $lng->x_transportar .'</a> |
                                    <a href=\'?view=flotas&mision=desplegar'. $o_s .'\'>'. $lng->x_desplegar .'</a> | <br /> 
                                    <a href=\'?view=flotas&mision=tomar_recursos'. $o_s .'\'>'. $lng->x_tomar_recursos .'</a> |  
                                    <a href=\'?view=flotas&mision=defender'. $o_s .'\'>'. $lng->x_defender .'</a> <br />
                                    <a href=\'?view=flotas&mision=espiar'. $o_s .'\'>'. $lng->x_espiar .'</a> |
                                    <a href=\'?view=flotas&mision=atacar'. $o_s .'\'>'. $lng->x_atacar .'</a> |
                                    <a href=\'?view=flotas&mision=sac'. $o_s .'\'>'. $lng->x_sac .'</a>'
                        ); 
                    }
              }
            $x++; //bucle increment
        }
        $template = new Smarty();
        $template->assign(array(
            'sistema' => $this->system_id,
            'x_ir' => $lng->x_ir,
            'x_anterior' => $lng->x_anterior,
            'x_siguiente' => $lng->x_siguiente,
            'x_orbita' => $lng->x_orbita,
            'x_planeta' => $lng->x_planeta,
            'x_emperador' => $lng->x_emperador,
            'x_accion' => $lng->x_accion,
            'universe' => $universe
        ));
        $template->display('universe/universe.xnv');
        unset($x,$template);
    } 
    
    public static function xnova() {
        if(!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
}

?>