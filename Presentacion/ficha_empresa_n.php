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
<script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_ficha_empresa_n.js"></script>
        <script src="ajax.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />


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
            <div id="contenedorcito" >

                <br>
                <br><center><strong>Ficha de Registro de Empresa</strong></center></br>
                <form name="f1" id="f1" onSubmit="return validarv(event)" method="post" 
                      action="guardar_ficha_n.php?usuario=<?php echo $login ?>" accept-charset="UTF-8">

                    <center>
                        <br>
                        <center><strong>Características de la Empresa</strong></center>
                        </br>
                        <table id='demotable1'>
                            <tr>
                                <th>Tipo Característica Empresarial</th>
                                <th>Tipo de Geolocalización</th>
                                <th>Pertene a Gremio?</th>
                                <th>Nit Gremio</th>
                                <th>Pertene a Asociación?</th>
                                <th>Nit Asociación</th>
                            </tr>
                            <tr>
                                <td><select name="tcaract"> 
                                        <option value="1" >Gremio</option>
                                        <option value="2" >Asociación</option>
                                        <option value="3" >Empresa Individual</option>
                                    </select></td>
                                <td><select name="tgeo"> 
                                        <option value="1" >Principal</option>
                                        <option value="2" >Sucursal</option>
                                    </select></td>
                                <td><select name="pgremio"> 
                                        <option value="1" >Si</option>
                                        <option value="2" >No</option>
                                    </select></td>
                                <td><input type="text" name="gremio" /></td>
                                <td><select name="pasoc"> 
                                        <option value="1" >Si</option>
                                        <option value="2" >No</option>
                                    </select></td>
                                <td><input type="text" name="asoc" /></td>
                            </tr>

                        </table>
                        <br>
                        <center><strong>Información Específica</strong></center>
                        </br>
                        <table id='demotable1'>
                            <tr>
                                <th>Tipo ID</th>
                                <th>ID (sin dígitos de verificación ni guiones)</th>
                                <th>Tamaño de la Empresa</th>
                                <th>Número de empleados</th>
                                <th>Nombre o Razón Social</th>
                            </tr>
                            <tr>
                                <td><select name="tid"> 
                                        <option value="1" >Nit</option>
                                        <option value="2" >Rut</option>
                                        <option value="3" >Otro</option>
                                    </select></td>
                                <td><input type="text" name="nit" /></td>
                                <td><select name="tam"> 
                                        <option value="1" >Grande</option>
                                        <option value="2" >Mediana</option>
                                        <option value="3" >Pequeña</option>
                                        <option value="4" >Micro</option>
                                    </select></td>
                                <td><input type="text" name="empleados" /></td>
                                <td><input type="text" name="razonsoc" /></td>
                            </tr>
                            <tr>
                                <th>Sigla</th>
                                <th>Dirección</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Nombre Representante Legal/Gerente</th>
                            </tr>
                            <?php
                            $query2 = ("SELECT * FROM DEPARTAMENTO");
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            ?>
                            <tr>
                                <td><input type="text" name="sigla" /></td>
                                <td><input type="text" name="direccion_e" /></td>
                                <td><select id="cont" name="departamento" onchange="load(this.value)">

                                        <option value="">Seleccione</option>

                                        <?php
                                        while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                            ?>

                                            <option value="<?php echo $row[ID_DEPARTAMENTO]; ?>"><?php echo utf8_encode($row[NOMBRE_DEPARTAMENTO]); ?></option>

                                        <?php } ?>

                                    </select>
                                </td>
                                <td><div id="myDiv"></div></td>
                                <td><input type="text" name="representante" /></td>                                        
                            </tr>
                            <tr>
                                <th>Email Representante Legal/Gerente</th>
                                <th>Teléfono</th>
                                <th>Clasificación de la empresa</th>
                                <th>Sector Económico</th>
                                <th>Tipo de Empresa</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="email_rep" /></td>
                                <td><input type="text" name="tel_e" /></td>
                                <td><select name="clasificacion"> 
                                        <option value="1" >Privada</option>
                                        <option value="2" >Pública</option>
                                        <option value="3" >Mixta</option>
                                    </select></td>
                                <td><select name="sector"> 
                                        <option value="1" >Primario</option>
                                        <option value="2" >Comercio</option>
                                        <option value="3" >Industria</option>
                                        <option value="4" >Servicios</option>
                                    </select></td>
                                <td><select name="tipo_e"> 
                                        <option value="1" >Sin ánimo de lucro</option>
                                        <option value="2" >Con ánimo de lucro</option>
                                        <option value="3" >Trabajo Asociado</option>
                                        <option value="4" >Economía solidaria</option>
                                        <option value="5" >Instituciones Educativas</option>
                                    </select></td>
                            </tr>
                        </table>
                        <br>
                        <center><strong>Información del Coordinador del Proyecto en la Empresa a Nivel Nacional</strong></center>
                        </br>
                        <table>
                            <tr>
                                <th>Tipo ID</th>
                                <th>Identificación</th>
                                <th>Nombres</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="tdoc">
                                        <option value="2">Cédula de Ciudadanía</option>
                                        <option value="3">Cédula de Extranjería</option>
                                        <option value="4">Pasaporte</option>
                                    </select>
                                </td>
                                <td><input type="text" name="documento" ></input></td>
                                <td><input type="text" name="nombres" ></input></td>
                                <td><input type="text" name="papellido" ></input></td>
                                <td><input type="text" name="sapellido" ></input></td>
                            </tr>
                            <tr>
                                <th>Dirección</th>
                                <th>Cargo</th>
                                <th>Teléfono</th>
                                <th>Celular</th>
                                <th>Email</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="direccion" ></input></td>
                                <td><input type="text" name="cargo" ></input></td>
                                <td><input type="text" name="tel" ></input></td>
                                <td><input type="text" name="cel" ></input></td>
                                <td><input type="text" name="email" ></input></td>
                            </tr>

                        </table>
                    </center>

                    <br></br>
                    <p><label>

                            <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I" />
                        </label></p>

                </form>
                </br>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>



    </body>
</html>