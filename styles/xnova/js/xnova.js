/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * xnnova.js scripts generales 
*/

$('document').ready(function(){

    function hora() {
       $.ajax({
            type: 'GET',
            url: 'ajax.php?view=reloj',
            success: function($hora){            
                $('#hora').html($hora);  //Div en menu.xnv
                setTimeout(hora(),1000);
            }  
        });   
    }   
    setTimeout(hora(),1000);
    
    Tipped.create('.tooltip', { 
        behavior: 'sticky'
    });
    Tipped.create('.tooltipted', { 
        fadeIn: 100,
        fadeOut: 1,
        hideOthers: true,
        radius: 0,
        fixed: true
    });

});