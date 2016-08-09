<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

    <!--        CREDITOS  CREDITS
    Plantilla modificada por: Jhonatan Andres Garnica Paredes
    Requerimiento: Adaptación imagen corporativa.
    Direccion de Sistema - SENA, Dirección General
    última actualización Octubre /2012
    !-->

    <head>
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        
        
        <script type="text/javascript">
            $(document).ready(function() {


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


    </head>
    <body>
        <div id="">

            <!-- CONTINUA -->

            <div id="contenedorcito" >
                <br>
                    <center><strong>Información General del Proyecto</strong></center>
                </br>

                <center>
                    <br>
                        <center><strong>Información Específica de la Empresa</strong></center>
                    </br>
                    <?php $proyecto = $_GET['proyecto']; ?>
                    <form id="registro" >
                        <?php
                        include("../Clase/conectar.php");
                        $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                        
                        $query3 = ("SELECT nit_empresa from proyecto where id_proyecto =  '$proyecto'");
                        $statement3 = oci_parse($connection, $query3);
                        $resp3 = oci_execute($statement3);
                        $nit = oci_fetch_array($statement3, OCI_BOTH);
                        $query = "SELECT * FROM EMPRESAS_SISTEMA WHERE NIT_EMPRESA='$nit[0]'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <table>
                                <tr>
                                    <th>Tipo ID</th>
                                    <th>Identificación</th>
                                    <th>Razón Social</th>
                                    <th>Tamaño Empresa</th>
                                    <th>Número de Empleados</th>
                                </tr>
                                <tr>
                                    <?php
                                    if ($row["tipo_identificacion"] < 2) {
                                        $e = "Nit";
                                    } else {
                                        $e = "Rut";
                                    }
                                    $query2 = ("SELECT TAMANO FROM TAM_EMPRESA WHERE ID_TAM='$row[TAM_EMPRESA]'");
                                    $statement2 = oci_parse($connection, $query2);
                                    $resp2 = oci_execute($statement2);
                                    $tam = oci_fetch_array($statement2, OCI_BOTH);
                                    $query4 = ("SELECT CLASIFICACION FROM CLASIF_EMPRESA WHERE ID_CLASIF='$row[CLASIFICACION]'");
                                    $statement4 = oci_parse($connection, $query4);
                                    $resp4 = oci_execute($statement4);
                                    $clasif = oci_fetch_array($statement4, OCI_BOTH);
                                    $query5 = ("SELECT SECTOR FROM SECTOR_ECONOMICO WHERE ID_SECTOR='$row[SECTOR_ECONOMICO]'");
                                    $statement5 = oci_parse($connection, $query5);
                                    $resp5 = oci_execute($statement5);
                                    $sector = oci_fetch_array($statement5, OCI_BOTH);
                                    $query6 = ("SELECT TIPO_EMPRESA FROM TIPO_EMPRESA WHERE ID_TIPO_EMPRESA='$row[TIPO_EMPRESA]'");
                                    $statement6 = oci_parse($connection, $query6);
                                    $resp6 = oci_execute($statement6);
                                    $t_em = oci_fetch_array($statement6, OCI_BOTH);
                                    ?>
                                    <td><?php echo $e; ?></td>
                                    <td><?php echo $row["NIT_EMPRESA"]; ?></td>
                                    <td><?php echo $row["NOMBRE_EMPRESA"]; ?></td>
                                    <td><?php echo utf8_encode($tam[0]); ?></td>
                                    <td><?php echo $row["NUM_EMPLEADOS"]; ?></td>
                                </tr>
                                <tr>
                                    <th>Sigla</th>
                                    <th>Dirección</th>
                                    <th>Departamento</th>
                                    <th>Municipio</th>
                                    <th>Teléfono</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row["SIGLA_EMPRESA"]; ?></td>
                                    <td><?php echo $row["DIRECCION"]; ?></td>
                                    <td><?php echo $row["ID_DEPARTAMENTO"]; ?></td>
                                    <td><?php echo $row["ID_MUNICIPIO"]; ?></td>
                                    <td><?php echo $row["TELEFONO"]; ?></td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <th>Gerente</th>
                                    <th>Clasificación Empresa</th>
                                    <th>Sector Económico</th>
                                    <th>Tipo Empresa</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row["FAX"]; ?></td>
                                    <td><?php echo $row["GERENTE"]; ?></td>
                                    <td><?php echo $clasif[0]; ?></td>
                                    <td><?php echo $sector[0]; ?></td>
                                    <td><?php echo $t_em[0]; ?></td>
                                </tr>

                            </table>
                            <?php
                            $numero++;
                        }
                        
                        ?>

                        <br>
                            <center><strong>Información del Coordinador del Proyecto en la Empresa a Nivel Nacional</strong></center>
                        </br>
                        <?PHP
                        $query2 = "SELECT * FROM COORDINADOR_PROYECTOS WHERE NIT_EMPRESA='$nit[0]'";
                        $statement2 = oci_parse($connection, $query2);
                        oci_execute($statement2);
                        $num = 0;
                        while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                        ?>
                            <table>
                                <tr>
                                    <th>Tipo ID</th>
                                    <th>Identificación</th>
                                    <th>Nombres</th>
                                    <th>Primer Apellido</th>
                                    <th>Segundo Apellido</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row2["TIPO_DOC"]; ?></td>
                                    <td><?php echo $row2["DOCUMENTO"]; ?></td>
                                    <td><?php echo $row2["NOMBRES"]; ?></td>
                                    <td><?php echo $row2["PRIMER_APELLIDO"]; ?></td>
                                    <td><?php echo $row2["SEGUNDO_APELLIDO"]; ?></td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <th>Cargo</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                    <th>Email</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row2["DIRECCION"]; ?></td>
                                    <td><?php echo $row2["CARGO"]; ?></td>
                                    <td><?php echo $row2["TELEFONO"]; ?></td>
                                    <td><?php echo $row2["CELULAR"]; ?></td>
                                    <td><?php echo $row2["EMAIL"]; ?></td>
                                </tr>
                                
                            </table>
                        <?php
                            $num++;
                        }
                        
                        ?>

                        <br>
                            <br>
                            <center><strong>Información de la población que atiende el proyecto</strong></center>
                        </br>
                            <table>
                                <?PHP
                                    $query23 = ("SELECT LINEA FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                                    $statement23 = oci_parse($connection, $query23);
                                    $resp23 = oci_execute($statement23);
                                    $linea = oci_fetch_array($statement23, OCI_BOTH);
                                    $query24 = ("SELECT TP1 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                                    $statement24 = oci_parse($connection, $query24);
                                    $resp24 = oci_execute($statement24);
                                    $tp1 = oci_fetch_array($statement24, OCI_BOTH);
                                    $query25 = ("SELECT TP2 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                                    $statement25 = oci_parse($connection, $query25);
                                    $resp25 = oci_execute($statement25);
                                    $tp2 = oci_fetch_array($statement25, OCI_BOTH);
                                    $query26 = ("SELECT TP3 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                                    $statement26 = oci_parse($connection, $query26);
                                    $resp26 = oci_execute($statement26);
                                    $tp3 = oci_fetch_array($statement26, OCI_BOTH);
                                    $query27 = ("SELECT TP4 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                                    $statement27 = oci_parse($connection, $query27);
                                    $resp27 = oci_execute($statement27);
                                    $tp4 = oci_fetch_array($statement27, OCI_BOTH);
                                    
                                    $query333 = ("SELECT DISTINCT ID_EVALUADOR FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO =  '$proyecto'");
                                    $statement333 = oci_parse($connection, $query333);
                                    $resp333 = oci_execute($statement333);
                                    $idev = oci_fetch_array($statement333, OCI_BOTH);
                                    ?>
                                <tr>
                                    <th>Línea de Atención</th>
                                    <th>Tipo de Población</th>
                                </tr>
                                <tr>
                                    <?php
                                         if ($nit==null) {?>
                                    <td rowspan="5" width="20%" ><input type="checkbox" disabled name="la">Alianza</input></td>
                                  
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td></tr>       
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td></tr>
                                     
                                    
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="checkbox" checked disabled name="la">Demanda Social</input></td>
                                    <?php
                                         if ($tp1[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td></tr>       
                                      <?php   }
                                     ?> 
                                      <?php
                                         if ($tp2[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                      <?php   }
                                     ?> 
                                    <?php
                                         if ($tp3[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                      <?php   }
                                     ?>
                                    <?php
                                         if ($tp4[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td></tr>
                                      <?php   
                                      
                                         }
                                     ?>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input disabled type="checkbox" disabled name="la">Atención Diferencial</input></td>
                                    <tr><td><input type="checkbox" disabled value="1" disabled name="al1"></input><strong>• Víctimas:</strong>se refiere aquellas personas que individual
                                            o colectivamente hayan sufrido un daño por hechos ocurridos a partir del 1º de enero de 1985,
                                            como consecuencia de infracciones al Derecho Internacional Humanitario o de violaciones
                                            graves y manifiestas a las normas internacionales de Derechos Humanos, ocurridas con
                                            ocasión del conflicto armado interno y que están contempladas dentro de la clasificación 
                                            de la <a href="http://www.unidadvictimas.gov.co/" target="blank" >Ley 1448 de 2011.</a></td></tr>
                                </tr>
                                <?php
                                         }else{
                                ?>
                                <td rowspan="5" width="20%" ><input type="checkbox" disabled name="la">Alianza</input></td>
                                  
                                     <?php
                                         if ($tp1[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td></tr>       
                                      <?php   }
                                     ?> 
                                      <?php
                                         if ($tp2[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                      <?php   }
                                     ?> 
                                    <?php
                                         if ($tp3[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                      <?php   }
                                     ?>
                                    <?php
                                         if ($tp4[0]==1) {?>
                                     <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td></tr>
                                   <?php        
                                         }else{ ?>
                                     <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td></tr>
                                      <?php   
                                      
                                         }
                                     ?>
                                    
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="checkbox" disabled name="la">Demanda Social</input></td>
                                    <tr><td><input type="checkbox" disabled name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td></tr>
                                    <tr><td><input type="checkbox"disabled name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresa, pequeña empresa o personas que trabajan por cuenta propia.</td></tr>
                                    <tr><td><input type="checkbox" disabled name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual.</td></tr>
                                    <tr><td><input type="checkbox" disabled name="al"></input><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td></tr>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input disabled type="checkbox" disabled name="la">Atención Diferencial</input></td>
                                    <tr><td><input type="checkbox" disabled value="1" disabled name="al1"></input><strong>• Víctimas:</strong>se refiere aquellas personas que individual
                                            o colectivamente hayan sufrido un daño por hechos ocurridos a partir del 1º de enero de 1985,
                                            como consecuencia de infracciones al Derecho Internacional Humanitario o de violaciones
                                            graves y manifiestas a las normas internacionales de Derechos Humanos, ocurridas con
                                            ocasión del conflicto armado interno y que están contempladas dentro de la clasificación 
                                            de la <a href="http://www.unidadvictimas.gov.co/" target="blank" >Ley 1448 de 2011.</a></td></tr>
                                </tr>
                                <?php
                                         }
                                         ?>
                            </table>
                        </br>
                        <br></br>
                        <center><strong>Requerimientos del Proyecto</strong></center>
                        <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                            <tr rowspan="3" >
                                <th rowspan="2">DESCRIPCIÓN</th>
                                <th colspan="3">SENA</th>
                                <th colspan="3">EMPRESA</th>
                            </tr>
                            <tr>
                                <th>CANTIDAD</th>
                                <th>V.UNITARIO</th>
                                <th>TOTAL</th>
                                <th>CANTIDAD</th>
                                <th>V.UNITARIO</th>
                                <th>TOTAL</th>
                            </tr>
                            

                        </tr>
                        <?php
                        $query = "SELECT * FROM REQUERIMIENTOS_PROYECTO WHERE ID_PROYECTO='$proyecto'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr>
                                <?php
                                $query3 = ("SELECT descripcion from requerimiento where id_requerimiento =  '$row[ID_ACTIVIDAD]'");
                                $statement3 = oci_parse($connection, $query3);
                                $resp3 = oci_execute($statement3);
                                $des = oci_fetch_array($statement3, OCI_BOTH);
                                ?>
                                <td><?php echo utf8_encode($des[0]); ?></td>
                                <td align="center"><?php echo $row["CANTIDAD_SENA"]; ?></td>
                                <td align="right"><?php echo '$'.$row["VAL_UNIT_SENA"]; ?></td>
                                <td align="right"><?php echo '$'.($row["CANTIDAD_SENA"] * $row["VAL_UNIT_SENA"]) ?></td>
                                <td align="center"><?php echo $row["CANTIDAD_EMPRESA"]; ?></td>
                                <td align="right"><?php echo '$'.$row["VAL_UNIT_EMPRESA"]; ?></td>
                                <td align="right"><?php echo '$'.($row["CANTIDAD_EMPRESA"] * $row["VAL_UNIT_EMPRESA"]) ?></td>
                                <?php 
                                $t1+=($row["CANTIDAD_SENA"]* $row["VAL_UNIT_SENA"]);
                                $t2+=($row["CANTIDAD_EMPRESA"]* $row["VAL_UNIT_EMPRESA"]);
                                ?>
                                
                            </tr>
                        


                            <?php
                            $numero++;
                        }
                        ?>
                        <tr>
                            <td><stong>TOTAL</stong></td>
                            <td colspan="3" align="right"><?php echo '$'. $t1 ?></td>
                            <td colspan="3" align="right"><?php echo '$'. $t2 ?></td>
                        </tr>


                    </table><br></br>
                    <center><strong>Cronograma de Actividades</strong></center><br>
                    <table align = "center" border = "1" cellspacing = 1 cellpadding = 2 style = "font-size: 10pt"><tr>


                            <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                            <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                            <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                            <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                            <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                        </tr>
                        <?php
                        $query = "SELECT * FROM CRONOGRAMA_PROYECTO WHERE ID_PROYECTO='$proyecto'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr>
                                <?php
                                $query3 = ("SELECT descripcion from actividades where id_actividad =  '$row[ID_ACTIVIDAD]'");
                                $statement3 = oci_parse($connection, $query3);
                                $resp3 = oci_execute($statement3);
                                $des = oci_fetch_array($statement3, OCI_BOTH);
                                ?>
                                <td><?php echo utf8_encode($des[0]); ?></td>
                                <td><?php echo $row["FECHA_INICIO"]; ?></td>
                                <td><?php echo $row["FECHA_FIN"]; ?></td>
                                <td><?php echo $row["RESPONSABLE"]; ?></td>
                                <td><?php echo $row["OBSERVACION"]; ?></td>

                            </tr>


                            <?php
                            $numero++;
                        }
                        ?>


                    </table><br></br>
                <center><strong>Información de Evaluadores</strong></center><br>
                <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Email </th>
                                <th>Email Personal</th>
                                <th>Celular</th>
                                <th>Teléfono</th>
                                <th>Certificado como Evaluador</th>
                                <th>Número de Certificado</th>
                                <!--<th>Descargar Hoja de vida</th>-->
                        </tr>
                        <?php
                        $query = "SELECT * FROM EVALUADOR WHERE DOCUMENTO='$idev[0]'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr><?php
                                    if ($row["T_DOCUMENTO"]==1) {
                                            $e="TI";
                                        }else if ($row["T_DOCUMENTO"]==2){
                                            $e="CC";
                                        }else{
                                            $e="CE";
                                        }
                                        
                                         if ($row["CERTIFICADO"]==1) {
                                            $c="Si";
                                        }else{
                                            $c="No";
                                        }
                                        ?>
                                
                                <td><?php echo $row["DOCUMENTO"]; ?></td>
                                <td><?php echo $row["NOMBRE"]; ?></td>
                                <td><?php echo $row["EMAIL"]; ?></td>
                                <td><?php echo $row["EMAIL2"]; ?></td>
                                <td><?php echo $row["CELULAR"]; ?></td>
                                <td><?php echo $row["IP"]; ?></td>
                                <td><?php echo $c; ?></td>
                                <td><?php echo $row["N_CERTI"]; ?></td>
<!--                                <td><a href="descargar.php?id=<?php echo $row["ID_EVALUADOR"] ?>">Descargar</a></td>-->

                            </tr>


                            <?php
                            $numero++;
                        }
                        
                        ?>


                    </table><br></br>
                    <center><strong>Aspirantes del Proyecto</strong></center><br>
                    <table>
                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Normas Asociadas</th>
                            </tr>

<?php
$query = "SELECT DISTINCT usuario.tipo_doc, usuario.documento,
usuario.nombre, usuario.primer_apellido,usuario.segundo_apellido,usuario.usuario_id,
usuario.depto_residencia,usuario.municipio_residencia
FROM usuario
INNER JOIN candidatos_proyecto 
ON candidatos_proyecto.id_candidato = usuario.usuario_id
WHERE candidatos_proyecto.id_proyecto = '$proyecto'";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$numero = 0;
while ($row = oci_fetch_array($statement, OCI_BOTH)) {


    if ($row["TIPO_DOC"] == 1) {
        $e = "TI";
    } else if ($row["TIPO_DOC"] == 2) {
        $e = "CC";
    } else {
        $e = "CE";
    }

    $query5 = ("SELECT nombre_departamento FROM departamento where id_departamento =  '$row[DEPTO_RESIDENCIA]'");
                $statement5 = oci_parse($connection, $query5);
                $resp5 = oci_execute($statement5);
                $dep = oci_fetch_array($statement5, OCI_BOTH);
    $query6 = ("SELECT nombre_municipio FROM municipio where id_municipio = '$row[MUNICIPIO_RESIDENCIA]' and id_departamento='$row[DEPTO_RESIDENCIA]'");
                $statement6 = oci_parse($connection, $query6);
                $resp6 = oci_execute($statement6);
                $munc = oci_fetch_array($statement6, OCI_BOTH);
    
    
    
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["DOCUMENTO"] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["NOMBRE"] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["PRIMER_APELLIDO"] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["SEGUNDO_APELLIDO"] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $dep[0] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $munc[0] . "</font></td>";
    echo "<td width=\"15%\"><a href=\"./candidato_ncl_n.php?proyecto=" . $proyecto . "&documento=" . $row["USUARIO_ID"] . "\" >
                                Ver</a></td></tr>";

    $numero++;
}
?>
                        </table><br></br>
                        <center><strong>Centros que apoyan el Proyecto</strong></center><br>
                        <table id="demotable1">
                                <thead><tr>
                                        <th><strong>Regional</strong></th>
                                        <th><strong>Codigo Centro</strong></th>
                                        <th><strong>Centro</strong></th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

                                <?php
                                
                                $q = "SELECT DISTINCT ID_CENTRO from CENTRO_PROYECTO where id_proyecto='$proyecto'";
                                $statement3 = oci_parse($connection, $q);
                                oci_execute($statement3);
                                $numero3 = 0;
                                while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {
                                $query = "SELECT 
   r.nombre_regional REGIONAL, 
   ce.codigo_centro CODIGO_CENTRO  ,
   ce.nombre_centro CENTRO 
FROM centro ce
INNER JOIN regional r ON ce.codigo_regional =  r.codigo_regional
where ce.id_centro =  '$row3[ID_CENTRO]'";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                $row["REGIONAL"] . "</font></td>";
                                echo "<td width=\"5%\"><font face=\"verdana\">" .
                                $row["CODIGO_CENTRO"] . "</font></td>";
                                echo "<td width=\"25%\"><font face=\"verdana\">" .
                                utf8_encode($row["CENTRO"]) . "</font></td></tr>";
                                
                                $numero++;
                                }
                                $numero3++;
                                }
                                
                                ?>
                        </table><br></br>
                    <center><strong>COMPROMISOS PARA LA APROBACIÓN DEL PROYECTO DE CERTIFICACIÓN DE COMPETENCIAS LABORALES</strong></center>
                    <br></br>
                    <table>
                                <tr>
                                    <th colspan="2">COMPROMISOS EMPRESA</th>
                                    <td>
                                        La empresa, gremio, asociación u organización se compromete a: <br></br>

• Designar una persona que coordine la planeación y ejecución del Proyecto.<br>
• Postular personal experto en las funciones productivas a evaluar, como candidato a ser  Evaluador. <br>
• Garantizar ambientes de evaluación como sitios reales de trabajo de los candidatos. <br>
• Proveer los materiales y equipos necesarios para llevar a cabo la evaluación. <br>
• Facilitar expertos técnicos para la construcción de ítems e indicadores de evaluación, que garanticen las herramientas
&nbsp;&nbsp;&nbsp;necesarias para la ejecución del procedimiento. <br>
• Notificar las novedades durante el desarrollo de la evaluación y después de otorgada la certificación.<br>
• Asistir y participar en la auditoría  en el  lugar, fecha  y hora acordados.<br>
• Diligenciar las encuestas de servicio e impacto de PECCL en caso de ser seleccionados. <br>
    • Asumir los costos y recursos representados en:<br></br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Tiempos asignados y desplazamientos de evaluadores y coordinador del proceso.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Tiempos requeridos para la evaluación de los candidatos.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Reproducciones de los registros o instrumentos utilizados.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Portafolios cuando esto aplique.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Ambientes de trabajo como sitios de recolección de evidencias.<br>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">COMPROMISOS SENA</th>
                                    <td>
                                        El SENA se compromete a: <br></br>

• Formar evaluadores en caso de ser necesario.<br>
• Acompañar permanentemente el proceso por parte del Líder de ECCL o su delegado. <br>
• Coordinar la elaboración de ítems o indicadores de evaluación cuando no existan en el Banco Nacional de Instrumentos.<br>
• Suministrar instrumentos de evaluación existentes en el Banco Nacional de Instrumentos (BNI)
para la Valoración de &nbsp;&nbsp;&nbsp;Evidencias. <br>
• Designar auditor para cada proceso. <br>
• Generar el Certificado de Competencia Laboral cuando los candidatos con emisión de  juicio  <br>
&nbsp;&nbsp;&nbsp;“Competente” no presenten ningún hallazgo abierto en el  informe de auditoría y en el término <br>
&nbsp;&nbsp;&nbsp;establecido en esta Guía.  
                                    </td>
                                </tr>
                        <?php
                $query5 = ("SELECT ID_ESTADO_PROYECTO FROM PROYECTO WHERE ID_PROYECTO =  '$proyecto'");
                $statement5 = oci_parse($connection, $query5);
                $resp5 = oci_execute($statement5);
                $id = oci_fetch_array($statement5, OCI_BOTH);
                ?>
                
                        <?php
                                if ($id[0]==1){
                                    $query3 = ("SELECT compromisos from proyecto where id_proyecto =  '$proyecto'");
                        $statement3 = oci_parse($connection, $query3);
                        $resp3 = oci_execute($statement3);
                        $comp = oci_fetch_array($statement3, OCI_BOTH);
                        ?><tr><th colspan="2">OTROS COMPROMISOS</th><td><textarea name="compromisos" disabled rows="5" cols="80"><?php echo $comp[0] ?></textarea></td></tr>
                        <?php
                                }else{
                                    ?><tr><th colspan="2">OTROS COMPROMISOS</th><td><textarea name="compromisos" readonly rows="5" cols="80"  ><?php echo $comp[0] ?></textarea></td></tr>
                                <?php } ?>
                       </table>
                   
                </form>
                   
                </center>
            </div>
        </div>    
    </body>
</html>
