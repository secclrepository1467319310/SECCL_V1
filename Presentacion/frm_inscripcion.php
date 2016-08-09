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
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />}
        <script src="https://code.jquery.com/jquery-2.2.1.min.js" type="text/javascript"></script>   

    </head>
    <body onload="inicio()">
 	<?php include ('layout/cabecera.php') ?>
        <div id="contenedorcito">
            
            <?php
                require_once("../Clase/conectar.php");
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                
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
            
            <br>
                <form id="frmRegEsquema" name="frmRegEsquema" 
                  action="guardar_esquema.php" enctype="multipart/form-data" method="post">
               <br></br>
                    <img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>FORMATO INSCRIPCIÓN A PROCESO DE CERTIFICACIÓN</strong><br></br>
                    <strong> Evaluación y Certificación de Competencias Laborales</strong>
                    <br></br>
                <table>

                    <thead><tr><th><strong>Código Regional:</strong></th>
                            <td><?php echo $reg[0]; ?></td>
                            <th><strong>Nombre Regional:</strong></th>
                            <td><?php echo utf8_encode($nomreg[0]) ?></td>
                                </thead>
                    <thead><tr><th><strong>Código Centro:</strong></th>
                            <td><?php echo $cen[0]; ?></td>
                            <th><strong>Nombre Centro:</strong></th>
                            <td><?php echo utf8_encode($nomcen[0]) ?></td>
                            </thead>
                </table>
                </center>
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
                            <td><input type="text" name="expedicion" size="50" /></td>
                            <td><input type="text" name="documento" size="20" onKeyPress="return validar(event);"/></td>
                        </tr>
                    </table></center>
                <br></br>
                    <br>
                        <center><strong>CC</strong> :&nbsp;Cédula de ciudadanía &nbsp;&nbsp;<strong>CE</strong> :&nbsp;Cédula de Extranjería &nbsp;&nbsp;<strong>TI</strong> :&nbsp;Tarjeta de Identidad &nbsp;&nbsp;<strong>NUI</strong> :&nbsp;Número único de Identificación</center>
                    </br>
                    <table>
                        <tr><th colspan="4">Información Detallada Aspirante</th></tr>
                        <tr><th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre Completo</th><th>Fecha de nacimiento</th></tr>
                        <tr>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" ></input></td>
                        </tr>
                        <tr><th>Departamento de Nacimiento</th><th>Municipio de Nacimiento</th><th>Género</th><th>Grupo Sanguíneo</th></tr>
                        <tr>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" size=""></input></td>
                            <td>
                                <input type="radio" value="1" name="tdoc5" ></input>Masculino
                                <input type="radio" value="2" name="tdoc5"></input>Femenino
                            </td>
                            <td>
                                <input type="radio" value="1" name="tdoc4"  ></input>O+
                                <input type="radio" value="2" name="tdoc4" input>O-
                                <input type="radio" value="3" name="tdoc4"  ></input>A+
                                <input type="radio" value="4" name="tdoc4"></input>A-<br>
                                <input type="radio" value="5" name="tdoc4"  ></input>B+
                                <input type="radio" value="6" name="tdoc4" input>B-
                                <input type="radio" value="7" name="tdoc4"  ></input>AB+
                                <input type="radio" value="8" name="tdoc4"></input>AB-
                            </td>
                            </td>
                        </tr>
                        <tr><th>Departamento de Domicilio</th><th>Municipio de Domicilio</th><th>Barrio</th><th>Dirección de Domicilio</th></tr>
                        <tr>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" size="50"></input></td>
                            
                        </tr>
                        <tr><th>Teléfono</th><th>Celular</th><th>Estado Civil</th><th>Estrato</th></tr>
                        <tr>
                            <td><input type="text" size=""></input></td>
                            <td><input type="text" size=""></input></td>
                            <td>
                                <input type="radio" value="1" name="tdoc3"></input>Soltero(a)
                                <input type="radio" value="2" name="tdoc3"></input>Unión Libre<br>
                                <input type="radio" value="3" name="tdoc3"></input>Casado(a)
                                <input type="radio" value="4" name="tdoc3"></input>Viudo(a)
                                <input type="radio" value="4" name="tdoc3"></input>Otro(a)
                            </td>
                            <td>
                                <input type="radio" value="1" name="tdoc2"  ></input>Uno (1)
                                <input type="radio" value="2" name="tdoc2"></input>Dos (2)
                                <input type="radio" value="3" name="tdoc2"  ></input>Tres (3)<br>
                                <input type="radio" value="4" name="tdoc2"></input>Cuatro (4)
                                <input type="radio" value="4" name="tdoc2"></input>cinco (5)
                                <input type="radio" value="4" name="tdoc2"></input>Seis (6)
                            </td>
                        </tr>
                        <tr>
                            <th>Nivel Escolaridad</th>
                            <td>
                                <input type="radio" value="1" name="tdoc6"  ></input>Ninguno
                                <input type="radio" value="2" name="tdoc6"  ></input>Primaria<br>
                                <input type="radio" value="3" name="tdoc6"  ></input>Media
                                <input type="radio" value="4" name="tdoc6"></input>Bachiller<br>
                                <input type="radio" value="5" name="tdoc6"  ></input>Técnico
                                <input type="radio" value="6" name="tdoc6"></input>Tecnólogo<br>
                                <input type="radio" value="7" name="tdoc6"></input>Profesional
                                <input type="radio" value="8" name="tdoc6"></input>Especialización<br>
                                <input type="radio" value="9" name="tdoc6"></input>Maestría
                                <input type="radio" value="10" name="tdoc6"></input>Doctorado
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
                            <td><input type="text" ></input></td>
                            <td><input type="text" ></input></td>
                            <td><input type="text" size="50" ></input></td>
                            <td><input type="text" ></input></td>
                        </tr>
                        <tr><th>Teléfono</th><th>Celular</th><th>Correo Electrónico</th><th>Parentesco</th></tr>
                        <tr>
                            <td><input type="text" ></input></td>
                            <td><input type="text" ></input></td>
                            <td><input type="text" size="50" ></input></td>
                            <td><input type="text" ></input></td>
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
                    <br></br>
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
                    <br><br><br><br>
                    <table>
                        <tr><th colspan="5">Tipo de Población</th></tr>
                        <tr>
                            <td><input type="radio" value="1" name="tipodoc"></input>ABANDONO O DESPOJO FORZADO DE TIERRAS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>HERIDO</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>ADOLESCENTE DESVINCULADO DE GRUPOS ARMADOS ORGANIZADOS</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>INDIGENAS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>ADOLESCENTE TRABAJADOR</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>JOVENES VULNERABLES</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>AMENAZA</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="1" name="tipodoc"></input>MINAS ANTIPERSONAL,MUNICION SIN EXPLOTAR,Y ARTEFACTO EXPLOSIVO IMPROVISADO </td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DELITOS CONTRA LA LIBERTAD Y  LA INTEGRIDAD SEXUAL EN DESARROLLO DEL CONFLICTO ARMADO</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>NEGRITUDES</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS DISCAPACITADOS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>PERSONAS EN PROCESO DE REINTEGRACION</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR FENOMENOS NATURALEZ CABEZA DE FAMILIA</td>
                        </tr>    
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>RECLUTAMIENTO FORZADO</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR LA VIOLENCIA CABEA DE FAMILIA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>REMITIDOS POR EL PAL</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO LIMITACION AUDITIVA O SORDA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>SECUESTRO</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO LIMITACION VISUAL O CIEGA</td>
                        </tr>    
                            <td><input type="radio" value="2" name="tipodoc"></input>SOLDADOS CAMPESINOS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADOS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>TORTURA</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>ACTOS TERRORISTA/ATENTADOS/COMBATES/ENFRENTAMIENTOS/HOSTIGAMIENTOS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>HOMICIDIO/MASACRE</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>ADOLESCENTE EN CONFLICTO CON LA LEY PENAL</td>
                        </tr>    
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>AFROCOLOMBIANOS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>INPEC</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>MICROEMPRESAS</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>ARTESANOS</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>MUJER CABEZA DE FAMILIA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DESAPARICION FORZADA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>PALENQUEROS</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR FENOMENOS NATURALES</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>RAIZALES</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DESPLAZADOS POR LA VIOLENCIA</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>REMITIDOS POR EL CIE</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO COGNITIVO</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>ROM</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO LIMITACION FISICA O MOTORA</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>SOBREVIVIENTES MINAS ANTIPERSONALES</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>DISCAPACITADO MENTAL</td>
                        </tr>
                        <tr>
                            <td><input type="radio" value="2" name="tipodoc"></input>TERCERA EDAD</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>EMPRENDEDORES</td>
                            <td><input type="radio" value="2" name="tipodoc"></input>VINCULADO DE NIÑOS,NIÑAS Y ADOLESCENTES A ACTIVIDADES RELACIONADA CON GRUPOS ARMADOS</td>
                        </tr>
                        <tr><td><input type="radio" value="2" name="tipodoc" ></input>NINGUNA</td></tr>
                    </table>
            </br>
            <center>
            <table>
                <tr>
                    <th colspan="3">Normas de Competencia Laboral en las que desea Certificarse</th>
                </tr>
                <tr>
                    <th>Código de la NCL</th><th>Vrs NCL</th><th>Título de la NCL</th>
                </tr>
                <tr>
                    <td><input type="text"></td>
                    <td><input type="text" size="3"></td>
                    <td><input type="text" size="100"></td>
                </tr>
                <tr>
                    <td><input type="text"></td>
                    <td><input type="text" size="3"></td>
                    <td><input type="text" size="100"></td>
                </tr>
                <tr>
                    <td><input type="text"></td>
                    <td><input type="text" size="3"></td>
                    <td><input type="text" size="100"></td>
                </tr>
                <tr>
                    <td><input type="text"></td>
                    <td><input type="text" size="3"></td>
                    <td><input type="text" size="100"></td>
                </tr>
            </table>
                <br>
                <center><strong>Declaración de Aceptación de Condiciones</strong></center>
                <p align="justify" style="font-size: 8px ">
                He  leído  y comprendido y por ello firmo  el presente documento como evidencia de aceptación de los requisitos especificados que debo cumplir para acceder a optar por la Certificación, en caso de no cumplir  las condiciones dadas por la Norma, Titulación, perfil y /o esquema de Certificación para la cual me presente, reconozco que no seré admitido y/o certificado  en el proceso; BAJO LA GRAVEDAD DE JURAMENTO declaro al Servicio Nacional de Aprendizaje SENA que la información suministrada es veraz y puede ser verificada por el SENA durante todo el proceso; Igualmente declaro que vengo  libremente  ante  el  SENA  para acceder  al proceso de Certificación de Competencia Laboral, que estoy solicitando.
Autorizo a entregar la información de este proceso a las entidades y autoridades que lo soliciten, como también a que el SENA  utilice  la información suministrada en mi proceso de evaluación para generar datos estadísticos e indicadores.
Manifiesto que el SENA  proporcionó la descripción vigente y detallada del proceso de certificación, incluidos  los documentos con los requisitos para la certificación, los derechos y deberes de los usuarios y/o aspirante y/o candidato.
Conozco y acepto las anteriores disposiciones, y hago oficial mi solicitud para ser candidato en la Norma, Titulación, perfil y/o  esquema de certificación de ________________________________

                </p>
                <br></br>
                Firma del Candidato ____________________________________________________
            </center>
            </form>
            <center><br>
            <input type="button" name="imprimir" value="Imprimir" onclick="$('.messages,.menuLateral').hide();window.print();">
            </center>
        </div>
 	<?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>