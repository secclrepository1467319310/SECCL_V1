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
        <div id="contenedorcito" >
            <br>
            <center><h1>Listado para Emision de Certificado</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $plan = $_GET['idplan'];

            //---
            $query23 = ("select n.codigo_norma from norma n inner join plan_evidencias pe on pe.id_norma=n.id_norma where pe.id_plan='$plan'");
            $statement23 = oci_parse($connection, $query23);
            $resp23 = oci_execute($statement23);
            $cnorma = oci_fetch_array($statement23, OCI_BOTH);
            //---
            $query232 = ("select id_proyecto from plan_evidencias where id_plan='$plan'");
            $statement232 = oci_parse($connection, $query232);
            $resp232 = oci_execute($statement232);
            $pr = oci_fetch_array($statement232, OCI_BOTH);
            //---
            $query233 = ("select grupo from plan_evidencias where id_plan='$plan'");
            $statement233 = oci_parse($connection, $query233);
            $resp233 = oci_execute($statement233);
            $g = oci_fetch_array($statement233, OCI_BOTH);
            //---
            $query234 = ("select id_norma from plan_evidencias where id_plan='$plan'");
            $statement234 = oci_parse($connection, $query234);
            $resp234 = oci_execute($statement234);
            $idn = oci_fetch_array($statement234, OCI_BOTH);

            $query235 = ("select codigo_norma from norma where ID_NORMA='$idn[0]'");
            $statement235 = oci_parse($connection, $query235);
            $resp235 = oci_execute($statement235);
            $regulada = oci_fetch_array($statement235, OCI_BOTH);

            $queryInforme = "SELECT COUNT(*) AS CANTIDAD "
                    . "FROM T_INFORME_CUALITATIVO_PROYECTO "
                    . "WHERE ID_PLAN_EVIDENCIAS= $plan";
            $statementInforme = oci_parse($connection, $queryInforme);
            oci_execute($statementInforme);
            $informe = oci_fetch_array($statementInforme, OCI_BOTH);
            ?>
            <!--<form class='proyecto' name="formmapa" action="guardar_concertacion_f_plan_ev.php?plan=<?php echo $plan ?>" method="post" accept-charset="UTF-8" >-->
            <center>
                <fieldset>
                    <legend><strong>Generalidades</strong></legend>
                    <table id="">
                        <tr>
                            <th width="">Norma</th>
                            <th width="">Proyecto</th>
                            <th width="">Grupo</th>
                        </tr>
                        <tr>
                            <td><?php echo $cnorma[0] ?></td>
                            <td><?php echo $pr[0] ?></td>
                            <td><?php echo $g[0] ?></td>
                        </tr>
                    </table>
                </fieldset>
                <br>

                <fieldset>
                    <legend><strong>Listado de Personas</strong></legend>
                    <br>
                    <?php
                    $queryProyecto = "select count(*) AS CANTIDAD from proyecto where id_proyecto = '$pr[0]' AND SUBSTR(FECHA_ELABORACION, 7,4) = 2016 ";
                    $statementProyecto = oci_parse($connection, $queryProyecto);
                    oci_execute($statementProyecto);
                    $proyecto = oci_fetch_array($statementProyecto, OCI_BOTH);
                    if ($informe['CANTIDAD'] >= 1 || $proyecto['CANTIDAD'] < 1)
                    {
                        ?>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br></br>
                        <table id="demotable1">
                            <thead><tr>
                                    <th width="">N°</th>
                                    <th width="">Primer Apellido</th>
                                    <th width="">Segundo Apellido</th>
                                    <th width="">Nombres </th>
                                    <th width="">Tipo de Documento </th>
                                    <th width="">Documento </th>
                                    <th width="">Juicio</th>
                                    <th width="">Emitir Certificado</th>
                                </tr></thead>
                            <tbody>
                            </tbody>
                            <?php
                            $query = "select unique
                                        u.usuario_id,
                                        u.documento,
                                        TD.DESCRIPCION,
                                        u.nombre,
                                        u.primer_apellido,
                                        u.segundo_apellido
                                        from usuario u
                                        inner join proyecto_grupo pe
                                        on pe.id_candidato=u.usuario_id
                                        INNER JOIN TIPO_DOC TD ON U.TIPO_DOC = TD.ID_TIPO_DOC
                                        where pe.n_grupo='$g[0]' 
                                        and pe.id_proyecto='$pr[0]' 
                                        and id_norma='$idn[0]' order by u.primer_apellido asc ";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH))
                            {

                                $query33 = ("select estado from evidencias_candidato
                                where id_plan='$plan' and id_norma='$idn[0]' and id_candidato='$row[USUARIO_ID]'");
                                $statement33 = oci_parse($connection, $query33);
                                $resp33 = oci_execute($statement33);
                                $estado = oci_fetch_array($statement33, OCI_BOTH);

                                //----

                                $query332 = ("select count(*) from certificacion where id_candidato='$row[USUARIO_ID]' and id_norma='$idn[0]' and id_proyecto = '$pr[0]'");
                                $statement332 = oci_parse($connection, $query332);
                                $resp332 = oci_execute($statement332);
                                $certificadoProyecto = oci_fetch_array($statement332, OCI_BOTH);

                                $query3322 = ("select id_proyecto from certificacion where id_candidato='$row[USUARIO_ID]' and id_norma='$idn[0]' and id_proyecto != '$pr[0]'");
                                $statement3322 = oci_parse($connection, $query3322);
                                $resp3322 = oci_execute($statement3322);
                                $certificadoNorma = oci_fetch_array($statement3322, OCI_BOTH);

                                $query333 = ("select count(*) from T_NORMAS_REGULADAS where CODIGO_NORMA='$regulada[0]'");
                                $statement333 = oci_parse($connection, $query333);
                                $resp333 = oci_execute($statement333);
                                $normaRegulado = oci_fetch_array($statement333, OCI_BOTH);
                                ?>
                                <tr>
                                    <td><?php echo $numero + 1; ?></td>
                                    <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                    <td><?php echo utf8_encode($row["DESCRIPCION"]); ?></td>
                                    <td><?php echo $row["DOCUMENTO"]; ?></td>
                                    <?php
//                                    if ($certificado[0] == 0 && ($estado[0] == 0 || $estado[0] == 2 || $estado[0] == 3 || $estado[0] == 4)) {
//                                        $estadoCertificacion = 'No disponible';
//                                    } else if ($certificado[0] == 0 && ($estado[0] != 1 && $normaRegulado['existe'] >= 1)) {
//                                        $estadoCertificacion = "<a href='generar_certificado.php?idplan=$plan&norma=$idn[0]&idca=$row[USUARIO_ID]&proyecto=$pr[0]' onclick='return confirm(¿Esta seguro que desea generar el certificado a esta persona?)'> <label style='color: #23838b; cursor: pointer'>Generar Certificado</label></a>";
//                                    } else {
//                                        $estadoCertificacion = 'Certificado';
//                                    }

                                    $colorAnuncio = '#cd0a0a';

                                    if ($certificadoProyecto[0] >= 1)
                                    {
                                        $estadoCertificacion = 'Certificado';
                                        $colorAnuncio = '#31B404';
                                    }
                                    else if ($certificadoNorma)
                                    {
                                        $estadoCertificacion = 'Certificado en segundo intento en el proyecto ' . $certificadoNorma['ID_PROYECTO'];
                                        $colorAnuncio = '#31B404';
                                    }
                                    else if ($estado[0] == 0)
                                    {
                                        $estadoCertificacion = 'No disponible';
                                    }
                                    else if ($certificado[0] == 0 && ($estado[0] == 4 || $estado[0] == 3) && ($normaRegulado['existe'] >= 1))
                                    {
                                        $estadoCertificacion = 'Norma Regulada';
                                    }
                                    else if ($certificado[0] == 0 && ($estado[0] == 1) && ($normaRegulado[0] > 0))
                                    {
                                        $estadoCertificacion = '<form action="generar_certificado.php" method="POST" onsubmit="return confirm(\'¿Esta seguro que desea generar el certificado a esta persona?\');">
                                            <input type="hidden" name="plan" value="' . $plan . '"/>
                                            <input type="hidden" name="norma" value="' . $idn[0] . '"/>
                                            <input type="hidden" name="idca" value="' . $row[USUARIO_ID] . '"/>
                                            <input type="hidden" name="proyecto" value="' . $pr[0] . '"/>
                                            <input type="hidden" name="nivel" value="' . $estado[0] . '"/>
                                            <input type="submit" value="Generar Certificado"/>
                                        </form>';
                                    }
                                    else if ($certificado[0] == 0 && $estado[0] == 2)
                                    {
                                        $estadoCertificacion = 'Aun no Competente';
                                    }
                                    else if ($certificado[0] == 0 && ($estado[0] == 3 || $estado[0] == 4) && ($normaRegulado[0] > 0))
                                    {
                                        $estadoCertificacion = 'Norma Regulada';
                                    }
                                    else if ($certificado[0] == 0 && ($estado[0] == 4 || $estado[0] == 3 || $estado[0] == 1) && ($normaRegulado['existe'] == 0))
                                    {
                                        $estadoCertificacion = '<form action="generar_certificado.php" method="POST" onsubmit="return confirm(\'¿Esta seguro que desea generar el certificado a esta persona?\');">
                                            <input type="hidden" name="plan" value="' . $plan . '"/>
                                            <input type="hidden" name="norma" value="' . $idn[0] . '"/>
                                            <input type="hidden" name="idca" value="' . $row[USUARIO_ID] . '"/>
                                            <input type="hidden" name="proyecto" value="' . $pr[0] . '"/>
                                            <input type="hidden" name="nivel" value="' . $estado[0] . '"/>
                                            <input type="submit" value="Generar Certificado"/>
                                        </form>';
                                    }

                                    if ($estado[0] == 0)
                                    {
                                        $estadoNivel = 'Sin Juicio';
                                    }
                                    elseif ($estado[0] == 1)
                                    {
                                        $estadoNivel = 'Nivel Avanzado';
                                    }
                                    elseif ($estado[0] == 2)
                                    {
                                        $estadoNivel = 'Aun no competente';
                                    }
                                    elseif ($estado[0] == 3)
                                    {
                                        $estadoNivel = 'Nivel Intermedio';
                                    }
                                    elseif ($estado[0] == 4)
                                    {
                                        $estadoNivel = 'Nivel Básico';
                                    }
                                    ?>
                                    <td><?php echo $estadoNivel ?></td>
                                    <td><label style="color: <?php echo $colorAnuncio; ?>"><?php echo $estadoCertificacion ?></label></td>

                                    <?php
                                    $numero++;
                                }
                                ?>
                            </tr>
                            <?php
//                            }
                            ?>
                        </table>
                        <?php
                    }
                    else
                    {
                        ?>
                        <strong style="font-weight: bold; font-size: 18px"> No se puede emitir certificados hasta que el evaluador diligencie el formato de informe cualitativo del proyecto. </strong>
                    <?php } ?>
                </fieldset>
            </center>
            <!--</form>-->
        </div>
        <div class="space">&nbsp;</div>
        <?php include ('layout/pie.php') ?>

        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>