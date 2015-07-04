<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * class Access, algoritmo para los eventos de Iniciar Sesion, Registro y Recuperar Contraseña
*/

class Access {
        
    private $user;
    private $pass;
    private $email;
    
    public function Login() {
        if(isset($_POST['login'])) { 
            if(!empty($_POST['user']) and !empty($_POST['pass'])) {
                $db = new Connect();
                $this->user = $db->real_escape_string($_POST['user']);
                $this->pass = sha1($_POST['pass']);
                $sql = $db->query("SELECT id,usuario FROM usuarios 
                WHERE usuario='$this->user' AND password='$this->pass' ");
                if($db->rows($sql) > 0) {
                    $dato = $db->recorrer($sql);
                    
                    $sql2 = $db->query("SELECT id_planeta FROM planetas 
                    WHERE id_ppal='$dato[0]' AND id_dueno='$dato[0]' LIMIT 1;");
                    $planet = $db->recorrer($sql2);
                    
                    $_SESSION['user'] = $dato[1];
                    $_SESSION['id'] = $dato[0];
                    $_SESSION['id_planet'] = $planet[0];
                    
                    if($_POST['sesion'] == 1) { ini_set('session.cookie_lifetime',time()+(60*60*24)); }
                    $db->liberar($sql,$sql2);
                    $db->close();
                    $login = '<script>window.location="?core=overview";</script>';
                    unset($this->user,$this->pass,$dato,$planet,$db);
                } else {
                    $db->liberar($sql);
                    $db->close();
                    $lng = new Lang();
                    $login = $lng->e_datos_inc;
                    unset($this->user,$this->pass,$lng,$db);
                }
            } else {
                $lng = new Lang();
                $login = $lng->e_datos_vac;
                unset($lng);
            }
        } else {
            $login = '<script>window.location="?core=index";</script>';
        }
        echo $login;
        unset($login);
    }
    
    public function Register() {
        if(!empty($_POST['user']) and !empty($_POST['pass']) and !empty($_POST['email'])) {
            $db = new Connect();
            $this->user = $db->real_escape_string($_POST['user']);
            $this->email = $db->real_escape_string($_POST['email']);
            $this->pass = sha1($_POST['pass']);
            $sql = $db->query("SELECT usuario,email FROM usuarios 
            WHERE usuario='$this->user' OR email='$this->email' LIMIT 1;");
            if($db->rows($sql) == 0) {   
                $sql2 = $db->query("SELECT COUNT(id) FROM usuarios LIMIT 1;");
                $top = $db->recorrer($sql2);
                $top = $top[0] + 1;

                $sql3 = $db->query("INSERT INTO usuarios (usuario,password,email,faccion,top) 
                VALUES ('$this->user','$this->pass','$this->email','1','$top');");
                
                $sql4 = $db->query("SELECT MAX(id) AS id FROM usuarios LIMIT 1;");
                $id = $db->recorrer($sql4);
                $id = $id[0];
                
                $db->liberar($sql,$sql2,$sql3,$sql4);
                            
                require('core/models/class.GeneratePlanet.php');
                $planeta = new GeneratePlanet();
                $planeta->RegisterPlanet($id);
                
                $planet = $db->query("SELECT id_planeta FROM planetas WHERE id_dueno='$id' LIMIT 1;");
                $id_planet = $db->recorrer($planet);
                $id_planet = $id_planet[0];
                
                $_SESSION['id_planet'] = $id_planet;
                $_SESSION['user'] = $this->user;
                $_SESSION['id'] = $id;  
                $login = '<script>window.location="?core=overview";</script>';
                $db->liberar($planet);
                $db->close();
                unset($sql,$sql2,$sql3,$sql4,$top,$db,$id,$this->email,$this->pass);
            } else {
                $dato = $db->recorrer($sql);
                $db->liberar($sql);
                $db->close();
                $lng = new Lang();
                if(strtolower($dato[1]) == strtolower($this->email)
                   and strtolower($dato[0]) != strtolower($this->user)) {
                    $login = $lng->e_email_existe;
                } else if (strtolower($dato[1]) != strtolower($this->email)
                   and strtolower($dato[0]) == strtolower($this->user)) {
                    $login = $lng->e_user_existe;
                } else {
                    $login = $lng->e_user_email_existe; 
                }
                unset($sql,$db,$lng,$dato,$this->user,$this->email,$this->pass);
            }
        } else {
            $lng = new Lang();
            $login = $lng->e_datos_vac;
            unset($lng);
        }
        echo $login;
        unset($login);
    }
    
}

?>