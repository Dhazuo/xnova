<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * class Mines: se encuentran las principales estructuras de producción de forma individual y cada una con su respectiva producción
*/
 
/*

FALTA QUE INFLUYA LA TECNOLOGÍA DE ENERGÍA A PARTIR DEL NIVEL 5, todavía no la programo por tanto aun no la incluyo.
FALTA CONFIGURACIÓN DE PORCENTAJES DE LA GESTIÓN DE RECURSOS

*/

class Mines {
    
    const RESOURCES_FACTOR = 1;
    const MINES_MULTIPLIER = 1; #MINES_MULTIPLIER * 2500
    
    private $prod_energia;
    private $factor_energia;
    private $prod_sobrante;
    private $prod_usado;
    private $energia_total;
    private $distribuidor;
    private $planta_solar;
    private $reactor_fusion;
    
    private $fuente_base;
    
    private $id; 
    private $temp_promd;
   
    private $mina_metal;
    private $mina_cristal;
    private $sintetizador;
    private $satelites;
    private $modulos;
    
    private $almacen_metal;
    private $almacen_cristal;
    private $almacen_tritio;
    private $almacen_materia;
    private $tiempo;
    
    private $metal_actual;
    private $cristal_actual;
    private $tritio_actual;
    
    private $cantidad_satelites;
    private $cantidad_modulos;
    
    private $campos;
    private $campos_usados;
    
    private static $nano_lvl;
    private static $hangar_lvl;
    
    /*
    * public function __construct 
    * $planeta es el ID del planeta al cual se le quiere extraer la información
    */
    public function __construct($id_planet) {
        $this->id = $id_planet;
        $db = new Connect();

        $sql = $db->query("SELECT edificios.fuente_base, edificios.planta_energia, edificios.reactor_fusion, 
        edificios.distribuidor, edificios.mina_metal, edificios.mina_cristal, edificios.mina_tritio, 
        edificios.almacen_metal, edificios.almacen_cristal, edificios.almacen_tritio, 
        edificios.satelites, edificios.modulos, edificios.nanobots, edificios.hangar, planetas.metal, planetas.cristal, planetas.tritio, 
        planetas.ultima_act, planetas.temp_promd, planetas.campos, planetas.campos_usados FROM edificios, planetas WHERE edificios.id_planeta='$this->id' 
        AND planetas.id_planeta='$this->id' LIMIT 1;");
        $dato = $db->recorrer($sql);
        
        $this->fuente_base = $dato['fuente_base'];
        $this->metal_actual = floor($dato['metal']);
        $this->cristal_actual = floor($dato['cristal']);
        $this->tritio_actual = floor($dato['tritio']);
        $this->temp_promd = $dato['temp_promd'];
        $this->cantidad_satelites = $dato['satelites'];
        $this->cantidad_modulos = $dato['modulos'];
        $this->campos = $dato['campos'];
        $this->campos_usados = $dato['campos_usados'];
        
        $this->nivel = array(
            'distribuidor' => $dato['distribuidor'],
            'solar' => $dato['planta_energia'],
            'reactor' => $dato['reactor_fusion'],
            'metal' => $dato['mina_metal'],
            'cristal' => $dato['mina_cristal'],
            'tritio' => $dato['mina_tritio'],
            'a_metal' => $dato['almacen_metal'],
            'a_cristal' => $dato['almacen_cristal'],
            'a_tritio' => $dato['almacen_tritio']
        );
        
        self::$nano_lvl = $dato['nanobots'];
        self::$hangar_lvl = $dato['hangar'];
        
        $tiempo = time() - $dato['ultima_act'];
        $this->tiempo = $tiempo; 
    }
    
    /*
    * static function TiempoConstruccion
    * $metal es coste en metal del elemento
    * $cristal es el coste en cristal del elemento
    * Función estática que se encarga de calcular el tiempo de construcción
    */
    public static function TiempoConstruccion($metal,$cristal) {
        $time = (($metal + $cristal) / (self::MINES_MULTIPLIER * 2500)) * (1 / ((1 + self::$nano_lvl) * pow(1.1,self::$nano_lvl))); 
        $time = floor(($time * 60 * 60));
        return $time;
    }
    
     /*
    * static function TiempoConstruccionHangar
    * $metal es coste en metal del elemento
    * $cristal es el coste en cristal del elemento
    * Función estática que se encarga de calcular el tiempo de construcción para los módulos y satélites
    */
    public static function TiempoConstruccionHangar($metal,$cristal) {
        $time = (($metal + $cristal) / (self::MINES_MULTIPLIER * 2500)) * (1 / ((2 + self::$hangar_lvl) * pow(1,self::$nano_lvl)));
        $time = floor(($time * 60 * 60));
        return $time;
    }
    
    /*
    * public function AlmacenMetal
    * $lng contiene información de idioma
    * Es el almacén de metal
    */
    public function AlmacenMetal() {
        
        $lng = new Lang();
 
        #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0 and $this->campos_usados < $this->campos) {
            $construible = true;
        } else {
            $construible = false;
        }
        
        if($this->nivel['a_metal'] == 0) {
            $capacidad = 10000;
            $metal_coste = 1000;
        } else {
            $capacidad = 10000 * pow(1.9,$this->nivel['a_metal']);
            $metal_coste = 1000 * pow(2,$this->nivel['a_metal']); 
        }
        
        $this->almacen_metal = array(
            'c_metal' => $metal_coste,
            'c_cristal' => 0,
            'c_tritio' => 0,
            'c_materia' => 0,
            'tiempo' => Mines::TiempoConstruccion($metal_coste,0),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_coste / 2),0),
            'nivel' => $this->nivel['a_metal'],
            'capacidad' => $capacidad,
            'construible' => $construible,
            'nombre' => $lng->x_almacen_metal[0],
            'desc' => $lng->x_almacen_metal[1]
        );
        
        return $this->almacen_metal;
    }
    
    /*
    * public function AlmacenCristal
    * $lng contiene información de idioma
    * Es el almacén de cristal
    */
    public function AlmacenCristal() {
        
         $lng = new Lang();
        
        #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0 and $this->campos_usados < $this->campos) {
            $construible = true;
        } else {
            $construible = false;
        }
        
        if($this->nivel['a_cristal'] == 0) {
            $capacidad = 10000;
            $metal_coste = 1500;
            $cristal_coste = 1000;
        } else {
            $capacidad = 10000 * pow(1.9,$this->nivel['a_cristal']);
            $metal_coste = 1500 * pow(1.869,$this->nivel['a_cristal']);
            $cristal_coste = 1000 * pow(1.78,$this->nivel['a_cristal']);  
        }
        
        $this->almacen_cristal = array(
            'c_metal' => $metal_coste,
            'c_cristal' => $cristal_coste,
            'c_tritio' => 0,
            'c_materia' => 0,
            'tiempo' => Mines::TiempoConstruccion($metal_coste,$cristal_coste),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_coste / 2),($cristal_coste / 2)),
            'nivel' => $this->nivel['a_cristal'],
            'capacidad' => $capacidad,
            'construible' => $construible,
            'nombre' => $lng->x_almacen_cristal[0],
            'desc' => $lng->x_almacen_cristal[1]
        );
        
        return $this->almacen_cristal;
    }
    
    /*
    * public function AlmacenTritio
    * $lng contiene información de idioma
    * Es el almacén de tritio
    */
    public function AlmacenTritio() {
        
        $lng = new Lang();
        
        #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0 and $this->campos_usados < $this->campos) {
            $construible = true;
        } else {
            $construible = false;
        }
        
        if($this->nivel['a_tritio'] == 0) {
            $capacidad = 10000;
            $metal_y_cristal_coste = 1000;
        } else {
            $capacidad = 10000 * pow(1.95,$this->nivel['a_tritio']);
            $metal_y_cristal_coste = 1000 * pow(2,$this->nivel['a_tritio']);            
        }  
        
        $this->almacen_tritio = array(
            'c_metal' => $metal_y_cristal_coste,
            'c_cristal' => $metal_y_cristal_coste,
            'c_tritio' => 0,
            'c_materia' => 0,
            'tiempo' => Mines::TiempoConstruccion($metal_y_cristal_coste,$metal_y_cristal_coste),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_y_cristal_coste / 2),($metal_y_cristal_coste / 2)),
            'nivel' => $this->nivel['a_tritio'],
            'capacidad' => $capacidad,
            'construible' => $construible,
            'nombre' => $lng->x_almacen_tritio[0],
            'desc' => $lng->x_almacen_tritio[1]
        );
        
        return $this->almacen_tritio; 
    }
    
    /*
    * public function AlmacenMateria
    * $lng contiene información de idioma
    * Es el almacén de materia oscura
    */
    public function AlmacenMateria() {
        
        $lng = new Lang();
        
        $this->almacen_materia = array(
            'c_metal' => 0,
            'c_cristal' => 0,
            'c_tritio' => 0,
            'c_materia' => 0,
            'nivel' => 1,
            'tiempo' => 0,
            'tiempo_destruccion' => 0,
            'construible' => false,
            'nombre' => $lng->x_almacen_materia[0],
            'desc' => $lng->x_almacen_materia[1]
        );
        
        return $this->almacen_materia; 
    }
    
    /*
    * public function SateliteSolar
    * $lng contiene información de idioma
    * Son los satélites solares
    */
    public function SateliteSolar() {
        
        $lng = new Lang();
        
        #Requisitos para poder construirlo
        if($this->nivel['solar'] > 2  and $this->nivel['reactor'] == 0) {
            $construible = true;
        } else {
            $construible = false;
        }
        
        $this->satelites = array(
            'c_metal' => 0,
            'c_cristal' => 1500,
            'c_tritio' => 500,
            'c_materia' => 0,
            'construible' => $construible,
            'tiempo' => Mines::TiempoConstruccionHangar(1500,500),
            'tiempo_destruccion' => 0,
            'nivel' =>  $this->cantidad_satelites,
            'nombre' => $lng->x_satelite_solar[0],
            'desc' => $lng->x_satelite_solar[1]
        );
        return $this->satelites;
    }
    
    /*
    * public function ModuloEnergia
    * $lng contiene información de idioma
    * Es el módulo acelerador que pertenece al reactor de fusión
    */
    public function ModuloEnergia() {
        
        $lng = new Lang();
        
        #Requisitos para poder construirlo
        if($this->nivel['reactor'] > 3 and $this->nivel['solar'] == 0)  {
            $construible = true;
        } else {
            $construible = false;
        }
        
        $this->modulos = array(
            'c_metal' => 1000,
            'c_cristal' => 1500,
            'c_tritio' => 500,
            'c_materia' => 0,
            'construible' => $construible,
            'tiempo' => Mines::TiempoConstruccionHangar(1000,1500),
            'tiempo_destruccion' => 0,
            'nivel' =>  $this->cantidad_modulos,
            'nombre' => $lng->x_modulo_acelerador[0],
            'desc' => $lng->x_modulo_acelerador[1]
        );
        return $this->modulos;
    }
    
    /*
    * public function PordEnergia
    * $lng contiene informacion de idioma
    * Se encarga de la producción de energía, el resultantes depende de la forma de obtención de energía del planeta
    * $this->fuente_base == 0 | Es la producción base del juego sin ninguna edificiación que produzca energía
    * $this->fuente_base == 1 | Es la producción de energía solar en un planeta, si esta existe, no existen más la base y tampoco la de reactores
    *      -> Sus extensiones son los satélites solares e influye la tecnología de energía, pero aún no la he programado.
    * $this->fuente_base == 2 | Es la producción de energía mediante reactores de fusión, de igual forma, si esta existe, no existen las demás
    *      -> Sus extensiones son los módulos e influye la tecnología de energía, pero aún no la he programado.
    */
    public function ProdEnergia() {
        
      $lng = new Lang();
      
      $consumo_metal = 10 * $this->nivel['metal'] * pow((1.1), $this->nivel['metal']);
      $consumo_cristal = 10 * $this->nivel['cristal'] * pow((1.1), $this->nivel['cristal']);
      $consumo_tritio = 20 * $this->nivel['tritio'] * pow((1.1), $this->nivel['tritio']);
                            
      if($this->fuente_base == 0) { #Producción de energia base
            $this->energia_total = 600;
            $this->consumo_tritio = 0;
            $this->prod_usado = floor($consumo_metal + $consumo_cristal + $consumo_tritio);
            $this->prod_sobrante = floor($this->energia_total - $this->prod_usado);
        } else if($this->fuente_base == 1) {  #Producción de energia mediante plantas solares
            
            if($this->temp_promd > 45 and $this->temp_promd <= 60 ) {
                if($this->temp_promd >= 57) {
                   $factor_e = 28;
                   $satelite_prod = 33;
                } else {
                   $factor_e = 25; 
                   $satelite_prod = 28; 
                } 
            } else if ($this->temp_promd > 25 and $this->temp_promd <= 45) {
                   $factor_e = 22;
                   $satelite_prod = 25;
            } else if ($this->temp_promd > 12 and $this->temp_promd <= 25) {
                   $factor_e = 19;
                   $satelite_prod = 22;
            } else if ($this->temp_promd > 1 and $this->temp_promd <= 12) {
                    if ($this->temp_promd <= 5) {
                       $factor_e = 14;
                       $satelite_prod = 19;
                    } else {
                       $factor_e = 15;
                       $satelite_prod = 20;
                    }         
            } else if ($this->temp_promd <= 1) {
                 $factor_e = 12;
                 $satelite_prod = 15;
            }   else {
                 $factor_e = 20;
                 $satelite_prod = 23;
            }
        
            $this->energia_total =  ($this->cantidad_satelites * $satelite_prod) + 600
                                    + floor(($factor_e * $this->nivel['solar'] * pow((1.1), $this->nivel['solar']))); 
            
            $this->consumo_tritio = 0;
            $this->prod_usado = floor($consumo_metal + $consumo_cristal + $consumo_tritio);
            $this->prod_sobrante = floor($this->energia_total - $this->prod_usado);          
        } else if($this->fuente_base == 2) { #Producción de energia mediante reactores de fusión
          
            if( $this->tritio_actual >= 1000) {
                $this->energia_total = ($this->cantidad_modulos * 30) + 600 + floor((40 * $this->nivel['reactor'] * pow((1.1), $this->nivel['reactor'])));
                $this->consumo_tritio = 5 * $this->nivel['reactor'] * pow((1.1), $this->nivel['reactor']);
                $this->prod_usado = floor($consumo_metal + $consumo_cristal + $consumo_tritio);
                $this->prod_sobrante = floor($this->energia_total - $this->prod_usado);
            } else if( $this->tritio_actual < 1000)  {
                /*
                    Cuando el tritio tiende a 1000 por la izquierda, es decir es aprox. 999.9999999... los módulos se desactivan
                    y la producción de energía baja a la mitad, de tal forma que el usuario debe ajustar la producción 
                    de sus otras minas para compensar energía
                */
                $this->energia_total = 600 + floor((20 * $this->nivel['reactor'] * pow((1.1), $this->nivel['reactor'])));
                $this->consumo_tritio = 0;
                $this->prod_usado = floor($consumo_metal + $consumo_cristal + $consumo_tritio);
                $this->prod_sobrante = floor($this->energia_total - $this->prod_usado); 
            }
        }  
           
        if($this->energia_total >= $this->prod_usado) {
            $this->factor_energia = 100;
        } else {
            $this->factor_energia = floor(($this->energia_total / $this->prod_usado) * 100);
        }
          
        if($this->factor_energia > 100) {
            $this->factor_energia = 100;
        } else if($this->factor_energia < 0) {
            $this->factor_energia = 0;
        }
        
        $this->prod_energia = array(
            'energia_sobrante' => $this->prod_sobrante, 
            'consumo_energia' => $this->prod_usado,
            'factor' => $this->factor_energia,
            'total' => $this->energia_total,
            'consumo_tritio' => $this->consumo_tritio
        );
        return $this->prod_energia;      
    }

    /*
    * public function MinaMetal
    * $lng contiene información de idioma
    * Es la Mina de Metal, se encarga también de definir la producción de metal
    */
    public function MinaMetal() {  
        
        $lng = new Lang();
    
        #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0) {
            $construible = true;
        } else {
            $construible = false;
        }    
        
        if($this->metal_actual >= $this->AlmacenMetal()['capacidad'] and $this->campos_usados < $this->campos) {
            $produccion = 0;
        } else {
            $produccion = (($this->tiempo * (30 * $this->nivel['metal'] * pow((1.1), $this->nivel['metal']) / 3600)) 
                            * (0.01 * $this->ProdEnergia()['factor'])) * self::RESOURCES_FACTOR; 
        }
        
        if($this->nivel['metal'] == 0) {
            $metal_coste = 40;
            $cristal_coste = 10;
        } else {
            $metal_coste = floor(40 * pow(1.52,$this->nivel['metal'])); 
            $cristal_coste = floor(10 * pow(1.52,$this->nivel['metal']));
        }
        
        $this->mina_metal = array(
            'produccion' => $produccion,
            'c_metal' => $metal_coste,
            'c_cristal' => $cristal_coste,
            'c_tritio' => 0,
            'construible' => $construible,
            'tiempo' => Mines::TiempoConstruccion($metal_coste,$cristal_coste),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_coste / 2),($cristal_coste / 2)),
            'c_materia' => 0,
            'nivel' => $this->nivel['metal'],
            'nombre' => $lng->x_mina_metal[0],
            'desc' => $lng->x_mina_metal[1]
        );
        
        return $this->mina_metal;
    }
    
    /*
    * public function MinaCristal
    * $lng contiene información de idioma
    * Es la Mina de Cristal, se encarga también de definir la producción de cristal
    */
    public function MinaCristal() {
        
        $lng = new Lang();    
        
        #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0) {
            $construible = true;
        } else {
            $construible = false;
        }    
    
        if($this->cristal_actual >= $this->AlmacenCristal()['capacidad'] and $this->campos_usados < $this->campos) {
            $produccion = 0;
        } else {          
            $produccion = (($this->tiempo * (30 * $this->nivel['cristal'] * pow((1.1), $this->nivel['cristal']) / 3600)) 
                            * (0.01 * $this->ProdEnergia()['factor'])) * self::RESOURCES_FACTOR; 
        }
        
        if($this->nivel['cristal'] == 0) {
            $metal_coste = 30;
            $cristal_coste = 15;
        } else {
            $metal_coste = 30 * pow(1.63,$this->nivel['cristal']);
            $cristal_coste = 15 * pow(1.63,$this->nivel['cristal']);
        } 
        
        $this->mina_cristal = array(
            'produccion' => $produccion,
            'c_metal' => $metal_coste,
            'c_cristal' => $cristal_coste,
            'c_tritio' => 0,
            'c_materia' => 0,
            'construible' => $construible,
            'tiempo' => Mines::TiempoConstruccion($metal_coste,$cristal_coste),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_coste / 2),($cristal_coste / 2)),
            'nivel' => $this->nivel['cristal'],
            'nombre' => $lng->x_mina_cristal[0],
            'desc' => $lng->x_mina_cristal[1]
        );
        
        return $this->mina_cristal;
    }
    
    /*
    * public function SintetizadorTritio
    * $lng contiene información de idioma
    * Es el Sintetizador de Tritio, se encarga también de definir la producción de tritio
    */
    public function SintetizadorTritio() { 
        
        $lng = new Lang();  
        
        #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0) {
            $construible = true;
        } else {
            $construible = false;
        }
        
        if($this->tritio_actual >= $this->AlmacenTritio()['capacidad'] and $this->campos_usados < $this->campos) {
            $produccion = 0;
        } else {
        /* 
            Mientras más frio es el planeta, más rápida es la extracción de tritio, por lo que si un planeta llega 
            a tener una temperatura promedio igual o menor a uno, la producción será casi tan alta como la de cristal
        */
            if($this->temp_promd > 45 and $this->temp_promd <= 60 ) {
                if($this->temp_promd >= 57) {
                $prod_t = 9;        
                } else {
                $prod_t = 10; 
                } 
            } else if ($this->temp_promd > 25 and $this->temp_promd <= 45) {
                $prod_t = 12;    
            } else if ($this->temp_promd > 12 and $this->temp_promd <= 25) {
                $prod_t = 13;     
            } else if ($this->temp_promd > 1 and $this->temp_promd <= 12) {
                if ($this->temp_promd <= 5) {
                    $prod_t = 15;   
                } else {
                    $prod_t = 14;
                }         
            } else if ($this->temp_promd <= 1) {
                $prod_t = 16;
            }  else {
                $prod_t = 10;
            }     
            
            $produccion = (($this->tiempo * ($prod_t * $this->nivel['tritio'] * pow((1.1), $this->nivel['tritio']) / 3600)) 
                            * (0.01 * $this->ProdEnergia()['factor'])) * self::RESOURCES_FACTOR; 
        }
        
        if($this->nivel['tritio'] == 0) {
            $metal_coste = 150;
            $cristal_coste = 50;
        } else {
            $metal_coste = 150 * pow(1.54,$this->nivel['tritio']);
            $cristal_coste = 50 * pow(1.54,$this->nivel['tritio']);
        }
      
        $this->sintetizador = array(
            'produccion' => $produccion,
            'c_metal' => $metal_coste,
            'c_cristal' => $cristal_coste,
            'c_tritio' => 0,
            'c_materia' => 0,
            'construible' => $construible,
            'tiempo' => Mines::TiempoConstruccion($metal_coste,$cristal_coste),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_coste / 2),($cristal_coste / 2)),
            'nivel' => $this->nivel['tritio'],
            'nombre' => $lng->x_sintetizador[0],
            'desc' => $lng->x_sintetizador[1]
        );
        
        return $this->sintetizador;
    }
    
    /*
    * public function DistribuidorElectrico
    * $lng contiene información de idioma
    * Es el Distribuidor Eléctrico
    */
    public function DistribuidorElectrico() {
        
        $lng = new Lang();
        
        $this->distribuidor = array(
            'c_metal' => 0,
            'c_cristal' => 0,
            'c_tritio' => 0,
            'c_materia' => 0,
            'tiempo' => 0,
            'tiempo_destruccion' => 0,
            'nivel' => false,
            'construible' => false,
            'nombre' => $lng->x_energia_base[0],
            'desc' => $lng->x_energia_base[1]
        );
        
        return $this->distribuidor;
    }

    /*
    * public function PlantaSolar
    * $lng contiene información de idioma
    * Es la Planta de Energía Solar
    */
    public function PlantaSolar() {
        
        $lng = new Lang();    
        
        #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0 and $this->nivel['reactor'] == 0 and $this->campos_usados < $this->campos) {
            $construible = true;
        } else {
            $construible = false;
        }
         
        if($this->nivel['solar'] == 0) {
            $metal_coste = 75;
            $cristal_coste = 30;
        } else {
            $metal_coste = 75 * pow(1.5,$this->nivel['solar']);
            $cristal_coste = 30 * pow(1.5,$this->nivel['solar']);
        } 
        
        $this->planta_solar = array(
            'c_metal' => $metal_coste,
            'c_cristal' => $cristal_coste,
            'c_tritio' => 0,
            'c_materia' => 0,
            'construible' => $construible,
            'tiempo' => Mines::TiempoConstruccion($metal_coste,$cristal_coste),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_coste / 2),($cristal_coste / 2)),
            'nivel' => $this->nivel['solar'],
            'nombre' => $lng->x_planta_solar[0],
            'desc' => $lng->x_planta_solar[1]
        );
        
        return $this->planta_solar;           
    }
    
    /*
    * public function ReactorFusion
    * $lng contiene información de idioma
    * Es el Reactor de Fusión
    */
    public function ReactorFusion() {
        
    $lng = new Lang();    
        
    #Requisitos para poder construirlo
        if($this->nivel['distribuidor'] > 0 and $this->nivel['solar'] == 0 and $this->campos_usados < $this->campos) {
            $construible = true;
        } else {
            $construible = false;
        }    
        
        if($this->nivel['reactor'] == 0) {
            $metal_coste = 80;
            $cristal_coste = 35;
        } else {
            $metal_coste = 80 * pow(1.51,$this->nivel['reactor']);
            $cristal_coste = 35 * pow(1.51,$this->nivel['reactor']);
        } 
        
        $this->reactor_fusion = array(
            'c_metal' => $metal_coste,
            'c_cristal' => $cristal_coste,
            'c_tritio' => 0,
            'c_materia' => 0,
            'construible' => $construible,
            'tiempo' => Mines::TiempoConstruccion($metal_coste,$cristal_coste),
            'tiempo_destruccion' => Mines::TiempoConstruccion(($metal_coste / 2),($cristal_coste / 2)),
            'nivel' => $this->nivel['reactor'],
            'nombre' => $lng->x_reactor_fusion[0],
            'desc' => $lng->x_reactor_fusion[1]
        );
        
        return $this->reactor_fusion;
    }
    
}

?>