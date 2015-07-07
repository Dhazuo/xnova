<?php

class Production {
    
    private $prod;
    private $capacity;
    private $nivel;
    private $fuente_base;
    private $energia_total;
    private $consumo_tritio;
    private $prod_usado;
    private $prod_sobrante;
    private $temp_promd;
    private $factor_energia;
    const RESOURCES_FACTOR = 1;
    
    protected function __construct($time,$niveles,$base,$temp) {
        $this->tiempo = $time;
        $this->fuente_base = $base;
        $this->temp_promd = $temp;
        $this->nivel = array(
            'metal' => $niveles[0],
            'cristal' => $niveles[1],
            'tritio' => $niveles[2],
            'reactor' => $niveles[3],
            'solar' => $niveles[4],
            'satelites' => $niveles[5],
            'modulos' => $niveles[6],
            'a_metal' => $niveles[7],
            'a_cristal' => $niveles[8],
            'a_tritio' => $niveles[9]
        );
    }
    
    /*
    * proctected function PordEnergia
    * $lng contiene informacion de idioma
    * Se encarga de la producción de energía, el resultantes depende de la forma de obtención de energía del planeta
    * $this->fuente_base == 0 | Es la producción base del juego sin ninguna edificiación que produzca energía
    * $this->fuente_base == 1 | Es la producción de energía solar en un planeta, si esta existe, no existen más la base y tampoco la de reactores
    *      -> Sus extensiones son los satélites solares e influye la tecnología de energía, pero aún no la he programado.
    * $this->fuente_base == 2 | Es la producción de energía mediante reactores de fusión, de igual forma, si esta existe, no existen las demás
    *      -> Sus extensiones son los módulos e influye la tecnología de energía, pero aún no la he programado.
    */
    protected function ProdEnergia() {

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
        
            $this->energia_total =  ($this->nivel['satelites'] * $satelite_prod) + 600
                                    + floor(($factor_e * $this->nivel['solar'] * pow((1.1), $this->nivel['solar']))); 
            
            $this->consumo_tritio = 0;
            $this->prod_usado = floor($consumo_metal + $consumo_cristal + $consumo_tritio);
            $this->prod_sobrante = floor($this->energia_total - $this->prod_usado);          
        } else if($this->fuente_base == 2) { #Producción de energia mediante reactores de fusión
          
            if( $this->tritio_actual >= 1000) {
                $this->energia_total = ($this->nivel['modulos'] * 30) + 600 + floor((40 * $this->nivel['reactor'] * pow((1.1), $this->nivel['reactor'])));
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
    
    protected function getMetalCapacity() {
        $this->capacity = 10000 * pow(1.9,$this->nivel['a_metal']);
        return $this->capacity;
    }
    
    protected function getCristalCapacity() {
        $this->capacity = 10000 * pow(1.9,$this->nivel['a_cristal']);
        return $this->capacity;
    }
    
    protected function getTritioCapacity() {
        $this->capacity = 10000 * pow(1.95,$this->nivel['a_tritio']);
        return $this->capacity;
    }
    
    protected function getMetalProd() {
        $level = $this->nivel['metal'] == 0 ? 1 : $this->nivel['metal'];
        $this->prod = (($this->tiempo * (30 * $level * pow((1.1), $this->nivel['metal']) / 3600)) 
                            * (0.01 * $this->ProdEnergia()['factor'])) * self::RESOURCES_FACTOR;
        return $this->prod; 
    }
    
    protected function getCristalProd() {
        $level = $this->nivel['cristal'] == 0 ? 1 : $this->nivel['cristal'];
        $this->prod = (($this->tiempo * (20 * $level * pow((1.1), $this->nivel['cristal']) / 3600)) 
                            * (0.01 * $this->ProdEnergia()['factor'])) * self::RESOURCES_FACTOR;
        return $this->prod;
    }
    
    protected function getTritioProd() {
        $level = $this->nivel['tritio'] == 0 ? 1 : $this->nivel['tritio'];
        $this->prod = (($this->tiempo * (10 * $level * pow((1.1), $this->nivel['tritio']) / 3600)) 
                            * (0.01 * $this->ProdEnergia()['factor'])) * self::RESOURCES_FACTOR; 
        return $this->prod;
    }
    
}

?>