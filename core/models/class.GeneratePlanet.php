<?php

class GeneratePlanet {

    private $orbit;
    private $solar;
    private $id;
    private $temp_min;
    private $temp_max;
    private $temperature;
    private $temp_promedio;
    private $image;
    
    public function __construct($register = true) { //Cuando exista la misión colonizar, esto ha de ser false
        include('core/models/class.UniversePosition.php');
        $posicion = new UniversePosition($register);
        $posicion->GenerateOrbit();
        $this->orbit = $posicion->OrbitPosition();
        $this->solar = $posicion->SolarSystem();
    }
    
    public function GenerateTemp() {
                        
        if($this->orbit >= 1 and $this->orbit <= 5) {
            $this->temp_min = mt_rand(30,45);
            $this->temp_max = mt_rand(50,70);
            $this->temperature = $this->temp_min . 'ºC - ' .$this->temp_max .'ºC';         
        } else if ($this->orbit > 5 and $this->orbit <= 10) {
            $this->temp_min = mt_rand(20,35);
            $this->temp_max = mt_rand(38,55);
            $this->temperature = $this->temp_min . 'ºC - ' .$this->temp_max .'ºC';      
        } else if ($this->orbit > 10 and $this->orbit <=12 ) {
            $this->temp_min = mt_rand(10,15);
            $this->temp_max = mt_rand(20,26);
            $this->temperature = $this->temp_min . 'ºC - ' .$this->temp_max .'ºC';    
        } else if ($this->orbit > 12 and $this->orbit <= 15) {
            $this->temp_min = mt_rand(-4,5);
            $this->temp_max = mt_rand(7,12);
            $this->temperature = $this->temp_min . 'ºC - ' .$this->temp_max .'ºC';     
        }  
        
        return $this->temperature;
    }
    

    public function TempPromd() {
       $this->temp_promedio = ($this->temp_min + $this->temp_max) / 2;
       return $this->temp_promedio;
    }
    
    public function GenerateImage() {
        if($this->orbit >= 1 and $this->orbit <= 5) {
            $this->image = 'planeta_'.mt_rand(1,10);    
            if($this->image = 'planeta_8') {
                $this->image = 'planeta_'.mt_rand(1,10);
            }
       } else if ($this->orbit > 5 and $this->orbit <= 10) {
            $this->image = 'planeta_'.mt_rand(11,20);    
       } else if ($this->orbit > 10 and $this->orbit <= 15) {
            $this->image = 'planeta_'.mt_rand(21,30);    
       } 
        
        return $this->image;
    }
    
    public function GenerateFields() {
        
        if($this->orbit >= 1 and $this->orbit <= 5) {
            $this->campos = mt_rand(60,120);  
        } else if ($this->orbit > 5 and $this->orbit <= 10) {
            $this->campos = mt_rand(120,250);    
        } else if ($this->orbit > 10 and $this->orbit <=12 ) {
            $this->campos = mt_rand(240,250);
        } else if ($this->orbit > 12 and $this->orbit <= 15) {
            $this->campos = mt_rand(200,320);    
        }   
        return $this->campos;
    }
    
    public function RegisterPlanet($id) {
       $this->id = $id;    
       $lng = new Lang(); 
        
       $imagen = $this->GenerateImage(); 
      
       $temperatura = $this->GenerateTemp();
       $temp_promd = $this->TempPromd();  

       $db = new Connect();
       $sql = "INSERT INTO planetas (id_ppal,id_dueno,nombre,imagen,metal,cristal,tritio,materia,campos,campos_usados,temperatura,temp_promd,pos,sistema) 
       VALUES ('$this->id','$this->id','$lng->x_ppal','$imagen',1000,1000,0,8000,180,0,
       '$temperatura','$temp_promd','$this->orbit','$this->solar');";
       $sql .= "INSERT INTO edificios (id_planeta) VALUES ('$this->id');"; 
       $sql .= "UPDATE generales SET 
        ultima_pos='$this->orbit', ultimo_sis='$this->solar' LIMIT 1;";
       $mquery = $db->multi_query($sql);

       $db->close();
       unset($sql,$sql2,$db,$imagen,$id_planet,$lng,$this->id,$temp_promd,$temperatura,$mquery);
    }
    
     public function NewCologne() {
        
        $lng = new Lang();
        
        $metal = mt_rand(0,1500);
        $cristal = mt_rand(0,1500);
        $tritio = mt_rand(0,1000);
        
        $imagen = $this->GenerateImage(); 
              
        #jugamos con la posibilidad de obtener materia oscura en una colonia xd totalmente al azar
        $x = mt_rand(5000,10000);
        if($x > 9950) {
            $materia = mt_rand(3400,6000);
        } else {
            $materia = 0; 
        }
        
        $campos = $this->GenerateFields();
        $temperatura = $this->GenerateTemp();
        $temp_promd = $this->TempPromd();

        $db = new Connect();
        $sql = "INSERT INTO planetas (id_ppal,id_dueno,nombre,imagen,metal,cristal,tritio,materia,campos,campos_usados,temperatura,temp_promd)
        VALUES (0,'$this->id','$lng->x_colonia','$imagen','$metal','$cristal','$tritio','$materia','$campos',0,'$temperatura','$temp_promd');";
        
         /*
         EN LA CONSULTA DE ARRIBA FALTA INTRODUCIR LAS COORDENADAS, LAS CUALES SERÁN LAS DE LA MISIÓN         
         */
         
        $db->liberar($sql);
        $db->close();
        unset($db,$campos,$temperatura,$temp_promd);
    }
    
}

?>