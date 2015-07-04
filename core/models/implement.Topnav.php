<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * class Topnav: implementa el Topnav
*/

class Topnav {
    
    public function __construct($id_planet,$id_user) {
            
        $planet = new Planet($id_planet,$id_user);
        $lng = new Lang();
        
        if ($planet->AlmacenMetal()['capacidad'] <= $planet->Metal()) {
            $metal = '<span style="color: red;">'. number_format($planet->Metal(),'0',',','.') . '</span>';
        } else {
            $metal = number_format($planet->Metal(),'0',',','.');
        }
        if ($planet->AlmacenCristal()['capacidad'] <= $planet->Cristal()) {
            $cristal = '<span style="color: red;">' . number_format($planet->Cristal(),'0',',','.') . '</span>';
        } else {
            $cristal = number_format($planet->Cristal(),'0',',','.');
        }
        if ($planet->AlmacenTritio()['capacidad'] <= $planet->Tritio()) {
            $tritio = '<span style="color: red;">' . number_format($planet->Tritio(),'0',',','.') . '</span>';
        } else {
            $tritio = number_format($planet->Tritio(),'0',',','.');
        }
        if ($planet->EnergiaSobrante() < 0) {
            $energia_sobrante = '<span style="color: red;">' . number_format($planet->EnergiaSobrante(),'0',',','.') . '</span>';
        } else {
            $energia_sobrante = number_format($planet->EnergiaSobrante(),'0',',','.');
        }
            $template = new Smarty();
            $template->caching = true;
            $template->assign(array(
            'm_general' => $lng->m_general,
            'm_abastecimiento' => $lng->m_abastecimiento,
            'm_infraestructura' => $lng->m_infraestructura,
            'm_comerciante' => $lng->m_comerciante,
            'm_tecnologia' => $lng->m_tecnologia,
            'm_hangar' => $lng->m_hangar,
            'm_defensas' => $lng->m_defensas, 
            'x_metal' => $lng->x_metal,
            'metal' => $metal,
            'x_cristal' => $lng->x_cristal,
            'cristal' => $cristal,
            'x_tritio' => $lng->x_tritio,
            'tritio' => $tritio,
            'x_energia' => $lng->x_energia,
            'energia_total' => number_format($planet->EnergiaTotal(),'0',',','.'),
            'energia_consumo' => number_format($planet->EnergiaConsumo(),'0',',','.'),
            'energia_sobrante' => $energia_sobrante,
            'x_materia' => $lng->x_materia,
            'x_mo' => $lng->x_mo,
            'materia' => number_format($planet->MateriaOscura(),'0',',','.'),
            'p' => $planet->PlanetOrbit(),
            's' => $planet->PlanetSystem(),
            'nombre_planeta' => $planet->PlanetName(),
            'imagen_planeta' => $planet->PlanetImage(),
            'x_actual' => $lng->x_actual,
            'x_capacidad' => $lng->x_capacidad,
            'x_produccion' => $lng->x_produccion,
            'x_consumo' => $lng->x_consumo,
            'almacen_cristal' => number_format($planet->AlmacenCristal()['capacidad'],0,',','.'),
            'almacen_metal' => number_format($planet->AlmacenMetal()['capacidad'],0,',','.'),
            'almacen_tritio' => number_format($planet->AlmacenTritio()['capacidad'],0,',','.'),
            'almacen_materia' => $lng->x_infinito  #AUN NO SE HA CREADO EN CLASS LANG EN 
        ));
        $template->display('overall/topnav.xnv'); 
    }
    
}

?>