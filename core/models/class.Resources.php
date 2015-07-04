<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * class Resources: se encarga de manejar toda la información de recursos de los planetas, por tanto hereda todo lo generado por las minas
 * se encarga de hacer la constante actualización de recursos en el sistema cada vez que el usuario entra al juego
*/

require('core/buildable/production.Mines.php');

class Resources extends Mines {
    
    protected $id;
    protected $metal;
    protected $cristal;
    protected $tritio;
    protected $energia_total;
    protected $energia_consumida;
    protected $energia_sobrante;
    protected $materia;
    
    public function __construct($id_planeta) {
        $this->id = $id_planeta;
        parent::__construct($this->id);
        
        $mina_metal = $this->MinaMetal();
        $mina_cristal = $this->MinaCristal();
        $sintetizador = $this->SintetizadorTritio();
        $prod_metal = $mina_metal['produccion'];
        $prod_cristal = $mina_cristal['produccion'];
        $prod_tritio = $sintetizador['produccion'];    
        
        $db = new Connect();    
            
        $tiempo = time();
        //Actualizacion de recursos cada tanto
        $update = $db->query("UPDATE planetas SET ultima_act='$tiempo', metal= metal + '$prod_metal', cristal= cristal + '$prod_cristal', 
        tritio= tritio + '$prod_tritio' WHERE id_planeta='$this->id'");  
            
        $sql = $db->query("SELECT metal,cristal,tritio,materia FROM planetas WHERE id_planeta='$this->id' LIMIT 1;");
        $planeta = $db->recorrer($sql);
        $this->metal = $planeta['metal'];
        $this->cristal = $planeta['cristal'];
        $this->tritio = $planeta['tritio'];
        $this->energia_total = $this->ProdEnergia()['total'];
        $this->energia_consumida = $this->ProdEnergia()['consumo_energia'];
        $this->energia_sobrante = $this->ProdEnergia()['energia_sobrante'];
        $this->materia = $planeta['materia'];
            
        $db->liberar($sql,$update);     
        $db->close(); unset($mina_metal,$mina_cristal,$sintetizador,$prod_metal,$prod_cristal,$prod_tritio,$tiempo,$update,$db,$planeta);
    }    

    public function Metal() { 
        return floor($this->metal);   
    }  
       
    public function Cristal() {  
        return floor($this->cristal);  
    }  
    
    public function Tritio() {
        return floor($this->tritio);     
    }
     
    public function EnergiaTotal() {   
        return floor($this->energia_total);    
    } 
    
    public function EnergiaConsumo() {   
        return floor($this->energia_consumida);      
    }
    
    public function EnergiaSobrante() {
        return floor($this->energia_sobrante);      
    }
    
    public function MateriaOscura() {    
        return floor($this->materia);   
    }

}

?>
