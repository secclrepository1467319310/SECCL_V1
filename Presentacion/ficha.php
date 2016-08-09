<?php 
//session_start();
//if ($_SESSION['logged'] == 'yes') {
//    $nom = $_SESSION["NOMBRE"];
//    $ape = $_SESSION["PRIMER_APELLIDO"];
//    $id = $_SESSION["USUARIO_ID"];
//} else {
//    echo '<script>window.location = "../index.php"</script>';
//}
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
            
            <img src="../images/logos/sena.jpg" align="left" ></img>
            <strong>FORMATO REGISTRO DE INSCRIPCIÓN</strong><br></br>
            <strong> Evaluación y Certificación de Competencias Laborales</strong>

        

        <div id="" >
            <br></br>
            
            <form id="frmRegEsquema" name="frmRegEsquema" 
                  action="guardar_esquema.php" enctype="multipart/form-data" method="post">
                
                <table border="1">
                    <tr><th>Fecha de Registro </th><td><input type="text"></input></td></tr>
                </table>
            </br>
                    <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            

                $codiplan2 = $f . "-" . $row["ID_REGIONAL"] . "-" . $row["ID_CENTRO"] . "-" . $row["ID_PLAN"];

                $query5 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement5 = oci_parse($connection, $query5);
                $resp5 = oci_execute($statement5);
                $idc = oci_fetch_array($statement5, OCI_BOTH);

                $query3 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $reg = oci_fetch_array($statement3, OCI_BOTH);

                $query4 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
                $statement4 = oci_parse($connection, $query4);
                $resp4 = oci_execute($statement4);
                $cen = oci_fetch_array($statement4, OCI_BOTH);

                $query7 = ("SELECT nombre_regional FROM regional where codigo_regional =  '$reg[0]'");
                $statement7 = oci_parse($connection, $query7);
                $resp7 = oci_execute($statement7);
                $nomreg = oci_fetch_array($statement7, OCI_BOTH);

                $query8 = ("SELECT nombre_centro FROM centro where codigo_centro =  '$cen[0]'");
                $statement8 = oci_parse($connection, $query8);
                $resp8 = oci_execute($statement8);
                $nomcen = oci_fetch_array($statement8, OCI_BOTH);

                
                ?>


                <table >

                    <thead><tr><th><strong>Código Regional:</strong></th>
                            <td><?php echo $reg[0]; ?></td>
                            <th><strong>Nombre Regional:</strong></th>
                            <td><?php echo $nomreg[0] ?></td>
                                </thead>
                    <thead><tr><th><strong>Código Centro:</strong></th>
                            <td><?php echo $cen[0]; ?></td>
                            <th><strong>Nombre Centro:</strong></th>
                            <td><?php echo $nomcen[0] ?></td>
                            </thead>

                </table></center>


            <center><table>
                    </br>
                        <tr><th colspan="5">Identificación del Aspirante</th></tr>
                        <tr>
                            <th>Tipo de Documento</th><th>Número de Documento</th><th>Lugar de Expedición</th><th>Número de Libreta Militar</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" value="1" name="tipodoc"  ></input>C.C.
                                <input type="radio" value="2" name="tipodoc"></input>C.E.
                                <input type="radio" value="3" name="tipodoc"></input>T.I.
                                <input type="radio" value="4" name="tipodoc"></input>NUI
                            </td>
                            <td><input type="text" name="documento" onKeyPress="return validar(event);"/></td>
                            <td><input type="text" name="expedicion" /></td>
                            <td><input type="text" name="documento" onKeyPress="return validar(event);"/></td>
                        </tr>
                    </table></center>
                    <br>
                        <center><strong>CC</strong> :&nbsp;Cédula de ciudadanía &nbsp;&nbsp;<strong>CE</strong> :&nbsp;Cédula de Extranjería &nbsp;&nbsp;<strong>TI</strong> :&nbsp;Tarjeta de Identidad &nbsp;&nbsp;<strong>NUI</strong> :&nbsp;Número único de Identificación</center>
                    </br>
                    <table>
                        <tr><th colspan="4">Información Detallada Aspirante</th></tr>
                        <tr><th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre Completo</th><th>Fecha de nacimiento</th></tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text"></input></td>
                        </tr>
                        <tr><th>Departamento de Nacimiento</th><th>Municipio de Nacimiento</th><th>Género</th><th>Grupo Sanguíneo</th></tr>
                        <tr><td></td>
                            <td></td>
                            <td>
                                <input type="radio" value="1" name="tdoc" ></input>Masculino
                                <input type="radio" value="2" name="tdoc"></input>Femenino
                            </td>
                            <td>
                                <input type="radio" value="1" name="tdoc"  ></input>O+
                                <input type="radio" value="2" name="tdoc"></input>O-
                                <input type="radio" value="1" name="tdoc"  ></input>A+
                                <input type="radio" value="2" name="tdoc"></input>A-
                            </td>
                            </td>
                        </tr>
                        <tr><th>Departamento de Domicilio</th><th>Municipio de Domicilio</th><th>Barrio</th><th>Dirección de Domicilio</th></tr>
                        <tr><td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" name="expedicion" /></td>
                            
                        </tr>
                        <tr><th>Teléfono</th><th>Celular</th><th>Estado Civil</th><th>Estrato</th></tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="radio" value="1" name="tdoc"></input>Soltero(a)
                                <input type="radio" value="1" name="tdoc"></input>Unión Libre
                                <input type="radio" value="2" name="tdoc"></input>Casado(a)
                                <input type="radio" value="2" name="tdoc"></input>Viudo(a)
                            </td>
                            <td>
                                <input type="radio" value="1" name="tdoc"  ></input>Uno (1)
                                <input type="radio" value="2" name="tdoc"></input>Dos (2)
                                <input type="radio" value="1" name="tdoc"  ></input>Tres (3)
                                <input type="radio" value="2" name="tdoc"></input>Cuatro (4)
                            </td>
                        </tr>
                        <tr>
                            <th>Nivel Escolaridad</th>
                            <td>
                                <input type="radio" value="1" name="tdoc"  ></input>Ninguno
                                <input type="radio" value="2" name="tdoc"></input>Bachiller
                                <input type="radio" value="1" name="tdoc"  ></input>Técnico
                                <input type="radio" value="2" name="tdoc"></input>Tecnólogo
                                <input type="radio" value="2" name="tdoc"></input>Profesional
                            </td>
                            <th>Correo Electrónico</th>
                            <td><input type="text" size="50" ></input></td>
                        </tr>
                    </table>
                    </br>
                        <center><table>
                                <tr><th colspan="4">Datos de Contacto</th></tr>
                        <tr><th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre Completo</th><th>Dirección Residecia</th></tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text"></input></td>
                        </tr>
                        <tr><th>Teléfono</th><th>Celular</th><th>Correo Electrónico</th><th>Parentesco</th></tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text"></input></td>
                        </tr>
                    </table></center>
                    </br>
                    <center><table>
                        <tr><th colspan="3">Datos Laborales</th></tr>
                        <tr><th>Condición Laboral</th><th>Empresa</th><th>Nit Empresa</th></tr>
                        <tr>
                            <td>
                                <input type="radio" value="1" name="tdoc"  ></input>Empleado
                                <input type="radio" value="1" name="tdoc"  ></input>Desempleado
                                <input type="radio" value="1" name="tdoc"  ></input>Independiente
                            </td>
                            <td>
                                <input name="nombre_empresa" type="text" size="50" readonly value=""></input>
                            </td>
                            <td>
                                <input name="nit_empresa" id="nit_empresa" maxlength="9" onKeyPress="return validar(event)" type="text" value=""></input>
                            </td>
                        </tr>
                      </table></center>
                    </br>
                    <center><table>
                            <tr><th colspan="5">Trabajadores SENA</th></tr>
                        <tr>
                            <td><input type="radio" value="1" name="tipodoc"></input>Instructor de Planta</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>Instructor de Contrato</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>Coordinador Académico</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>Asesor de Planta</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>Asesor de Contrato</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>Profesionales de Planta</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>Profesionales de Contrato</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>Técnicos y Asistenciales de Planta</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>Técnico y Asistenciales de Contrato</td>
                            <td><input type="radio" value="1" name="tipodoc"></input>Trabajadores Oficiales</td>
                        </tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>Directivos</td></tr>
                    </table></center>
                    <br></br>
                    <table>
                        <tr><th colspan="5">Tipo de Población</th></tr>
                        <tr><td><input type="radio" value="1" name="tipodoc"></input>ABANDONO O DESPOJO FORZADO DE TIERRAS</td><td><input type="radio" value="2" name="tipodoc"></input>HERIDO</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>ADOLESCENTE DESVINCULADO DE GRUPOS ARMADOS ORGANIZADOS</td><td><input type="radio" value="2" name="tipodoc"></input>INDIGENAS</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>ADOLESCENTE TRABAJADOR</td><td><input type="radio" value="2" name="tipodoc"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA</td><td><input type="radio" value="2" name="tipodoc"></input>JOVENES VULNERABLES</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>AMENAZA</td><td><input type="radio" value="1" name="tipodoc"></input>MINAS ANTIPERSONAL,MUNICION SIN EXPLOTAR,Y ARTEFACTO EXPLOSIVO IMPROVISADO </td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DELITOS CONTRA LA LIBERTAD Y  LA INTEGRIDAD SEXUAL EN DESARROLLO DEL CONFLICTO ARMADO</td><td><input type="radio" value="2" name="tipodoc"></input>NEGRITUDES</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS DISCAPACITADOS</td><td><input type="radio" value="2" name="tipodoc"></input>PERSONAS EN PROCESO DE REINTEGRACION</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR FENOMENOS NATURALEZ CABEZA DE FAMILIA</td><td><input type="radio" value="2" name="tipodoc"></input>RECLUTAMIENTO FORZADO</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR LA VIOLENCIA CABEA DE FAMILIA</td><td><input type="radio" value="2" name="tipodoc"></input>REMITIDOS POR EL PAL</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO LIMITACION AUDITIVA O SORDA</td><td><input type="radio" value="2" name="tipodoc"></input>SECUESTRO</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO LIMITACION VISUAL O CIEGA</td><td><input type="radio" value="2" name="tipodoc"></input>SOLDADOS CAMPESINOS</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADOS</td><td><input type="radio" value="2" name="tipodoc"></input>TORTURA</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>ACTOS TERRORISTA/ATENTADOS/COMBATES/ENFRENTAMIENTOS/HOSTIGAMIENTOS</td><td><input type="radio" value="2" name="tipodoc"></input>HOMICIDIO/MASACRE</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>ADOLESCENTE EN CONFLICTO CON LA LEY PENAL</td><td><input type="radio" value="2" name="tipodoc"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>AFROCOLOMBIANOS</td><td><input type="radio" value="2" name="tipodoc"></input>INPEC</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td><td><input type="radio" value="2" name="tipodoc"></input>MICROEMPRESAS</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>ARTESANOS</td><td><input type="radio" value="2" name="tipodoc"></input>MUJER CABEZA DE FAMILIA</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DESAPARICION FORZADA</td><td><input type="radio" value="2" name="tipodoc"></input>PALENQUEROS</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR FENOMENOS NATURALES</td><td><input type="radio" value="2" name="tipodoc"></input>RAIZALES</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR LA VIOLENCIA</td><td><input type="radio" value="2" name="tipodoc"></input>REMITIDOS POR EL CIE</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO COGNITIVO</td><td><input type="radio" value="2" name="tipodoc"></input>ROM</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO LIMITACION FISICA O MOTORA</td><td><input type="radio" value="2" name="tipodoc"></input>SOBREVIVIENTES MINAS ANTIPERSONALES</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO MENTAL</td><td><input type="radio" value="2" name="tipodoc"></input>TERCERA EDAD</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>EMPRENDEDORES</td><td><input type="radio" value="2" name="tipodoc"></input>VINCULADO DE NIÑOS,NIÑAS Y ADOLESCENTES A ACTIVIDADES RELACIONADA CON GRUPOS ARMADOS</td></tr>
                        <tr><td><input type="radio" value="2" name="tipodoc"></input>NINGUNA</td></tr>
                    </table>
            </br>
                    <table>
                        <tr><th colspan="5">Normas de Competencia Laboral en las que desea certificarse</th></tr>
                        <tr><th>Código NCL</th><th>Versión NCL</th><th>Título NCL</th><th>Rango</th><th>Código Titulación a la que pertenece la NCL</th></tr>
                        <tr>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                            <td><input type="text" name="n1"></input></td>
                        </tr>
                    </table>
                    <br></br>
          <center>Firma del Candidato _____________________________________________</center>
                    </br>
                </form>
            </br>
        </div>
            </div>

        <div id="footer_info" class="center">
            <p>.:: Servicio Nacional de Aprendizaje SENA – Dirección General Calle 57 No. 8-69, Bogotá D.C - PBX (57 1) 5461500<br />
                Línea gratuita de atención al ciudadano Bogotá 5925555 – Resto del país 018000 910270<br />
                Horario de atención: lunes a viernes de 8:00 am a 5:30 pm<br />
                Todos los derechos reservados © 2012 ::.
                <br />
                <br />
            </p>

        </div>

        <div style="clear:both; "></div>

        <div id="footer_links" class="center">
            <a href="http://www.sena.edu.co" title="Portal SENA" target="_blank"><img src="../images/logos/sena.jpg" width="77" height="58" alt="logo SENA" border="0" /></a> &nbsp; 
            <a href="http://wsp.presidencia.gov.co" title="Presidencia de la Rep&uacute;blica" target="_blank"><img src="../images/logos/presidencia.jpg" width="167" height="58" alt="logo Presidencia de la Rep&uacute;blica" border="0" /></a> &nbsp; 
            <a href="http://www.gobiernoenlinea.gov.co" title="Gobierno en l&iacute;nea" target="_blank"><img src="../images/logos/gel.jpg" width="121" height="58" alt="logo Gobierno en l&iacute;nea" border="0"/></a> &nbsp; 
            <a href="http://www.mintrabajo.gov.co" title="Ministerio del Trabajo" target="_blank"><img src="../images/logos/mintrabajo.jpg" width="114" height="58" alt="logo Ministerio del Trabajo" border="0"/></a> &nbsp;  
            <a href="http://www.sigob.gov.co" title="SIGOB" target="_blank"><img src="../images/logos/sigob.jpg" width="102" height="58" alt="logo SIGOB" border="0"/></a>
        </div>
        <div id="footer_ads" class="center">
                <!-- <img src="http://periodico.sena.edu.co/_img/footer_ads.png" width="1050" height="30" /> -->
        </div>
    </body>
</html>
