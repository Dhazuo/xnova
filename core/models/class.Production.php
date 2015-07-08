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
    private $tritio_actual;
    const RESOURCES_FACTOR = 1;
    
    protected function __construct($time,$niveles,$base,$temp,$tritio) {
        $this->tiempo = $time;
        $this->fuente_base = $base;
        $this->temp_promd = $temp;
        $this->nivel = array(
            'metal' => $niveles['mina_metal'],
            'cristal' => $niveles['mina_cristal'],
            'tritio' => $niveles['mina_tritio'],
            'reactor' => $niveles['reactor_fusion'],
            'solar' => $niveles['planta_energia'],
            'satelites' => $niveles['satelites'],
            'modulos' => $niveles['modulos'],
            'a_metal' => $niveles['almacen_metal'],
            'a_cristal' => $niveles['almacen_cristal'],
            'a_tritio' => $niveles['almacen_tritio']
        );
        $this->tritio_actual = $tritio;
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
        
      $level = $this->nivel['metal'] == 0 ? 1 : $this->nivel['metal'];
      $consumo_metal = 10 * $level * pow((1.1), $this->nivel['metal']);
      $level = $this->nivel['cristal'] == 0 ? 1 : $this->nivel['cristal'];  
      $consumo_cristal = 10 * $level * pow((1.1), $this->nivel['cristal']);
      $level = $this->nivel['tritio'] == 0 ? 1 : $this->nivel['tritio'];  
      $consumo_tritio = 20 * $level * pow((1.1), $this->nivel['tritio']);
           
      if($this->fuente_base == 0) {
       $this->energia_total = 600;
       $this->consumo_tritio = 0;
      } elseif ($this->fuente_base == 1) {
            if($this->temp_promd > 45 and $this->temp_promd <= 60 ) {
                $factor_e = 28;
                $satelite_prod = 33;
            } else if ($this->temp_promd > 25 and $this->temp_promd <= 45) {
                $factor_e = 22;
                $satelite_prod = 25;
            } else if ($this->temp_promd > 12 and $this->temp_promd <= 25) {
                $factor_e = 19;
                $satelite_prod = 22;
            } else if ($this->temp_promd > 1 and $this->temp_promd <= 12) {
                $factor_e = 14;
                $satelite_prod = 19;      
            } else if ($this->temp_promd <= 1) {
                $factor_e = 12;
                $satelite_prod = 15;
            }   else {
                $factor_e = 20;
                $satelite_prod = 23;
            } 
          
       $this->energia_total = ($this->nivel['satelites'] * $satelite_prod) + 600
                              + floor(($factor_e * $this->nivel['solar'] * pow((1.1), $this->nivel['solar'])));
       $this->consumo_tritio = 0;   
      } else {
          $this->consumo_tritio = 5 * $this->nivel['reactor'] * pow((1.1), $this->nivel['reactor']); 
          if($this->tritio_actual <= $this->consumo_tritio) {
              $this->energia_total = 0;
              $this->consumo_tritio = 0;
          } else {
              $this->energia_total = ($this->nivel['modulos'] * 30) + 600 + floor((40 * $this->nivel['reactor'] * pow((1.1), $this->nivel['reactor']))); 
          } 
      }
       
      $this->prod_usado = $consumo_metal + $consumo_cristal + $consumo_tritio;
      $this->prod_sobrante = $this->energia_total - $this->prod_usado;      
      $this->factor_energia = floor(($this->energia_total / $this->prod_usado) * 100);
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
        $this->prod = ((($this->tiempo * (10 * $level * pow((1.1), $this->nivel['tritio']) / 3600)) 
                            * (0.01 * $this->ProdEnergia()['factor'])) * self::RESOURCES_FACTOR) 
                            - $this->ProdEnergia()['consumo_tritio']; 
        return $this->prod;
    }
    
}

?>