<?php

class UpdateStats {
        
    public function __construct() {
    
    $db = new Connect();
    $act = $db->query("SELECT ultima_act FROM generales LIMIT 1;");
    $actualizacion = $db->recorrer($act);
    if(time() >= $actualizacion[0]) { 
        $tops = $db->query("SELECT id,puntos FROM usuarios ORDER by puntos DESC;");
        $tope = 1; 
        $psql = "UPDATE usuarios SET top = ? WHERE id = ? LIMIT 1;";
        $prepare_query = $db->prepare($psql);
        $prepare_query->bind_param('ii',$nuevo_top,$id_user);
        while($top = $db->recorrer($tops)) {
            $nuevo_top = $tope++;
            $id_user = $top['id'];
            $prepare_query->execute();
        }
            $timer = time() + (30);
            $query = $db->query("UPDATE generales SET ultima_act='$timer' LIMIT 1;");
            $prepare_query->close();
            unset($actualizar,$tops,$timer,$tope,$query);
    } else {
        unset($actualizacion);
    } 
    $db->liberar($act);  
    $db->close();
  }   
}

?>