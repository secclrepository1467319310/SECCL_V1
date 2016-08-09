<?php
session_start();

if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
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

//                alert('Hola Dina, nos encontramos realizando pruebas en esta vista, por favor no te asustes, gracias y perdon por las molestias.');

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
                $('.agregar').click(function(){
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
            <div id="contenedorcito">

                <center><?php echo '<font><strong>Solicitudes recibidas</strong></font>'; ?></center>

                <br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>

                <center>
                    <form action="asignar_solicitud_asesor.php" method="POST"><br><br>
                        <center>
                            Exportar Solicitudes <a class="exportacion" href="ExpSolicitudesInstrumentos.php"><img src="../images/excel.png" width="26" height="26"></img></a>                      </a>
                            <br/>
                            <br/>
                            <table id="demotable1" >
                                <thead><tr>
                                        <th>N°</th>
                                        <th>Solicitud</th>
                                        <th>Radicado Solicitud</th>
                                        <th>Tipo Solicitud</th>
                                        <th>Mesa Regional Centro</th>
                                        <th>Líder</th>
                                        <th>Grupo</th>
                                        <th>Entidad</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Hora Solicitud</th>
                                        <th>Detalles</th>
                                        <th>Encargado del Banco Asignado</th>
                                        <th>Estado</th>
                                        <th>Fecha Estado</th>
                                        <th>Hora Estado</th>
                                        <th>Observaciones</th>
                                        <th>Observaciones Admin Banco</th>
                                        <th>Observaciones Asesor Banco</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

                                <?php
                                $query = "SELECT P.ID_REGIONAL,R.NOMBRE_REGIONAL,P.ID_CENTRO,CE.NOMBRE_CENTRO,TOB.ID_PROYECTO,TOB.ID_NORMA,TOB.N_GRUPO,TOB.ID_OPERACION,TOB.FECHA_REGISTRO,TOB.HORA_REGISTRO,P.NIT_EMPRESA,TOB.OBSERVACION,USU.NOMBRE,USU.PRIMER_APELLIDO,USU.SEGUNDO_APELLIDO,TB.DESCRIPCION,TOB.ID_T_OPERACION
                                                    FROM T_OPERACION_BANCO TOB
                                                    INNER JOIN PROYECTO P ON P.ID_PROYECTO=TOB.ID_PROYECTO 
                                                    INNER JOIN CENTRO CE ON CE.CODIGO_CENTRO=P.ID_CENTRO 
                                                    INNER JOIN REGIONAL R ON R.CODIGO_REGIONAL=CE.CODIGO_REGIONAL
                                                    INNER JOIN USUARIO USU ON TOB.USU_REGISTRO = USU.USUARIO_ID
                                                    INNER JOIN T_TIPO_OPERACION_BANCO TB ON TOB.ID_T_OPERACION = TB.ID_OPERACION
                                                    where extract(year from tob.fecha_registro)='2016'
                                                    ORDER BY TOB.ID_OPERACION ASC";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
//                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                $numRow = oci_fetch_all($statement, $row);

                                for ($i = 0; $i < $numRow; $i++)
                                {
                                    $query3 = ("SELECT CODIGO_NORMA FROM NORMA WHERE ID_NORMA=" . $row[ID_NORMA][$i]);
                                    $statement3 = oci_parse($connection, $query3);
                                    $resp3 = oci_execute($statement3);
                                    $cnorma = oci_fetch_array($statement3, OCI_BOTH);

                                    $query222 = "SELECT ES.ID_ESTADO_SOLICITUD,TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD = '" . $row['ID_OPERACION'][$i] . "' ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                                    $statement222 = oci_parse($connection, $query222);
                                    $execute222 = oci_execute($statement222, OCI_DEFAULT);
                                    $numRows222 = oci_fetch_all($statement222, $rows222);
                                    if ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] != 1 && $rows222['ID_TIPO_ESTADO_SOLICITUD'][0] != 4)
                                    {
                                        echo "<tr><td><font face=\"verdana\">" .
                                        $i . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["ID_OPERACION"][$i] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        'R' . $row["ID_REGIONAL"][$i] . '-' . 'C' . $row ["ID_CENTRO"][$i] . '-P' . $row["ID_PROYECTO"][$i] . '-' . $cnorma[0] . '-' . $row["N_GRUPO"][$i] . '-' . $row["ID_OPERACION"][$i] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["DESCRIPCION"][$i] . "</font></td>";
                                        echo "<td><font face=\"verdana\"><a href='datos_centro_mesa_solicitudes.php?rowsSelIdmax=" . $row["ID_OPERACION"][$i] . "' target='_blank'>ver</a></font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        utf8_encode($row["NOMBRE"][$i]) . ' ' . utf8_encode($row["PRIMER_APELLIDO"][$i]) . ' ' . utf8_encode($row["SEGUNDO_APELLIDO"][$i]) . "</font></td>";
                                        echo "<td><a href=\"consultar_grupo_b2.php?proyecto=" . $row["ID_PROYECTO"][$i] . "&n=" . $cnorma . "&norma=" . $row[ID_NORMA][$i] . "&grupo=" . $row["N_GRUPO"][$i] . "\" target='_blank'>
                                                        Consultar</a></td>";
                                        if ($row["NIT_EMPRESA"][$i] == null)
                                        {
                                            echo "<td><font face=\"verdana\">Demanda Social</font></td>";
                                        }
                                        else
                                        {
                                            $queryEmpresa = "SELECT *
                                                FROM EMPRESAS_SISTEMA
                                                WHERE NIT_EMPRESA = " . $row['NIT_EMPRESA'][$i];
                                            $statementEmpresa = oci_parse($connection, $queryEmpresa);
                                            oci_execute($statementEmpresa, OCI_DEFAULT);
                                            $empresa = oci_fetch_all($statementEmpresa, $rowsEmpresa);
                                            echo "<td><font face=\"verdana\">" . utf8_encode($rowsEmpresa['NOMBRE_EMPRESA'][0]) . "</font></td>";
                                        }
                                        echo "<td><font face=\"verdana\">" .
                                        $row["FECHA_REGISTRO"][$i] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["HORA_REGISTRO"][$i] . "</font></td>";


                                        echo "<td><a href=\"consultar_grupo_b2.php?proyecto=" . $row["ID_PROYECTO"][$i] . "&n=" . $cnorma . "&norma=" . $row[ID_NORMA][$i] . "&grupo=" . $row["N_GRUPO"][$i] . "\" target='_blank'>
                                                        Consultar</a></td>";

                                        $query = "SELECT USU.NOMBRE,USU.PRIMER_APELLIDO,USU.SEGUNDO_APELLIDO
                                    FROM USUARIO USU 
                                    INNER JOIN T_SOLICITUDES_ASIGNADAS TSA ON USU.USUARIO_ID = TSA.USUARIO_ASIGNADO 
                                    WHERE TSA.ID_SOLICITUD = " . $row[ID_OPERACION][$i] . " AND TSA.ESTADO = 1";
                                        $statement = oci_parse($connection, $query);
                                        $execute = oci_execute($statement, OCI_DEFAULT);
                                        $numRows = oci_fetch_all($statement, $rows);

                                        if ($numRows == 0)
                                        {
                                            $queryDevol = "SELECT * FROM T_OPERACION_BANCO WHERE ID_PROYECTO = '" . $row[ID_PROYECTO][$i] . "' AND ID_NORMA = '" . $row[ID_NORMA][$i] . "' AND N_GRUPO = '" . $row[N_GRUPO][$i] . "' AND ID_T_OPERACION = '" . $row[ID_T_OPERACION][$i] . "' ORDER BY ID_OPERACION DESC";
                                            $statementDevol = oci_parse($connection, $queryDevol);
                                            oci_execute($statementDevol, OCI_DEFAULT);
                                            $numRowsDevol = oci_fetch_all($statementDevol, $rowsDevol);

                                            $datosDevol = '';
                                            if ($numRowsDevol > 1)
                                            {
                                                $queryDevol = "SELECT * 
                                                    FROM T_SOLICITUDES_ASIGNADAS TSA 
                                                    INNER JOIN USUARIO USU 
                                                        ON TSA.USUARIO_ASIGNADO = USU.USUARIO_ID 
                                                    INNER JOIN T_ESTADO_SOLICITUD TES
                                                        ON TES.ID_SOLICITUD = TSA.ID_SOLICITUD
                                                    WHERE TSA.ID_SOLICITUD = '" . $rowsDevol[ID_OPERACION][1] . "' "
                                                        . "AND TES.ID_TIPO_ESTADO_SOLICITUD = '4' "
                                                        . "ORDER BY TSA.ID_ASIGNACION DESC";
                                                $statementDevol = oci_parse($connection, $queryDevol);
                                                oci_execute($statementDevol, OCI_DEFAULT);
                                                $numRowsDevol = oci_fetch_all($statementDevol, $rowsDevol);

                                                if ($numRowsDevol >= 1)
                                                    $datosDevol = 'Asesor Anterior <br/>' . $rowsDevol[NOMBRE][0] . ' ' . $rowsDevol[PRIMER_APELLIDO][0] . ' ' . $rowsDevol[SEGUNDO_APELLIDO][0];
                                            }
                                            ?>
                                            <td>
                                                <?php echo $datosDevol; ?>
                                                *<input type="checkbox" name="id_solicitud[]" id="id_solicitud" value="<?php echo $row['ID_OPERACION'][$i] ?>" />
                                            </td>
                                            <?php
                                        } else
                                        {
                                            echo '<td>' . utf8_encode($rows[NOMBRE][0] . ' ' . $rows[PRIMER_APELLIDO][0] . ' ' . $rows[SEGUNDO_APELLIDO][0]) . '<br/><br/>
                                                        Reasignar <input type="checkbox" name="id_solicitud[]" id="id_solicitud" value="' . $row['ID_OPERACION'][$i] . '" /></td>';
                                        }

                                        if ($numRows222 >= 1 && $numRows > 0)
                                        {
                                            echo "<td>" . utf8_encode($rows222['DETALLE'][0]) . "</td>";
                                            echo "<td>" . $rows222['FECHA_REGISTRO'][0] . "</td>";
                                            echo "<td>" . $rows222['HORA_REGISTRO'][0] . "</td>";
                                        }
                                        else if ($numRows222 < 1 && $numRows >= 1)
                                        {
                                            echo "<td>Asignada</td>";
                                            echo "<td> </td>";
                                            echo "<td></td>";
                                        }
                                        else
                                        {
                                            echo "<td></td>";
                                            echo "<td> </td>";
                                            echo "<td></td>";
                                        }

                                        echo "<td>" . $row[OBSERVACION][$i] . "</td>";
                                            $qobservacionsolicitudes="  SELECT OBS.*,U.ROL_ID_ROL FROM T_OBSERV_BANCO_SOLIC OBS 
                                                inner join  USUARIO U
                                                ON (OBS.USUARIO_REGISTRO=U.USUARIO_ID) 
                                                WHERE OBS.ID_SOLICITUD='".$row[ID_OPERACION][$i]."'";
                                        $Sobservacionsolicitudes = oci_parse($connection, $qobservacionsolicitudes);
                                        //die($qobservacionsolicitudes);
                                        oci_execute($Sobservacionsolicitudes);

                                        $contador=0;
                                        $CONTROLADORABANDO=false;
                                        $CONTROLADORAASESOR=false;
                                        while($Robservacionsolicitudes=oci_fetch_array($Sobservacionsolicitudes,OCI_ASSOC)){
                                                
                                               
                                            if($Robservacionsolicitudes[ROL_ID_ROL]==13){
                                                $CONTROLADORABANDO=$Robservacionsolicitudes[OBSERVACION];
                                            }
                                            if($Robservacionsolicitudes[ROL_ID_ROL]==2){
                                                $CONTROLADORAASESOR=$Robservacionsolicitudes[OBSERVACION];
                                            }
                                            $contador++;
                                        }
                                        
                                        
                                        ?>
                                            
                                        <td>
                                          
                                            <?php 
                                            if($CONTROLADORABANDO===false){
                                                ?>
                                                    <div>
                                                        <input type="hidden" name='id_solicitud_aj' value="<?php echo $row["ID_OPERACION"][$i];?>"/>
                                                        <textarea name='observacion_solicitud' id="textarea<?php echo $row["ID_OPERACION"][$i];?>"></textarea>
                                                        <input type='button' class='agregar' id_solicitud="<?php echo $row["ID_OPERACION"][$i];?>" value='agregar'/>
                                                    </div>
                                            
                                                <?php
                                            }else{
                                             ?>   
                                            <?=$CONTROLADORABANDO ?>
                                            <?php }?>
                                        </td>
                                        <TD><?=$CONTROLADORAASESOR?></TD>
                                    </tr>
                                    <?php
                                        $numero++;
                                    }
                                }
                                
                                ?>
                            </table>
                        </center><br></br>

                        <input type="submit" value="Siguiente"/>
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