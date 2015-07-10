<?php

define('BUILD_TIMES', 1);

function FormatTimes($segs) {
    $cadena = '';
        
    if($segs >= 86400) {
        $dias = floor($segs / 86400);
        $segs = $segs % 86400;
        $cadena = $dias.'d';
        if($segs >= 0) { $cadena .= ':'; }
    }
    
    if($segs >= 3600){
        $horas = floor($segs / 3600);
        $segs = $segs % 3600;
        $cadena .= $horas.'h';
        if($segs >= 0) { $cadena .= ':'; }
    }

    if($segs >= 60){
        $minutes = floor($segs / 60);
        $segs = $segs % 60;
        $cadena .= $minutes.'m';
        if($segs >= 0) { $cadena .= ':'; }
    }

    $cadena .= $segs . 's';
    return $cadena;    
} 

function BuildTime($metal,$cristal,$nano_lvl) {
    $time = (($metal + $cristal) / (BUILD_TIMES * 2500)) * (1 / ((1 + $nano_lvl) * pow(1.1,$nano_lvl))); 
    $time = floor(($time * 60 * 60));
    return $time;
}

function BuildPrice($metal,$cristal,$tritio,$materia,$factor,$lvl) {
    $metal = $metal == 0 ? 0 : floor($metal + pow($factor,$lvl));
    $cristal = $cristal == 0 ? 0 : floor($cristal + pow($factor,$lvl));
    $tritio = $tritio == 0 ? 0 : floor($tritio + pow($factor,$lvl));
    $materia = $materia == 0 ? 0 : floor($materia + pow($factor,$lvl));
    $price = array($metal,$cristal,$tritio,$materia);
    return $price;
}

function TechRequeriments($item,$compare) {
    if(array_key_exists('tech',$item)) {
        $technology = 0;
        foreach($item['tech'] as $tech => $level) {
            if($item['name'] == 'planta_energia' or $item['name'] == 'reactor_fusion') {
                $compare[$tech] == $level ? $technology = $technology : ++$technology;
            } else {
                $compare[$tech] >= $level ? $technology = $technology : ++$technology;
            }         
        }
    } else {
        $technology = 0;
    }
    
    if($technology > 0 or $item['name'] == 'almacen_materia' or $item['name'] == 'distribuidor' ) { 
        unset($technology);
        return false; 
    } else { 
        unset($technology);
        return true; 
    }
}

?>