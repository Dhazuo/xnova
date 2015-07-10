<div id="abastecimiento_bg">
    <div class="titulo">{$abastecimiento}</div>
    <div id="abastecimiento_bg_inter">
     {foreach from=$building item=build}
      <div class="item_abastecimiento">
         <form action="?core=provision&id={$build.id}" method="POST">
            <div class="titulo_item">
                <a href="#{$build.id}" class="ve{$build.id}"><span class="a">{$build.name_lng}</span></a>
                <span class="b">{$build.nivel}</span>
            </div>
            
            <a href="#{$build.id}" class="ve{$build.id}">
                <img class="img_abas" src="styles/xnova/images/construibles/{$build.image}.jpg" width="78" height="78" />
            </a>
            
            {$build.build}
            {$build.destroy}
                
            <span class="tiempo_construccion_abas">{$build.tiempo_c}</span>
            <span class="tiempo_destruccion_abas">{$build.tiempo_d}</span>

                <div class="costes_abas">
                    <div class="tooltipted coste_metal" title="{$build.metal}"></div>
                    <div class="tooltipted coste_cristal" title="{$build.cristal}"></div>
                    <div class="tooltipted coste_tritio" title="{$build.tritio}"></div>
                    <div class="tooltipted coste_materia" title="{$build.materia}"></div>
                    <img src="styles/xnova/images/recursos/{$build.precios}.png" />
                </div> 
            </form>
        </div>

        <script type="text/javascript"> 
            $('.ve{$build.id}').click(function(){
            $('#info{$build.id}').simplePopup();
            });
        </script> 

        <div id="info{$build.id}" class="simplePopup">
           <div class="img_pop">
               <img class="img_abas" src="styles/xnova/images/construibles/{$build.image}.jpg" width="170" height="170" />                      </div>
           <div class="nombre_pop">{$build.name_lng}</div>
           {$build.desc_lng}
        </div>
        {/foreach}
        
        
          </div>
</div>
<div id="abastecimiento_log"></div>

<div id="cola_actual">
    <div class="colas_edif"></div>
</div>

{include 'overall/footer.xnv'}