<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * class User: se encarga de manejar toda la información sobre un usuario en el sistema
*/

class User {
    
    protected $id;
    protected $user;
    protected $email;
    protected $faction;
    protected $rank;
    protected $honor;
    protected $status;
    protected $points;
    protected $alliance;
    
    public function __construct($id_user) {
        $this->id = $id_user;   
        $db = new Connect();
        $sql = $db->query("SELECT usuario,email,faccion,puntos,alianza,top FROM usuarios WHERE id='$this->id' LIMIT 1;");
        $usuario = $db->recorrer($sql);
        
        $this->user = $usuario['usuario'];
        $this->email = $usuario['email'];
        $this->faction = $usuario['faccion'];
        $this->points = $usuario['puntos'];
        $this->alliance = $usuario['alianza'];
        $this->rank = $usuario['top'];
        
        $db->liberar($sql);  
        $db->close();
        unset($sql,$db,$usuario,$this->id);
    }
    
    public function UserName() {       return $this->user;    }
    
    public function UserEmail() {        return $this->email;    }
    
    public function UserFaction() {
        $lng = new Lang();
        if($this->faction == 1) {
             return $lng->x_sin_faccion;
        } else if ($this->faction == 2) {
                return $lng->x_faccion_2;
        } else if ($this->faction == 3) {
                return $lng->x_faccion_3;
        }
    }
        
    public function TopUser() {  return number_format($this->rank,'0',',','.'); }
    
    public function UserHonor() {        return $this->honor;    }
    
    public function UserStatus() {        return $this->status;    }
    
    public function UserPoints() {        return number_format($this->points,'0',',','.');    }
    
    public function UserAlliance() {        return $this->alliance;    }
}

?>