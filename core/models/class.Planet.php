<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * class Planet: se encarga de manipular toda la información de un planeta, por tanto hereda toda la información de recursos de ese planeta
*/

require ('core/models/class.Resources.php');

class Planet extends Resources {
    
    private $planet;
    
    public function __construct($id_planet) {
        parent::__construct($id_planet);
        $db = new Connect();
        $sql = $db->query("SELECT imagen,nombre,campos,campos_usados,temperatura,pos,sistema,metal,cristal,tritio,materia
        FROM planetas WHERE id_planeta='$id_planet' LIMIT 1;");
        $planeta = $db->recorrer($sql);
        
        $this->planet = array(
            'image' => $planeta['imagen'],
            'name' => $planeta['nombre'],
            'fields' => $planeta['campos'],
            'used_fields' => $planeta['campos_usados'],
            'temperature' => $planeta['temperatura'],
            'orbit' => $planeta['pos'],
            'solar' => $planeta['sistema'],
            'metal' => $planeta['metal'],
            'cristal' => $planeta['cristal'],
            'tritio' => $planeta['tritio'],
            'matter' => $planeta['materia']  
        );
        
        $db->liberar($sql);
        $db->close();
        unset($planeta,$db,$sql);
    }
    
    public function PlanetMetal() { 
        return floor($this->planet['metal']);   
    }  
       
    public function PlanetCristal() {  
        return floor($this->planet['cristal']);  
    }  
    
    public function PlanetTritio() {
        return floor($this->planet['tritio']);     
    }
    
    public function PlanetDarkMatter() {    
        return floor($this->planet['matter']);   
    }
    
    public function PlanetImage() {
        return $this->planet['image'];
    }
    
    public function PlanetName() {
        return $this->planet['name'];
    }
    
    public function PlanetFields() {
        return $this->planet['used_fields'] . ' / ' . $this->planet['fields'];
    }
    
    public function PlanetDiameter() {
        $diametro = $this->planet['fields'] * 78;
        return number_format($diametro,0,',','.');
    }
    
    public function PlanetTemperature() {
        return $this->planet['temperature'];
    }
    
    public function PlanetOrbit() {
        return $this->planet['orbit'];
    }
    
    public function PlanetSystem() {
        return $this->planet['solar'];
    }
}

?>