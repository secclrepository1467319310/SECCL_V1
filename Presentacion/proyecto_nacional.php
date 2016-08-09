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

$centros = $_POST['centro'];

//var_dump($centros);

function restaFechas($dFecIni, $dFecFin) {
    $dFecIni = str_replace("-", "", $dFecIni);
    $dFecIni = str_replace("/", "", $dFecIni);
    $dFecFin = str_replace("-", "", $dFecFin);
    $dFecFin = str_replace("/", "", $dFecFin);

    ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
    ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

    $date1 = mktime(0, 0, 0, $aFecIni[2], $aFecIni[1], $aFecIni[3]);
    $date2 = mktime(0, 0, 0, $aFecFin[2], $aFecFin[1], $aFecFin[3]);

    return round(($date2 - $date1) / (60 * 60 * 24));
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
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="js/proyecto_nacional.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_proyecto_nacional.js" type="text/javascript"></script>
        <script src="js/cargar_datos_proyectos_nacionales.js" type="text/javascript"></script>
        <script src="js/validar_textarea.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
    </head>
    <body>
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <?php
                $query3 = ("SELECT cu.id_centro, ce.codigo_centro FROM centro_usuario cu 
                    INNER JOIN centro ce ON cu.id_centro = ce.id_centro
                    where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);


                $query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT codigo_centro FROM centro  where id_centro =  '$idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>

                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>FORMATO DE REGISTRO DE PROGRAMACIÓN ANUAL PARA EL PROCESO</strong><br></br>
                    <strong> Certificación de Competencias Laborales</strong>
                    <strong>Datos Generales</strong><br></br>


                    <form id="frmProyectoNacional" name="f2" action="guardar_proyecto_nacional.php" method="post">
                        <?php
                        if (isset($centros)) {
                            foreach ($centros as $centro => $value) {
                                $valores = $valores . $value . ",";
                                $_SESSION['ID_PROYECTOS_NACIONALES'] = $valores;
                            }
                        }
                        ?>
                        <input type="hidden" id="planes_centro" name="planes_centro" value="<?php echo $_SESSION['ID_PROYECTOS_NACIONALES'] ?>" />
                        <table>
                            <tr>
                                <th>Tipo de Proyecto</th>
                                <td>
                                    <select name="tipo_proyecto" id='ddlTipoProyecto'>
                                        <option value="PN" >Proyecto Nacional</option>
                                        <option value="PR" >Proyecto Regional</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Línea de Atención</th>
                                <td>
                                    <select name="tp" id='ddlLienaAtencion' onclick="activa(this.value)">
                                        <option value="2" >Alianza</option>
                                        <option value="1" >Demanda Social</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class='trAlianza'>
                                <th>Nit de Empresa</th>
                                <td><input name="nit_empresa" id="nit_empresa" maxlength="9" onKeyPress="return validar(event)" type="text" value="<?php echo $_GET["nit"] ?>"/>
                                    <input id="val" type="button" value="Validar nit" onkeypress="validar();" class="botones" onClick="window.location = 'validar_nit_pro_nac.php?poa=<?php echo $plan ?>&nit=' + document.getElementById('nit_empresa').value"/>
                                </td>
                            </tr>
                            <tr class='trAlianza'>
                                <th>Nombre de  la Empresa</th>
                                <td><input name="nombre_empresa" size="80" type="text" readonly value="<?php echo $_GET["empresa"] ?>"/>
                                    <?php
                                    if ($_GET["empresa"] == 'Empresa no Registrada') {
                                        ?>
                                        <a href="reg_empresa.php?nit=<?php echo $_GET["nit"] ?>&plan=<?php echo $plan ?>">Registrar empresa</a>
                                        <?php
                                    } else {
                                        ?>
                                        Empresa Registrada
                                    <?php }
                                    ?>
                                </td>
                            </tr>
                            <tr class='trAlianza'>
                                <th>Sigla de  la Empresa</th>
                                <td>
                                    <input name="sigla_empresa" type="text" readonly value="<?php echo $_GET["sigla"] ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Unidad de Certificación</th>
                                <td>
                                    Norma
                                </td>
                            </tr>
                            <tr>
                                <th>Nombre del Contacto</th>
                                <td>
                                    <input name="nombre_contacto" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Teléfono del Contacto</th>
                                <td>
                                    <input name="telefono_contacto" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Celular del Contacto</th>
                                <td>
                                    <input name="celular_contacto" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Email del Contacto</th>
                                <td>
                                    <input name="email_contacto" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Presupuesto SENA</th>
                                <td>
                                    <input name="presupuesto_sena" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Presupuesto Entidad Externa</th>
                                <td>
                                    <input name="presupuesto_entidad" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Descripción</th>
                                <td>
                                    <textarea name="descripcion" style=" width: 99%;" ></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Numero Total de Candidatos</th>
                                <td>
                                    <input name="numero_total_candidatos" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Descripción Proyecto Regional</th>
                                <td>
                                    <textarea name="desc_pro_regional" style=" width: 99%;" ></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Observación</th>
                                <td style=" height: 100px; width: 500px;" class="<?php echo $classDivProNac; ?>">
                                    <textarea id="txt" name="txt" maxlength="200" style=" width: 99.5%; height: 85%; "></textarea>
                                    Numero de caracteres: <label id="cantidadImpacto" style="color: red;"></label>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <br>
                        <center><strong>Información de la población que atiende el proyecto</strong></center>
                        </br>
                        <table>
                            <tr>
                                <th>Línea de Atención</th>
                                <th>Tipo de Población</th>
                            </tr>
                            <tr class='trAlianza'>
                                <td rowspan="5" width="20%" ><input type="radio" id='radAlianza'/>Alianza</td>
                            </tr>
                            <tr class='trAlianza'>
                                <td><input type="checkbox" value="1"  name="al1"/><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td>
                            </tr>
                            <tr class='trAlianza'>
                                <td><input type="checkbox" value="1"  name="al2"/><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td>
                            </tr>
                            <tr class='trAlianza'>
                                <td><input type="checkbox" value="1"  name="al3"/><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td>
                            </tr>
                            <tr class='trAlianza'>
                                <td><input type="checkbox" value="1"  name="al4"/><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td>
                            </tr>
                            <tr class='trDemandaSocial'>
                                <td rowspan="5" width="20%" ><input type="radio" id='radDemandaSocial'/>Demanda Social</td>
                            </tr>
                            <tr class='trDemandaSocial'>
                                <td><input type="checkbox" value="1"  name="al1"/><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td>
                            </tr>
                            <tr class='trDemandaSocial'>
                                <td><input type="checkbox" value="1"  name="al2"/><strong>• Independientes:</strong>Propietarios de micro-empresa, pequeña empresa o personas que trabajan por cuenta propia.</td>
                            </tr>
                            <tr class='trDemandaSocial'>
                                <td><input type="checkbox" value="1"  name="al3"/><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual.</td>
                            </tr>
                            <tr class='trDemandaSocial'>
                                <td><input type="checkbox" value="1"  name="al4"/><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td>
                            </tr>
                        </table>
                        <br>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br>
                        <div id="divMesas">
                            <table id="demotable1" >
                                <thead>
                                    <tr>
                                        <th><strong>Código Mesa</strong></th>
                                        <th><strong>Nombre Mesa</strong></th>
                                        <th><strong>Seleccionar</strong></th>
                                    </tr>
                                </thead>
                                <tbody id="tblMesa"></tbody>
                            </table>
                            <div class="valError"></div>
                            <input type="button" name="btnInsertar" id="btnInsertar" value="Siguiente"/>
                        </div>
                        <div id="divNormas">
                            <table id="demotable1" >
                                <thead>
                                    <tr>
                                        <th><strong>Código Norma</strong></th>
                                        <th><strong>Versión Norma</strong></th>
                                        <th><strong>Título Norma</strong></th>
                                        <th><strong>Fecha Expiración Norma</strong></th>
                                        <th><strong>Seleccionar</strong></th>
                                    </tr>
                                </thead>
                                <tbody id="tblNormas"></tbody>
                            </table>
                            <div class="valError"></div>
                            <br>
                            <input type="button" name="btnRegresar" id="btnRegresar" value="Regresar"/>
                            <input type="submit" name="btnGuardar" id="btnGuardar" value="Guardar"/>
                        </div>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>