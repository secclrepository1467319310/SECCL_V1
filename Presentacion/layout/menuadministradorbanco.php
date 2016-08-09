<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="../jquery/jquery-1.9.1.js"></script>
<script src="../jquery/jquery-ui.js"></script>
<script >
    var jq=$.noConflict();
//    jq(document).on("click",".exportacion",function(ev){
//            ev.preventDefault();
//            alert("hola");
////            dialog.dialog( "open" );
////            jq(dialog).attr("href",$(this).attr("href"));
//        });
//        jq(document).ready(function(){
//        alert("Hola");
        jq(document).on("click",".exportacion",function(ev){
            ev.preventDefault();
            jq(".hidden").removeClass("hidden");
            var dateoptions={dateFormat:"dd/mm/y",
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                    changeMonth: true
                };
//                alert("Hola")
            console.log(jq.datepicker);
            if (typeof controladorDP != 'undefined'){
                var fechainicial=$("#fechainicial").datepicker(dateoptions);
                var fechafinal=$("#fechafinal").datepicker(dateoptions);
            }else{
                var fechainicial=jq("#fechainicial").datepicker(dateoptions);
                var fechafinal=jq("#fechafinal").datepicker(dateoptions);
            }
            var fechainicial=jq("#fechainicial").datepicker(dateoptions);
            var fechafinal=jq("#fechafinal").datepicker(dateoptions);
            dialog = jq( "#dialog-form" ).dialog({
                autoOpen: false,
                height: 300,
                width: 350,
                modal: true,
                buttons: {
                  "Aceptar": function(){
                      
//                      fechainicial.val();
//                      fechafinal.val();
                      var direccion=jq(this).attr("href");
    //                  var direccion=jq(".exportacion").attr("href");
    //                  href=direccion;
//                      location.href=direccion+((direccion.substring(direccion.length-4,direccion.length)===".php")?"?":"&")+"fechainicial="+fechainicial.val()+"&fechafinal="+fechafinal.val();
//                        if(jq("[name=fechainicial]").val().trim()!="" &&jq("[name=fechafinal]").val().trim()!=""){
                            dialog.dialog("close");
                            window.open(direccion+((direccion.substring(direccion.length-4,direccion.length)===".php")?"?":"&")+"fechainicial="+fechainicial.val()+"&fechafinal="+fechafinal.val());
//                        }
                  },
                  Cancelar: function() {
                    dialog.dialog( "close" );
                  }
                },
                close: function() {
    //                      form[ 0 ].reset();
    //                      allFields.removeClass( "ui-state-error" );
                }
              });
            dialog.dialog( "open" );
            jq(dialog).attr("href",$(this).attr("href"));
        })

</script>

<style>
    body { font-size: 62.5%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
    #dialog-form{
        background-color: white;
    }
    .hidden{display:none}
</style>
<div id="menu">
    <ul id="nav">
        <li class="top"><a href="../Presentacion/menuadministradorbanco.php" class="top_link"><span>Inicio</span></a>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Proyectos</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/proyectos_verificados.php">Observaciones Proyectos</a></li>
                <li><a href="../Presentacion/ProyectosAuditores.php">Todos Proyectos</a></li>
                <li><a href="../Presentacion/poa_validacion.php">PAECCL</a></li>
            </ul>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Crear cronograma usuarios</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/cronograma_usuario.php">Cronograma usuarios</a></li>
            </ul>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Banco Ítems</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/solicitudes_b.php">Solicitudes</a></li>
                <li><a class="exportacion" href="../Presentacion/ExpSolicitudesRealizadas.php">Reporte Solicitudes</a></li>
                <li><a href="../Presentacion/modificar_estado_instrumentos.php">Estado Instrumentos</a></li>
                <li><a href="../Presentacion/instrumentos.php" target="_blank">Catalogo de instrumentos</a></li>
            </ul>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Estados Solicitudes</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/ver_atendidas_banco.php">Atendidas</a></li>
                <li><a href="../Presentacion/ver_pendientes_banco.php">Pendientes</a></li>
                <li><a href="../Presentacion/ver_enrevision_banco.php">En Revisión</a></li>
                <li><a href="../Presentacion/ver_devueltas_banco.php">Devueltas</a></li>
            </ul>
        </li>
        <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>
    </ul>
</div>

<div id="dialog-form" class="hidden" title="Escoja sus fechas">
    <p class="validateTips">Escoja fechas</p>

    <form>
      <fieldset>
        <label for="fechainicial">fecha inicial</label>
        <input readonly="readonly" type="text" name="fechainicial" id="fechainicial" value="" class="text ui-widget-content ui-corner-all">
        <label for="fechafinal">fecha final</label>
        <input readonly="readonly" type="text" name="fechafinal" id="fechafinal" value="" class="text ui-widget-content ui-corner-all">
        <!-- Allow form submission with keyboard without duplicating the dialog button -->
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
      </fieldset>
    </form>

  </div>