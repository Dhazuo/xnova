<?php

class provisionController {
    
    private static $instance;
    
    private function AddBuildToQueue($mode = true) {
        
    }
    
    private function __construct() {
        
        if(isset($_POST['construir'],$_GET['id'])) {
            $this->AddBuildToQueue();
        } else if(isset($_POST['destruir'],$_GET['id'])) {
            $this->AddBuildToQueue(false);
        } else {        
            require('core/models/class.User.php');
            require('core/models/implement.Menu.php');
            require('core/models/class.Planet.php');
            require('core/models/implement.Topnav.php');
            require('core/buildables.php');
            require('core/functions/GeneralFunctions.php');

            global $id_user, $id_planet;  

            $lng = new Lang();
            $menu = new Menu($id_user);
            $topnav = new Topnav($id_planet,$id_user);
            $user = new User($id_user);
            $planet = new Planet($id_planet); 

            foreach($provision as $id => $item) {

                $price = BuildPrice($item['metal'],$item['cristal'],$item['tritio'],
                                    $item['materia'],$item['price'],$planet->PlanetBuildsLeveles()[$item['name']]); 

                if($price[0] > 0 and $price[1] > 0 and $price[2] > 0 and $price[3] > 0) {
                   $precios = 'todos';   
                } else if ($price[0] == 0 and $price[1] == 0 and $price[2] == 0 and $price[3] == 0) {
                   $precios = 'ninguno';
                } else if ($price[0] > 0 and $price[1] == 0 and $price[2] == 0 and $price[3] == 0) {
                   $precios = 'metal'; 
                } else if ($price[0] > 0 and $price[1] > 0 and $price[2] == 0 and $price[3] == 0) {
                   $precios = 'metal_cristal'; 
                } else if ($price[0] > 0 and $price[1] > 0 and $price[2] > 0 and $price[3] == 0) {
                   $precios = 'metal_cristal_tritio'; 
                } else if ($price[0] > 0 and $price[1] == 0 and $price[2] == 0 and $price[3] > 0) {
                   $precios = 'metal_materia'; 
                } else if ($price[0] > 0 and $price[1] == 0 and $price[2] > 0 and $price[3] == 0) {
                   $precios = 'metal_tritio'; 
                } else if ($price[0] == 0 and $price[1] > 0 and $price[2] == 0 and $price[3] == 0) {
                   $precios = 'cristal';    
                } else if ($price[0] == 0 and $price[1] > 0 and $price[2] == 0 and $price[3] > 0) {
                   $precios = 'cristal_materia';
                } else if ($price[0] == 0 and $price[1] > 0 and $price[2] > 0 and $price[3] == 0) {
                   $precios = 'cristal_tritio'; 
                } else if ($price[0] == 0 and $price[1] > 0 and $price[2] > 0 and $price[3] > 0) {
                   $precios = 'cristal_tritio_materia'; 
                } else if ($price[0] == 0 and $price[1] == 0 and $price[2] > 0 and $price[3] == 0) {
                   $precios = 'tritio'; 
                } else if ($price[0] == 0 and $price[1] == 0 and $price[2] > 0 and $price[3] > 0) {
                   $precios = 'tritio_materia'; 
                } else if ($price[0] == 0 and $price[1] == 0 and $price[2] == 0 and $price[3] > 0) {
                   $precios = 'materia'; 
                }

                $requeriments = TechRequeriments($item,$planet->PlanetBuildsLeveles());

                if ($requeriments) {
                    $build = '<input type=\'submit\' class=\'construir\' name=\'construir\' value=\'\' />';
                    if($planet->PlanetBuildsLeveles()[$item['name']] > 0) {
                       $destroy = '<input type=\'submit\' class=\'destruir\' name=\'destruir\' value=\'\' />';   
                    } else {
                       $destroy = '<input type=\'submit\' class=\'destruir_no\' name=\'destruir\' value=\'\' />'; 
                    }

                    $image = $item['name'];
                } else {
                    if($item['name'] == 'almacen_materia' or $item['name'] == 'distribuidor') {
                        $image = $item['name'];
                    } else {
                        $image = $item['name'] . '_no';
                    }
                    $build = '';
                    $destroy = '';
                }

                $building[] = array(
                    'id' => $id,
                    'name' => $item['name'],
                    'image' => $image,
                    'build' => $build,
                    'destroy' => $destroy,
                    'nivel' => $planet->PlanetBuildsLeveles()[$item['name']],
                    'metal' => number_format($price[0],'0',',','.'),
                    'cristal' => number_format($price[1],'0',',','.'),
                    'tritio' => number_format($price[2],'0',',','.'),
                    'materia' => number_format($price[3],'0',',','.'),
                    'tiempo_c' => FormatTimes(BuildTime($price[0],$price[1],
                                                        $planet->PlanetBuildsLeveles()['nanobots'])),
                    'tiempo_d' => FormatTimes(BuildTime(($price[0] / 2), ($price[1] / 2),
                                                         $planet->PlanetBuildsLeveles()['nanobots'])),
                    'name_lng' => $lng->$item['name_lng'],
                    'desc_lng' => $lng->$item['desc_lng'],
                    'precios' => $precios
                );
                unset($precios,$price,$item,$id);
            }

            $template = new Smarty();
            $template->assign(array(
                'abastecimiento' => $lng->m_abastecimiento,
                'building' => $building
            ));
            $template->display('buildables/provision.tpl');
        }
    }
    
    public function xnova() {
        if(!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
}

?>