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
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {
$('.agregar').click(function(){
                console.log(this);
                    console.info("textarea"+$(this).attr("id_solicitud"));
//                    console.log($(this).attr("id_solicitud"));
//                    console.log($("#textarea"+$(this).attr("id_solicitud")).val());
                    if($("#textarea"+$(this).attr("id_solicitud")).val()!=""){
                        $.ajax({
                            url:"Guardar_Observ_Banco_solic.php",
                            data:{
                                Id_solicitud:$(this).attr("id_solicitud"),
                                Observacion:$("#textarea"+$(this).attr("id_solicitud")).val()
                            },
                            type:"POST",
                            error:function(error){
                                console.log(error)
                            },
                            success:function(success){
                                console.log(success)
                                if(success=="Éxito al guardar"){
                                    window.location.reload();
                                }
                                else{
                                    alert("Hubo un error");
                                }
                            }
                        });
                    }
                });

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


    </head>
    <body onload="inicio()">

        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div>

                <center><?php echo '<font><strong>Solicitudes recibidas</strong></font>'; ?></center>

                <br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>

                <center>
                    <form><br><br>
                        <center>
                            <table id="demotable1" >
                                <thead><tr>
                                        <th>N°</th>
                                        <th>Radicado Solicitud</th>
                                        <th>Tipo Solicitud</th>
                                        <th>Mesa</th>
                                        <th>Código Regional</th>
                                        <th>Regional</th>
                                        <th>Código Centro</th>
                                        <th>Centro</th>
                                        <th>Entidad</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Hora Solicitud</th>
                                        <th>Observación Administrador Banco</th>
                                        <th>Lider</th>
                                        <th>Detalles</th>
                                        <th>Estado</th>
                                        <th>Responder</th>
                                        <th>Fecha Estado</th>
                                        <th>Hora Estado</th>
                                        <th>Observación</th>
                                        <th>Observaciones Admin Banco</th>
                                        <th>Observaciones Asesor Banco</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>
                                <?php
                                $query = "SELECT SA.OBSERVACION AS OBSER,P.ID_REGIONAL,R.NOMBRE_REGIONAL,P.ID_CENTRO,
                                    CE.NOMBRE_CENTRO,TOB.ID_PROYECTO,TOB.ID_NORMA,TOB.N_GRUPO,TOB.ID_OPERACION,TOB.FECHA_REGISTRO,
                                    TOB.HORA_REGISTRO,SA.ID_SOLICITUD,P.NIT_EMPRESA,TOB.OBSERVACION,TB.DESCRIPCION, USU.NOMBRE, USU.PRIMER_APELLIDO, USU.SEGUNDO_APELLIDO
                                                    FROM T_OPERACION_BANCO TOB
                                                    INNER JOIN T_SOLICITUDES_ASIGNADAS SA ON TOB.ID_OPERACION = SA.ID_SOLICITUD
                                                    INNER JOIN PROYECTO P ON P.ID_PROYECTO=TOB.ID_PROYECTO 
                                                    INNER JOIN CENTRO CE ON CE.CODIGO_CENTRO=P.ID_CENTRO 
                                                    INNER JOIN REGIONAL R ON R.CODIGO_REGIONAL=CE.CODIGO_REGIONAL
                                                    INNER JOIN T_TIPO_OPERACION_BANCO TB ON TOB.ID_T_OPERACION = TB.ID_OPERACION
                                                    INNER JOIN USUARIO USU ON TOB.USU_REGISTRO = USU.USUARIO_ID
                                                    WHERE SA.USUARIO_ASIGNADO = " . $_SESSION[USUARIO_ID] . " AND SA.ESTADO = 1 "
                                        . "ORDER BY  CASE  WHEN SA.OBSERVACION  ='Asignada Automaticamente por el sistema Devoluci�n Previa' OR SA.OBSERVACION  ='Asignada Automaticamente por el sistema Devolución Previa' THEN 0 ELSE 1 END  , TOB.ID_OPERACION ASC";
                                
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 1;
                                $anterior = 1;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                    $query3 = ("SELECT CODIGO_NORMA, NOMBRE_MESA FROM NORMA NOR "
                                            . "INNER JOIN MESA MES "
                                            . "ON NOR.CODIGO_MESA = MES.CODIGO_MESA "
                                            . "WHERE ID_NORMA='$row[ID_NORMA]'");
                                    $statement3 = oci_parse($connection, $query3);
                                    $resp3 = oci_execute($statement3);
                                    $cnorma = oci_fetch_array($statement3, OCI_BOTH);

                                   $query222 = "SELECT ES.ID_SOLICITUD, TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD = '" . $row['ID_SOLICITUD'] . "' ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                                    $statement222 = oci_parse($connection, $query222);
                                    oci_execute($statement222);
                                    $rows222 = oci_fetch_array($statement222, OCI_BOTH);
                                    
                                    $query223 = "SELECT ES.ID_SOLICITUD, TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD =  $row[ID_SOLICITUD] AND (ES.ID_TIPO_ESTADO_SOLICITUD = 2 OR  ES.ID_TIPO_ESTADO_SOLICITUD = 3) ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                                    $statement223 = oci_parse($connection, $query223);
                                    oci_execute($statement223, OCI_DEFAULT);
                                    $rowsNum223 = oci_fetch_all($statement223, $rows223);
                                    
                                    
//                                    var_dump($rows222);
                                    if ($rows222['ID_TIPO_ESTADO_SOLICITUD'] != 1 && $rows222['ID_TIPO_ESTADO_SOLICITUD'] != 4) {
                                        $queryProyecto = "SELECT *
                                                FROM PROYECTO
                                                WHERE ID_PROYECTO = " . $row['ID_PROYECTO'];
                                        $statementProyecto = oci_parse($connection, $queryProyecto);
                                        oci_execute($statementProyecto);
                                        $proyecto = oci_fetch_array($statementProyecto, OCI_BOTH);
                                        echo "<tr><td><font face=\"verdana\">" .
                                        $numero . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        'R' . $row["ID_REGIONAL"] . '-' . 'C' . $row ["ID_CENTRO"] . '-P' . $row["ID_PROYECTO"] . '-' . $cnorma[0] . '-' . $row["N_GRUPO"] . '-' . $row["ID_OPERACION"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row['DESCRIPCION'] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        utf8_encode($cnorma[1]) . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["ID_REGIONAL"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        utf8_encode($row["NOMBRE_REGIONAL"]) . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["ID_CENTRO"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        utf8_encode($row["NOMBRE_CENTRO"]) .$rows222['ID_TIPO_ESTADO_SOLICITUD']. "</font></td>";
                                        
//                                        echo "<td><font face=\"verdana\">" . $proyecto['NIT_EMPRESA'] . "</font></td>";
                                        if ($proyecto["NIT_EMPRESA"] == null) {
                                            echo "<td><font face=\"verdana\">Demanda Social</font></td>";
                                        } else {
                                            $queryEmpresa = "SELECT *
                                                FROM EMPRESAS_SISTEMA
                                                WHERE NIT_EMPRESA = " . $proyecto['NIT_EMPRESA'];
                                            $statementEmpresa = oci_parse($connection, $queryEmpresa);
                                            oci_execute($statementEmpresa, OCI_DEFAULT);
                                            $empresa = oci_fetch_all($statementEmpresa, $rowsEmpresa);
                                            echo "<td><font face=\"verdana\">" . utf8_encode($rowsEmpresa['NOMBRE_EMPRESA'][0]) . "</font></td>";
                                        }
                                        echo "<td><font face=\"verdana\">" .
                                        $row["FECHA_REGISTRO"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["HORA_REGISTRO"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["OBSER"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["NOMBRE"] ." ". $row["PRIMER_APELLIDO"] ." ". $row["SEGUNDO_APELLIDO"] . "</font></td>";
                                        echo "<td><a href=\"consultar_grupo_b2.php?proyecto=" . $row["ID_PROYECTO"] . "&n=" . $cnorma . "&norma=" . $row[ID_NORMA] . "&grupo=" . $row["N_GRUPO"] . "\" target='_blank'>
                                                        Consultar</a></td>";
                                        echo "<td>" . $rows[COMENTARIOS][$i] . "</td>";

                                        if ($rowsNum223 >  0) {
                                            echo "<td><a href=\"responder_solicitudes_banco.php?solicitud=" . $row['ID_SOLICITUD'] . "\" target='_blank'>" . utf8_encode($rows222[DETALLE]) . "</a></td>";
                                            echo "<td>" . $rows222[FECHA_REGISTRO] . "</td>";
                                            echo "<td>" . $rows222[HORA_REGISTRO] . "</td>";
                                        } else if ($rowsNum223 == 0){
                                            if ($anterior == 0) {
                                                echo "<td>No disponible</td><td>No disponible</td><td>No disponible</td>";
                                            } else {
                                                echo "<td><a href=\"responder_solicitudes_banco.php?solicitud=" . $row['ID_SOLICITUD'] . "\" target='_blank'>
                                                        Responder</a></td><td>No disponible</td><td>No disponible</td>";
                                            }
                                        }
                                        echo "<td>$row[OBSERVACION]</td>";
                                        $numero++;
                                        $anterior = $rowsNum223;
                                        $qobservacionsolicitudes="  SELECT OBS.*,U.ROL_ID_ROL FROM T_OBSERV_BANCO_SOLIC OBS 
                                                inner join  USUARIO U
                                                ON (OBS.USUARIO_REGISTRO=U.USUARIO_ID) 
                                                WHERE OBS.ID_SOLICITUD='".$row[ID_OPERACION]."'";
                                        $Sobservacionsolicitudes = oci_parse($connection, $qobservacionsolicitudes);
                                        //die($qobservacionsolicitudes);
                                        oci_execute($Sobservacionsolicitudes);

                                        $contador=0;
                                        $CONTROLADORABANDO=false;
                                        $CONTROLADORAASESOR=false;
                                        while($Robservacionsolicitudes=oci_fetch_array($Sobservacionsolicitudes,OCI_ASSOC)){
                                                
                                                //echo "<hr/>";
                                            if($Robservacionsolicitudes[ROL_ID_ROL]==13){
                                                $CONTROLADORABANDO=$Robservacionsolicitudes[OBSERVACION];
                                            }
                                            if($Robservacionsolicitudes[ROL_ID_ROL]==2){
                                                $CONTROLADORAASESOR=$Robservacionsolicitudes[OBSERVACION];
                                            }
                                            $contador++;
                                        }
                                        ?>
                                            <TD><?=$CONTROLADORABANDO?></TD>
                                        <td>
                                            <?php 
                                            if($CONTROLADORAASESOR===false){
                                                ?>
                                                    <div>
                                                        <input type="hidden" name='id_solicitud' value="<?php echo $row["ID_OPERACION"];?>"/>
                                                        <textarea name='observacion_solicitud' id="textarea<?php echo $row["ID_OPERACION"];?>"></textarea>
                                                        <input type='button' class='agregar' id_solicitud="<?php echo $row["ID_OPERACION"];?>" value='agregar'/>
                                                    </div>
                                            
                                                <?php
                                            }else{
                                             ?>   
                                            <?= $CONTROLADORAASESOR?>
                                            <?php }?>
                                        </td>
                                      </tr>
                                      <?php
                                    }
                                }
                                ?>
                            </table>
                        </center><br></br>
                    </form>                    
                </center>
                <?php
                oci_close($connection);
                ?>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>