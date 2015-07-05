<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * implement Menu: Implementa el menú izquierdo del juego
*/

class Menu {
    
    public function __construct($id_user) {
        
            $lng = new Lang();           
            $usuario = new User($id_user);
            $template = new Smarty();
            $template->assign(array(
                'm_flotas' => $lng->m_flotas,
                'm_universo' => $lng->m_universo,
                'm_alianzas' => $lng->m_alianzas,
                'm_banco' => $lng->m_banco,
                'm_estadisticas' => $lng->m_estadisticas,
                'm_configuracion' => $lng->m_configuracion,
                'm_tienda' => $lng->m_tienda,
                'm_top' => $usuario->TopUser()
            ));
            $template->display('overall/menu.xnv'); 
    }
}

?>