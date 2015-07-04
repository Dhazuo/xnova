<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * class Connect, establece conexión con la base de datos y prepara métodos comunes
*/

class Connect extends mysqli {
    
    public function __construct() {
        parent::__construct('localhost','root','','xnova');
        $this->query("SET NAMES utf8;");
        date_default_timezone_set('America/Caracas');
        $this->connect_errno ? die('ERROR: Datos incorrectos en /core/models/class.Connect.php') : null;
    }
    
    public function rows($x) {
        return mysqli_num_rows($x);
    }
    
    public function recorrer($x) {
        return mysqli_fetch_array($x);
    }
    
    public function liberar($x) {
        return mysqli_free_result($x);
    }
    
    public function preparada() {
        return mysqli_stmt_init();
    }
    
}

?>