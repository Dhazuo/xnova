/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * xnnova.js.ajax scripts de Ajax
*/

$('document').ready(function(){
    
    var $cargando = '<img src="styles/xnova/images/navegacion/ajax-loader.gif" />'
    
      /** --------------------------------- LOGIN, REGISTRO, RECUPERAR PASS --------------------------------- **/
        //Login
        $('#login').click(function(){
             var _login = '?core=index&mode=login';   
             $.ajax({
                type: 'POST',
                url: _login,
                data: $('#iniciar_sesion').serialize(),
                beforeSend: function(){
                    $('#cargando').html($cargando);
                },
                success: function(informacion) {
                    $('#cargando').hide();
                    $('#error').html(informacion);
                }
            });  
                return false;       
        });
            
        //Registro
        $('#registrar').click(function(){
            var _registro = '?core=index&mode=reg';
            $.ajax({
                type: 'POST',
                url: _registro,
                data: $('#registro_usuario').serialize(),
                beforeSend: function(){
                    $('#cargando').html($cargando);
                },
                success: function(informacion) {
                    $('#cargando').hide();
                    $('#error').html(informacion);
                }
            });
                return false;
        });
            
        //Lostpass
        $('#dalelaclavexd').click(function(){
            var _recuperar = '?core=index&mode=lostpass';
            $.ajax({
                type: 'POST',
                url: _recuperar,
                data: $('#clave_perdida').serialize(),
                beforeSend: function(){
                    $('#cargando').html($cargando);
                },
                success: function(informacion) {
                    $('#cargando').hide();
                    $('#error').html(informacion);
                }
            });
            return false;
        });
    /** --------------------------------- / LOGIN, REGISTRO, RECUPERAR PASS --------------------------------- **/

    
    /** --------------------------------- HORA DEL SERVIDOR --------------------------------- **/
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
    
     /** --------------------------------- COLA EDIFICIOS --------------------------------- **/
       function ColaEdificios() {
        $.ajax({
            type: 'GET',
            url: 'core.php?view=colas',
            success: function($colas){            
              $('.colas_edif').html($colas);
              setTimeout(ColaEdificios(),1000);  
            }  
        });  
     }  
    setTimeout(ColaEdificios(),1000);
    
    /** --------------------------------- / END HORA DEL SERVIDOR --------------------------------- **/
    
    /** ESTADISTICAS **/
    
    $('#mostrar').click(function(){
        $.ajax({
            type: 'GET',
            url: 'core.php?view=estadisticas',
            data: {pag: 50},
            beforeSend: function() {
              $('#cargando').html($cargando);  
            },
            success: function($html) {
                var $estadisticas = $($html).find('#estadisticas tbody');
                $('#estadisticas').append($estadisticas);
                $('#mostrar').hide();
                $('#cargando').hide();
            }
        });
        return false;
    });
    
    /** / END ESTADISTICAS **/
                    
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