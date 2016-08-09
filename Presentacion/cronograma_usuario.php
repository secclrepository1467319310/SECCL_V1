<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE HTML>
<html>
    <!--        CREDITOS  CREDITS
Plantilla modificada por: Ing. Jhonatan Andrés Garnica Paredes
Requerimiento: Imagen Corporativa App SECCL.
Sistema Nacional de Formación para el Trabajo - SENA, Dirección General
última actualización Diciembre /2013
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="./images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--<script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>-->
        <!--<script src="../jquery/jquery-1.4.4.min.js"></script>-->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <!--<script src="../js/multipleDatePickr.js"></script>-->

        <script type="text/javascript">
            var controladorDP=function(){};
//            jq=$;
//        var jq=jQuery.noConflict();
            $(document).ready(function() {
//                $("#f1").validate({
//                    rules:{
//                        fecha_cronograma:{
//                            required:true
//                        },
//                        tipo_operacion:{
//                            required:true
//                        },
//                        "usuarios[]":{
//                            required:true
//                        },
//                        observacion:{
//                            maxlength:300
//                        }
//                        
//                    }
//                });

                $("#tipo_operacion").on("change",function(){
                    console.log("fecha"+$(this).val());
                    $(".fechas").css("display","none");
                    $("#fecha"+$(this).val()).css("display","block")
                });
                
                //$("table",$(".btnMinimizar").parent()).hide();
                $(".btnMinimizar").on("click",function(){
                    var table=$("table",$(this).parent());
                    if($(this).val()=="+"){
                        $(table).show();
                        $(this).val("-");
                    }else if($(this).val()=="-"){
                        $(this).val("+");
                        $(table).hide();                        
                        
                    }else{
                        throw new Exception("ERROR GENERAL");
                    }
                });
                $(".btnCambiar").attr("disabled","disabled");
                $(".selectUsuario").on("change",function(){
                    var context=$(this).parent().parent();                    
                    $(".btnCambiar",context).removeAttr("disabled")
                })
                
                $(".btnCambiar").on("click",function (){
                    var tr=$(this).parent().parent();
                    var usuario=$("[name=usuario]",tr).val() ;
                    var operacion=$("[name=operacion]",tr).val() ;
                    var fecha_cronograma=$("[name=fecha_cronograma]",tr).val();
                    var id_cronograma_operacion=$("[name=id_cronograma_operacion]",tr).val();
                    var usuario_antiguo=$("[name=usuario_antiguo]",tr).val();
                    console.log(fecha_cronograma+"-"+operacion+"-"+usuario+"-"+id_cronograma_operacion);
                    $.ajax({
                        url:"cronograma_usuario_ajax.php",
                        type:"post",
                        data:{
                            usuario:usuario,
                            operacion:operacion,
                            fecha_cronograma:fecha_cronograma,
                            id_cronograma_operacion:id_cronograma_operacion,
                            usuario_antiguo:usuario_antiguo
                        },
                        success:function(success){
                            console.log(success);
                            var Mensaje="";
                            var controlador=false;
                            switch(success){
                                case "1":
                                    Mensaje="Modificación correcta ";
                                    controlador=true;
                                    break;
                                case "2":
                                    Mensaje="Error al asignar el cronograma";
                                    break;
                                case "3":
                                    Mensaje="Error al inhabilitar el usuario";
                                    break;
                                case "4":
                                    Mensaje="Error de consistencia de datos, puede que haya un mismo tipo de solicitud en la misma fecha para diferentes usuarios";
                                    break;
                                default:
                                    Mensaje="Error indefinido";
                                    break;
                            }
                            alert(Mensaje);
                            if(controlador){
                                window.location.href=window.location.href;
                            }
                        },
                        error:function(error){
                            console.error(error);
                        }
                    });
                    
                })
                // Initialise Plugin
                var options1 = {
                    clearFiltersControls: [$('#cleanfilters')],
                    matchingRow: function(state, tr, textTokens) {
                        if (!state || !state.id) {
                            return true;
                        }
                        var val = tr.children('td:eq(2)').text();
                        switch (state.id) {
                            case 'onlyyes':
                                return state.value !== 'true' || val === 'yes';
                            case 'onlyno':
                                return state.value !== 'true' || val === 'no';
                            default:
                                return true;
                        }
                    }
                };

                $('#demotable1').tableFilter(options1);

                var grid2 = $('#demotable2');
                var options2 = {
                    filteringRows: function(filterStates) {
                        grid2.addClass('filtering');
                    },
                    filteredRows: function(filterStates) {
                        grid2.removeClass('filtering');
                        setRowCountOnGrid2();
                    }
                };
                function setRowCountOnGrid2() {
                    var rowcount = grid2.find('tbody tr:not(:hidden)').length;
                    $('#rowcount').text('(Rows ' + rowcount + ')');
                }

                grid2.tableFilter(options2); // No additional filters           
                setRowCountOnGrid2();
            });
        </script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
        <!--<script src="../jquery/jquery-1.4.4.min.js"></script>------>
        <!--<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>-->
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
            
            var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;



            function inicio() {

                if (is_chrome) {
                    /*var posicion = navigator.userAgent.toLowerCase().indexOf('chrome/');
                     var ver_chrome = navigator.userAgent.toLowerCase().substring(posicion+7, posicion+11);
                     //Comprobar version
                     ver_chrome = parseFloat(ver_chrome);
                     alert('Su navegador es Google Chrome, Version: ' + ver_chrome);*/
                    document.getElementById("flotante")
                            .style.display = 'none';
                }
                else {
                    document.getElementById("flotante")
                            .style.display = '';
                }

            }
            function cerrar() {
                document.getElementById("flotante")
                        .style.display = 'none';
            }
        </script>
        <!--<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>-->
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../js/multipleDatePickr.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        
        <style>
            .ui-state-highlight{
                border: 1px solid red !important;
            }
/*            .ui-datepicker-today>.ui-state-highlight{
                background-color: white !important;
            }*/
            .ui-widget-content .ui-state-highlight{
                   background: rgba(14, 255, 101, 0.39) url("images/ui-bg_glass_55_fbf9ee_1x400.png") 50% 50% repeat-x; 
            }
            .fechas{
                display:none;
            }            
        </style>
    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <script>
            
            $(document).ready(function(){
                $("#f1").validate({
                    rules:{
                        fecha_cronograma:{
                            required:true
                        },
                        tipo_operacion:{
                            required:true
                        },
                        "usuarios[]":{
                            required:true
                        },
                        observacion:{
                            maxlength:300
                        }
                        
                    }
                });
               $("#fecha_cronograma").multiDatesPicker({
                    changeMonth:true,
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                    altField: "[name='fecha_cronograma']",
                    addDates:$("input[name='fecha_cronograma']").val()?$("input[name='fecha_cronograma']").val():false,
                });
                
//                $("#fecha_cronogramaop1").multiDatesPicker({
//                    changeMonth:true,
//                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
//                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
//                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
//                    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
//                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
////                    altField: "[name='fecha_cronogramaop1']",
//                    addDates:$("input[name='fecha_cronogramaop1']").val()?$("input[name='fecha_cronogramaop1']").val().split(","):false,
//                });
//                $("#fecha_cronogramaop2").multiDatesPicker({
//                    changeMonth:true,
//                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
//                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
//                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
//                    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
//                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
////                    altField: "[name='fecha_cronogramaop2']",
//                    addDates:$("input[name='fecha_cronogramaop2']").val()? $("input[name='fecha_cronogramaop2']").val().split(","):false,
//                });
//                $("#fecha_cronogramaop3").multiDatesPicker({
//                    changeMonth:true,
//                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
//                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
//                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
//                    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
//                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
////                    altField: "[name='fecha_cronogramaop3']",
//                    addDates:$("input[name='fecha_cronogramaop3']").val()?$("input[name='fecha_cronogramaop3']").val().split(","):false,
//                });
                
                
            })
        </script>
        <div id="contenedorcito"> 
        <center>
           <form action="guardar_cronograma_usuario.php" name="f1" id="f1" method="post" accept-charset="ISO-8859-1">
           <?php if($_GET[modificacion]==null):?>
                <input type="hidden" name="tipo" value="C">                   
                <table>
                <caption style="background-color: #F57A38;color: #fff; font-size: 1.50em;">Creación de cronograma<br/></caption>
                    <tr>
                        <td><label for="fecha_cronograma">Fecha: </label></td>
                        
                        <td><div id="fecha_cronograma"></div><input type="text" readonly="readonly" value="<?php echo ($rinfocronograma[FECHA_CRONOGRAMA])?DateTime::createFromFormat('d/m/Y',preg_replace_callback("/[0-9]{2}$/",function($todo){
                                return "20$todo[0]";                        
                        },$rinfocronograma[FECHA_CRONOGRAMA]))->format('m/d/Y'):"";  ?>" name="fecha_cronograma" /></td>
                         
                        <!--<td></td>-->
                    </tr>                        
                    <tr>
                        <td><label for="observacion">Observación:  </label></td>
                        <td><input id="observacion" type="text" name="observacion" value="<?php  echo utf8_encode($rinfocronograma[OBSERVACION]) ?>"/></td>
                    </tr>
                    <tr>
                        <td><label for="tipo_operacion">Tipo operación banco:  </label></td>
                        <td>
                            <select name="tipo_operacion" id="tipo_operacion" >
                            <option value="" >Seleccione una opción </option>
                                <?php 
                                    $infotipooperacion="SELECT * FROM T_TIPO_OPERACION_BANCO";
                                    $sinfotipooperacion=oci_parse($connection, $infotipooperacion);
                                    oci_execute($sinfotipooperacion);
                                    while ($row=oci_fetch_array($sinfotipooperacion,OCI_BOTH)) {
                                        ?>
                                        <option <?php if($rinfocronograma[ID_T_TIPO_OPERACION_BANCO]==$row[ID_OPERACION]) { ?> selected="selected" <?php } ?>value="<?php echo $row[ID_OPERACION]?>" ><?php echo $row["DESCRIPCION"] ?> </option> 

                                        <?php
                                    }
                                ?>

                            </select>
                        </td>
                    </tr>
                </table>
                <br/>
                <table>
                    <caption style="background-color: #F57A38;color: #fff; font-size: 1.50em;">Seleccione un usuario<br/></caption>
                    <tr>
                        <td>Id usuario</td>
                        <td>Nombre usuario</td>
                        <td>Usuario login</td>
                        <td>Rol</td>
                        <!--<td>Ver el cronograma</td>-->
                    </tr>
                
                    <?php 
                    $infousuarios="SELECT * FROM USUARIO U JOIN ROL R ON(U.ROL_ID_ROL=R.ID_ROL) WHERE U.ESTADO=1   AND ID_ROL=2";
                    $sinfousuarios=oci_parse($connection, $infousuarios);
                    oci_execute($sinfousuarios);
                    $ctrlrc="radio";
                    while ($row= oci_fetch_array($sinfousuarios,OCI_BOTH)) {

                        $uregistr=$row[USUARIO_ID]==$rinfocronograma[ID_USUARIO_ASIGNADO]?'checked':'';
                        echo "<tr>";
                        echo "<td><input type=\"$ctrlrc\" name=\"usuarios[]\" $uregistr value=\"$row[USUARIO_ID]\"/></td>";
                        echo "<td>".utf8_encode("$row[NOMBRE] $row[PRIMER_APELLIDO] $row[SEGUNDO_APELLIDO]")."</td>";
                        echo "<td>$row[USUARIO_LOGIN]</td>";
                        echo "<td>$row[DESCRIPCION]</td>";
//                        echo "<td><a href='cronograma_usuario.php?usuario=$row[USUARIO_ID]'>Cronograma </a></td>";
                        echo "</tr>";
                    }

                    ?> 
                </table>
                <br/>
                <input type="submit" value="Guardar">
                <br/>
                <br/>
                <a href="?modificacion=1">Modificar usuario</a>
                <br/>
            <?php else:?>
                <a href="?">Creación de cronograma</a><br/>
                <a id="cleanfilters" href="#">Limpiar Filtros</a><br/>
                <input type="hidden" name="tipo" value="M">
                <div>
                    <input type="button" class="btnMinimizar" value="-"/>Minimizar
                    <table id="demotable1">
                        <thead>
                            
                            <tr>
                                <th>Fecha cronograma</th>
                                <th>Usuario actual</th>
                                <th>Usuario asignado</th>
                                <th>Observación</th>
                                <th>Tipo de solicitud</th>
                                <th>Corregir</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <?php 
                            $qCronogramaUsuario="SELECT * FROM CRONOGRAMA_USUARIO WHERE FECHA_CRONOGRAMA >= to_char(sysdate,'DD/MM/YY') and estado='1' ORDER BY FECHA_CRONOGRAMA ASC,ID_T_TIPO_OPERACION_BANCO ASC";
                            $sCronogramaUsuario=  oci_parse($connection, $qCronogramaUsuario);
                            oci_execute($sCronogramaUsuario);

                            $infousuarios="SELECT * FROM USUARIO U JOIN ROL R ON(U.ROL_ID_ROL=R.ID_ROL) WHERE U.ESTADO=1   AND ID_ROL=2";
                            $sinfousuarios=oci_parse($connection, $infousuarios);
                            oci_execute($sinfousuarios);
                            $cInfoUsuarios=oci_fetch_all($sinfousuarios, $oinfoUsuario);


                            $qOperacion="SELECT * FROM T_TIPO_OPERACION_BANCO";
                            $sOperacion=oci_parse($connection, $qOperacion);
                            oci_execute($sOperacion);
                            $cOperacion=oci_fetch_all($sOperacion, $oOperacion);
    //                        var_dump($output);

                            while($rCronogramaUsuario=  oci_fetch_array($sCronogramaUsuario,OCI_ASSOC)){
                                ?>
                                <tr>
                                    <td><input type="hidden" name="id_cronograma_operacion" value="<?=$rCronogramaUsuario[ID_CRONOGRAMA_USUARIO]?>"/><input type="hidden"  name="fecha_cronograma" value="<?=$rCronogramaUsuario[FECHA_CRONOGRAMA]?>"/><?=$rCronogramaUsuario[FECHA_CRONOGRAMA]?></td>
                                    <td>
                                        <?php
                                            for($i=0;$i<$cInfoUsuarios;$i++){
                                                $selected="";
                                                if($oinfoUsuario[USUARIO_ID][$i]==$rCronogramaUsuario[ID_USUARIO_ASIGNADO]){
                                                    echo utf8_encode($oinfoUsuario[NOMBRE][$i]." ".$oinfoUsuario[PRIMER_APELLIDO][$i]." ". $oinfoUsuario[SEGUNDO_APELLIDO][$i]);
                                                }
                                                ?>
                                                
                                                <?php
                                            }
                                            ?>  
                                        
                                        
                                    </td>
                                    <td><input type="hidden" name="usuario_antiguo" value="<?=$rCronogramaUsuario[ID_USUARIO_ASIGNADO]?>"/>
                                        <select name="usuario" class="selectUsuario">
                                            <?php
                                            for($i=0;$i<$cInfoUsuarios;$i++){
                                                $selected="";
                                                if($oinfoUsuario[USUARIO_ID][$i]==$rCronogramaUsuario[ID_USUARIO_ASIGNADO]){
                                                    $selected="selected";
                                                }
                                                ?>
                                                <option  <?=$selected?> value="<?=$oinfoUsuario[USUARIO_ID][$i]?>"><?=utf8_encode($oinfoUsuario[NOMBRE][$i]." ".$oinfoUsuario[PRIMER_APELLIDO][$i]." ". $oinfoUsuario[SEGUNDO_APELLIDO][$i])?></option>
                                                <?php
                                            }
                                            ?>                                        
                                        </select>



                                    </td>
                                    <td><?=$rCronogramaUsuario[OBSERVACION]?></td>
                                    <td><input type="hidden" name="operacion" value="<?=$rCronogramaUsuario[ID_T_TIPO_OPERACION_BANCO]?>"/>
                                        <?php for($i=0;$i<$cOperacion;$i++){                                                
                                                    if($oOperacion[ID_OPERACION][$i]==$rCronogramaUsuario[ID_T_TIPO_OPERACION_BANCO]){
                                                      echo $oOperacion[DESCRIPCION][$i];
                                                    }
                                                    ?>                                                
                                                    <?php
                                                }            
                                        ?>
                                    </td>
                                    <td>
                                        <input type="button" value="corregir" class="btnCambiar"/>
                                    </td>
                                </tr>    
                                <?php
                            }
                        ?>
                    </table>
                </div>
                <hr/>
                <div >
                    <input type="button" class="btnMinimizar" value="+"/>
                    Historial de cambios en el cronograma
                    <table style="display:none">
                        <tr>
                            <th>Fecha cronograma</th>
                            <th>Usuario asignado</th>
                            <th>Observación</th>
                            <th>Tipo de solicitud</th>
                        </tr>
                        <?php 
                        
                            $qCronogramaUsuario="SELECT * FROM CRONOGRAMA_USUARIO WHERE  estado='0' ORDER BY FECHA_CRONOGRAMA ASC,ID_T_TIPO_OPERACION_BANCO ASC";
                            $sCronogramaUsuario=  oci_parse($connection, $qCronogramaUsuario);
                            oci_execute($sCronogramaUsuario);

                            $infousuarios="SELECT * FROM USUARIO U JOIN ROL R ON(U.ROL_ID_ROL=R.ID_ROL) WHERE U.ESTADO=1   AND ID_ROL=2";
                            $sinfousuarios=oci_parse($connection, $infousuarios);
                            oci_execute($sinfousuarios);
                            $cInfoUsuarios=oci_fetch_all($sinfousuarios, $oinfoUsuario);


                            $qOperacion="SELECT * FROM T_TIPO_OPERACION_BANCO";
                            $sOperacion=oci_parse($connection, $qOperacion);
                            oci_execute($sOperacion);
                            $cOperacion=oci_fetch_all($sOperacion, $oOperacion);
    //                        var_dump($output);

                            while($rCronogramaUsuario=  oci_fetch_array($sCronogramaUsuario,OCI_ASSOC)){
                                ?>
                                <tr>
                                    <td><?=$rCronogramaUsuario[FECHA_CRONOGRAMA]?></td>
                                    <td>
                                        <?php for($i=0;$i<$cInfoUsuarios;$i++){                                                
                                                    if($oinfoUsuario[USUARIO_ID][$i]==$rCronogramaUsuario[ID_USUARIO_ASIGNADO]){
                                                      echo utf8_encode($oinfoUsuario[NOMBRE][$i]." ".$oinfoUsuario[PRIMER_APELLIDO][$i]." ". $oinfoUsuario[SEGUNDO_APELLIDO][$i]);
                                                    }
                                                    ?>                                                
                                                    <?php
                                                }            
                                        ?>
                                    </td>
                                    <td><?=$rCronogramaUsuario[OBSERVACION]?></td>
                                    <td>
                                        <?php for($i=0;$i<$cOperacion;$i++){                                                
                                                    if($oOperacion[ID_OPERACION][$i]==$rCronogramaUsuario[ID_T_TIPO_OPERACION_BANCO]){
                                                      echo $oOperacion[DESCRIPCION][$i];
                                                    }
                                                    ?>                                                
                                                    <?php
                                                }            
                                        ?>
                                    </td>
                                    
                                </tr>    
                                <?php
                            }
                        ?>

                    </table>
                </div>
            <?php endif;?>
            </form>
             <br/>
             <br/>
        </center>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>