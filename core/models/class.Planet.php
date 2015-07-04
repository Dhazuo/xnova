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
    
    protected $name;
    protected $image;
    protected $fields;
    protected $used_fields;
    protected $temperature;
    protected $orbit;
    protected $solar;
    
    public function __construct($id_planet) {
        parent::__construct($id_planet);
        $db = new Connect();
        $sql = $db->query("SELECT imagen,nombre,campos,campos_usados,temperatura,pos,sistema FROM planetas 
                            WHERE id_planeta='$id_planet' LIMIT 1;");
        $planeta = $db->recorrer($sql);
        $this->image = $planeta['imagen'];
        $this->name = $planeta['nombre'];
        $this->fields = $planeta['campos'];
        $this->used_fields = $planeta['campos_usados'];
        $this->temperature = $planeta['temperatura'];
        $this->orbit = $planeta['pos'];
        $this->solar = $planeta['sistema'];
        $db->liberar($sql);
        $db->close();
        unset($planeta,$db,$sql);
    }
    
    public function PlanetImage() {
        return $this->image;
    }
    
    public function PlanetName() {
        return $this->name;
    }
    
    public function PlanetFields() {
        return $this->used_fields.' / ' .$this->fields;
    }
    
    public function PlanetDiameter() {
        $diametro = $this->fields * 78;
        return number_format($diametro,0,',','.');
    }
    
    public function PlanetTemperature() {
        return $this->temperature;
    }
    
    public function PlanetOrbit() {
        return $this->orbit;
    }
    
    public function PlanetSystem() {
        return $this->solar;
    }
}

?>