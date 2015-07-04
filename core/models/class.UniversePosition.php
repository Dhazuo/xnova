<?php

class UniversePosition {
    
    private $u_orbit;
    private $u_system;
    private $n_orbit;
    private $n_system;
    private $register;
    
    public function __construct($register) { 
        if ($register === true) { //si esto es true, es porque se está pasando del registro
            $db = new Connect();
            $sql = $db->query("SELECT ultima_pos,ultimo_sis FROM generales LIMIT 1;");
            $coordenada = $db->recorrer($sql);
            $db->liberar($sql);
            $db->close();
            $this->u_orbit = $coordenada['ultima_pos'];
            $this->u_system = $coordenada['ultimo_sis'];
            $this->register = true;
            unset($sql,$db,$coordenada);
        } else  {
            $this->u_orbit = 'LA ORBITA DE LA MISIO';
            $this->u_system = 'EL SISTEMA DE LA MISIÓN'; 
            $this->register = false;
        }
        
    }

    public function GenerateOrbit() {
        if ($this->register === true) { //si esto es true, es porque se está pasando del registro
            /* Al iniciar el juego siempre la primera posición la tiene el admin y es [1:1]
            * NOTA: PLANETAS NO COLONIZABLES 1,5,9,13, 
            * si deseas abarcar más, modifica el algoritmo que es estático y sencillo
            */
            if($this->u_orbit >= 1 and $this->u_orbit <= 9) {
                $this->n_orbit = $this->u_orbit + 4;
                $this->n_system = $this->u_system;
            } else if ($this->u_orbit >= 13 and $this->u_orbit < 15) {
                $this->n_orbit = 1;
                $this->n_system = $this->u_system + 1;
            }
        } else {
            $this->n_orbit = $this->u_orbit;
            $this->n_system = $this->u_system;
        }
    }
    
    public function OrbitPosition() {
        return $this->n_orbit;
    }
    
    public function SolarSystem() {
        return $this->n_system;
    }
    
}

?>