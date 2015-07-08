<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\6
 ¯  /¯\ | \| \__/  \/ /--\Core.
 * @author: Copyright (C) 2015 by Brayan Narvaez (Prinick) developer of xNova Revolution and Xnova
 * @author web: http://www.prinick.com
 * Todos los derechos reservados para éste código y tódo el núcleo del sistema
 * es.php atributos del idioma español
*/

class Lang {
    
    /*
    *   Atributos de idioma del index (Login, Reigstro, Claverperdida)
    *   Llamados en index.php;
    */
    public $e_datos_inc = 'ERROR: Datos de acceso incorrectos.';
    public $e_datos_vac = 'ERROR: Debes ingresar todos los campos.';
    public $e_email_existe = 'EROR: El email que has introducido existe.';
    public $e_user_existe = 'ERROR: El usuario que has introducido ya existe.';
    public $e_user_email_existe = 'ERROR: El usuario y el email que has introducido ya existen.';
    public $e_email_no_existe = 'ERROR: El email que has introducido no existe.';
    public $x_exito_enviar_pass = 'Hemos enviado una nueva contraseña a tu correo electrónico.';
    public $x_user = 'Usuario';
    public $x_email = 'Email';
    public $x_pass = 'Contraseña';
    public $x_registrarme = 'Registrarme';
    public $x_recordar = 'Recordar mi sesión';
    
    /*
    *   Atributos de idioma menu
    *   Llamados en class.Menu.php    
    */
    public $m_general = 'Control General';
    public $m_abastecimiento = 'Abastecimiento';
    public $m_infraestructura = 'Instalaciones';
    public $m_comerciante = 'Comerciante';
    public $m_tecnologia = 'Tecnología';
    public $m_hangar = 'Hangar';
    public $m_defensas = 'Defensas';
    public $m_flotas = 'Flotas';
    public $m_universo = 'Universo';
    public $m_alianzas = 'Alianza';
    public $m_banco = 'Banco';
    public $m_estadisticas = 'Estadísticas';
    public $m_configuracion = 'Configuración';
    public $m_tienda = 'Tienda';
    
    /*
    *   Atributos de idioma generales
    *   Llamados en diversos archivos
    */
    public $x_metal = 'Metal';
    public $x_cristal = 'Cristal';
    public $x_tritio = 'Tritio';
    public $x_energia = 'Energía';
    public $x_materia = 'Materia Oscura';
    public $x_mo = 'MO';
    public $x_submit = 'Enviar';
    public $x_sin_faccion = 'Sin facción';
    public $x_faccion_2 = 'Facción 1';
    public $x_faccion_3 = 'Facción 2';
    public $x_actual = 'Actual';
    public $x_capacidad = 'Capacidad';
    public $x_produccion = 'Producción';
    public $x_consumo = 'Consumo';
    public $x_infinito = 'Infinito';
    public $x_ppal = 'Planeta Principal';
    public $x_colonia = 'Colonia';
    
    /*
    *   Atributos de idioma universo
    *   Llamados en class.Universo.php
    */
    public $x_ir = 'Mostrar';
    public $x_anterior = 'Anterior';
    public $x_siguiente = 'Siguiente';
    public $x_orbita = 'Órbita';
    public $x_planeta = 'Planeta';
    public $x_emperador = 'Emperador';
    public $x_accion = 'Acciones';
    public $x_colonizar = 'Colonizar';
    public $x_saltar = 'Salto Cuántico';
    public $x_transportar = 'Transportar';
    public $x_desplegar = 'Desplegar';
    public $x_tomar_recursos = 'Tomar Recursos';
    public $x_defender = 'Defender';
    public $x_espiar = 'Espiar';
    public $x_atacar = 'Atacar';
    public $x_sac = 'Atacar en Grupo';
    public $x_no_hay = 'No hay acciones disponibles';
    /*
    *   Atributos de idioma estadísticas
    *   Llamados en class.Estadisticas.php
    */
    public $x_top = 'TOP';
    public $x_jugador = 'Jugador';
    public $x_puntos =  'Puntos';
    public $x_alianza = 'Alianza';
    public $x_faccion = 'Facción';
    public $x_mostrar_mas = 'Ver TOP 100';
    
    /*
    *  Atributos de idioma abastecimiento
    *  Atributos de idioma class.Abastecimiento.php
    */
    public $x_sinrecursos = 'Recursos insuficientes';
    public $x_yaencola = 'Ya en Cola';
    public $x_nodesmontar = 'No puede ser desmontado';
    public $x_notecno = 'Tecnología insuficiente';
    public $x_nivelmax = 'Nivel Máximo';
    public $x_otrotipo_energ = 'Otro tipo de infraestructura energética está en cola.';
    public $x_nada_constr = 'Nada en construcción';
    public $x_subio_nivel = 'ha subido de nivel';
    public $x_bajo_nivel = 'ha bajo de nivel';
    
    
    /*
    *   Atributos de idioma minas
    *   Llamados en class.Minas.php
    *   La estructura es array('Nombre', 'Descripción');
    */
    public $mina_metal_name = 'Mina de Metal';
    public $mina_metal_desc = '<div class=\'d_p\'>
    El metal es el recurso más básico para un imperio emergente, las minas de metal se encargan de extraer este mineral que permite la construcción de edificaciones y naves. 
    <br /><br /> 
    Es el mineral más barato disponible, puesto que requiere poca energía y costo su extracción, además de ser abundante.       <br /><br /> 
    Se encuentra en las profundidades de la superficie terrestre, cada nivel de la mina de metal conduce a minas cada vez más profundas que puede extraer más mineral, evidentemente utilizando más energía para funcionar.
    </div>';
        
    public $mina_cristal_name = 'Mina de Cristal';
    public $mina_cristal_desc = '<div class=\'d_p\'>
    El cristal es el segundo mineral más usado, generalmente se emplea en la construcción de circuitos electrónicos y ciertas aleaciones. 
    <br /><br />
    Las minas de cristal se encargan de perforar la superficie terrestre en busca de este mineral, su abundancia es grande pero no es basta como la del metal, por tanto cuesta el doble conseguirlo, el consumo de energía es exactamente el mismo que el de las minas de metal, cada nivel dota a las minas de mayor capacidad para explorar las profundidades en busca de este mineral.
    </div>';
    
    public $mina_tritio_name = 'Sintetizador de Tritio';
    public $mina_tritio_desc = '<div class=\'d_p\'>El tritio es un isótopo del hidrogeno: Los núcleos de hidrogeno contienen dos neutrones adicionales, es muy últil como combustile para naves por la gran cantidad de energía liberada de la reacción entre el deuterio y él mismo (Reacción DT), por lo que es una buena opción para abastecer de energía a planetas lejanos al sol.
    <br /><br /> 
    El tritio puede ser encontrado frecuentemente en las profundidades del mar, su peso molecular es alto, puesto que mejorar el sintetizador de tritio acelera la recolección y procesamiento de este isótopo. Mientras más frio es un planeta, más abundante es.</div>';
    
    public $distribuidor_name = 'Distribuidor Eléctrico';
    public $distribuidor_desc = '<div class=\'d_p\'>
    Es una plataforma encargada de distribuir la energía en todo el planeta, todo el cableado estructurado del planeta tiene como centro al distribuidor eléctrico.
    <br /><br />
    Éste, con grandes fuentes de poder puede producir una máxima cantidad de energía para abastecer el planeta, la energía que es capaz de producir tiene un límite de 600Mw, puesto que es indispensable conectarlo a algún sistema de producción de energía más productivo.
    <br /><br />
    El distribuidor es la espina dorsal de cualquier infraestructura planetaria.
    </div> 
    <div class=\'s_p\'>Tiene un nivel fijo, no puede ser desmontado.</div>';
    public $planta_energia_name = 'Planta de Energía Solar';
    public $planta_energia_desc = '<div class=\'d_p\'>
    La Planta de Energía Solar utiliza semiconductores de células fotovoltaicas, que convierten los fotones en corriente eléctrica, la producción de esta planta depende directamente de la distancia del planeta al sol. 
    <br /><br />
    Mientras más cercano sea, mayor será la productividad de la planta de energía solar, puesto que si el planeta recibe poca luz solar ésta no es la opción más indicada para establecer la infraestructura energética del planeta.
    </div>
    <div class=\'s_p\'>Una vez sea construida, no puede ser desmontada y se perderá acceso al reactor de fusión en este planeta.</div>';
    
    public $reactor_fusion_name = 'Reactor de Fusión';
    public $reactor_fusion_desc = '<div class=\'d_p\'>
    Mediante el estudio de las partículas que originaron el universo, se descubrió que a su momento se generó una cantidad enorme de energía.
    <br /><br />
    Gracias a esto, se puede hacer recreaciones a escala de lo sucedido en este evento y aprovechar la energía que emanan las partículas resultantes de la colisión acelerada de partículas de tritio a velocidades extremadamente altas.
    <br /><br />
    Es una alternativa para los planetas muy alejados del sol, la producción de energía mediante este método es bastante alta y utiliza el tritio como combustible.
    </div>
    <div class=\'s_p\'>Una vez sea construido, no puede ser desmontado y se perderá acceso a la energía solar en este planeta.</div>';
    
    public $satelites_name = 'Satélite Solar';
    public $satelites_desc = '<div class=\'d_p\'>
    Los científicos descubrieron un método para transmitir energía eléctrica al planeta utilizando satélites especialmente diseñados en una órbita geosincrónica.
    <br /><br />
    Los satélites solares recogen la energía solar y la transmiten a los paneles de la planta de energía solar usando una tecnología láser avanzada.
    <br /><br />
    La eficiencia de un satélite solar depende de la fuerza de la radiación solar recibida. En principio, la producción de energía en órbitas más cercanas al sol es mayor que en las órbitas distantes al sol.
    </div>
    <div class=\'s_p\'>Son muy frágiles y pueden ser destruidos fácilmente en batallas.
    </div>';
    
    public $modulos_name = 'Módulo Acelerador';
    public $modulos_desc = '<div class=\'d_p\'>
    Los modulos aceleradores se instalan en los colisionadores del reactor de fusión.
    <br /><br />
    Optimizan la obtención de energia de las partículas primordiales y redireccionan un porcentaje grande de la energia obtenida de vuelta al colisionador, por lo que permite obtener más energía de la misma cantidad de tritio.
    </div>';
    
    public $almacen_metal_name = 'Almacén de Metal';
    public $almacen_metal_desc = '<div class=\'d_p\'>
    Bodegas enormes para almacenar metal sin procesar. Mientras más grande sea el almacén, más aumentará la capacidad de almacenaje del planeta.
    </div>
    <div class=\'s_p\'>
    La recolección de metal se detendrá cuando el almacén esté lleno.
    </div>';
    
    public $almacen_cristal_name = 'Almacén de Cristal';
    public $almacen_cristal_desc = '<div class=\'d_p\'>
    Bodegas enormes para almacenar cristal sin procesar. Mientras más grande sea el almacén, más aumentará la capacidad de almacenaje.  
    </div>
    <div class=\'s_p\'>La recolección de cristal se detendrá cuando el almacén esté lleno.
    </div>';
    
    public $almacen_tritio_name = 'Almacén de Tritio';
    public $almacen_tritio_desc ='<div class=\'d_p\'>Contenedores enormes para almacenar tritio. Los contenedores se encuentran a menudo cerca del hangar. <br /><br />Los contenedores grandes son capaces de almacenar más tritio. 
    </div>
    <div class=\'s_p\'>La recolección de tritio se detendrá cuando el contenedor esté lleno.</div>';
    
    public $almacen_materia_name = 'Almacén de Materia Oscura';
    public $almacen_materia_desc ='<div class=\'d_p\'>Contenedores especializados para almacenar materia oscura, su capacidad es ilimitada.</div>
    <div class=\'s_p\'>Tiene un nivel fijo, no puede ser desmontado.</div>';
    
    /*
    *   Atributos de idioma instalaciones
    *   Llamados en class.Instalaciones.php
    *   La estructura es array('Nombre', 'Descripción');
    */
    public $laboratorio_name = 'Laboratorio'; 
    public $laboratorio_desc = '<div class=\'d_p\'>
    Para poder investigar en nuevas áreas de una tecnología, se necesita un laboratorio de investigación planetario.
    <br /><br /> 
    El nivel de mejoras del laboratorio, no solo incrementa la velocidad a la que se descubren nuevas tecnologías, sino que también abre nuevos campos para investigar. Para conducir una investigación en el menor tiempo posible, todos los científicos del imperio son enviados al planeta donde se inició el trabajo de investigación. En cuanto el trabajo se haya completado, volverán a sus planetas y llevarán con ellos la nueva tecnología descubierta.
    </div>';
    
    public $nanobots_name = 'Nanobots'; 
    public $nanobots_desc = '<div class=\'d_p\'>
    Los nanobots son unidades robóticas minúsculas, con un tamaño medio de apenas unos pocos nanómetros. Estos microbios mecánicos son conectados en red y programados para una tarea de construcción, ofrecen una velocidad de producción realmente alta.
    <br /><br /> 
   Cada nivel de la fábrica de nanobots disminuye el tiempo de construcción de todas las edificaciones, naves y defensas.
    </div>';
    
    public $hangar_name = 'Hangar'; 
    public $hangar_desc = '<div class=\'d_p\'>
    El hangar planetario es responsable de la construcción de naves espaciales y sistemas de defensa. 
    <br /><br /> 
    Según va aumentando, puede producir una mayor variedad de naves a velocidades más altas. Si además existe una fábrica de nanobots en el planeta, la velocidad a la que se completan las unidades, aumenta considerablemente.
    </div>';
    
    public $silo_name = 'Silo'; 
    public $silo_desc = '<div class=\'d_p\'>
    El silo es un lugar de almacenamiento y lanzamiento de misiles planetarios. 
    <br /><br /> 
    Por cada nivel de tu silo, tienes espacio para 5 misiles interplanetarios o 10 misiles de intercepción. Es posible mezclar los tipos de misil; 1 interplanetario usa el espacio equivalente a 2 de intercepción.
    </div>';
    
    public $terraforming_name = 'Terraformer'; 
    public $terraforming_desc = '<div class=\'d_p\'>
    La pregunta sobre cómo disponer de más espacio para las estructuras en los planetas surgió durante el proceso de crecimiento de las infraestructuras de los mismos a través de las galaxias. Los métodos de construcción e ingenería tradicional eran insuficientes debido a la enorme necesidad de espacio edificable. 
    <br /><br /> 
    Un pequeño grupo de físicos de alta energía y nanotécnicos finalmente encontraron una solución: el Terraforming.
    <br />
    Usando grandes cantidades de energía se pueden hacer incluso continentes enteros. En este edificio se producen nanobots diseñados especialmente para asegurar la calidad y usabilidad de las areas formadas, cada nivel incrementa en 5 los campos disponibles.
    </div>
    <div class=\'s_p\'>Una vez construido, el terraformer no puede ser desmontado.</div>';
    
    public $central_name = 'Central de Comercio'; 
    public $central_desc = '<div class=\'d_p\'>
    La central de comercio es una edificación de oficinas encargada de mantener todas las relaciones comerciales de un planeta con el resto del universo, habilita todas las posibilidades de comercio exterior.
    </div>
    <div class=\'s_p\'>Una vez construida, no puede ser desmontada. Máximo un nivel.</div>';
    
    public $centro_rec_name = 'Centro de Reciclaje';
    public $centro_rec_desc = '<div class=\'d_p\'>
    El centro de reciclaje es una edificación que permite destruir naves y defensas para convertirlas en recursos nuevamente. 
    <br /><br />
    Cada nivel de el centro de reciclaje incrementa las ganancias obtenidas en un 10%.
    </div>
    <div class=\'s_p\'>No es posible devolver deuterio.</div>';
    
}

?>