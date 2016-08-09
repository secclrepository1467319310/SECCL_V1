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
            <center><h1>Listado para Emision de Juicio</h1></center>
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
            ?>
            <form class='proyecto' name="formmapa" action="guardar_concertacion_f_plan_ev.php?plan=<?php echo $plan ?>" method="post" accept-charset="UTF-8" >
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
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br></br>
                        <table id="demotable1">
                            <thead><tr>
                                    <th width="">N°</th>
                                    <th width="">Primer Apellido</th>
                                    <th width="">Segundo Apellido</th>
                                    <th width="">Nombres </th>
                                    <th width="">Documento</th>
                                    <th width="">Registrar Valoración de Evidencias</th>
                                    <th width="">Juicio</th>
                                </tr></thead>
                            <tbody>
                            </tbody>
                            <?php
                            $query = "select DISTINCT u.usuario_id,u.nombre,u.primer_apellido,u.segundo_apellido,u.documento,ttn.TIPO_NOVEDAD
                                from usuario u
                                inner join inscripcion i
                                    on (i.id_candidato=u.usuario_id)
                                left join T_NOVEDADES_CANDI_GRUP tncg
                                on (tncg.proyecto=i.id_proyecto
                                  and 
                                  tncg.norma=i.id_norma
                                  and 
                                  tncg.grupo=i.grupo
                                  and 
                                  tncg.usuario_candidato=u.usuario_id
                                )
                                left join T_TIPO_NOVEDADES ttn
                                on (
                                tncg.TIPO_NOVEDAD=TTN.ID_T_TIPO_NOVEDADES
                                )    


                                where i.grupo='$g[0]'
                                    and i.id_proyecto='$pr[0]' 
                                    and i.estado=1
                                    and id_norma='$idn[0]'
                                order by u.primer_apellido asc  ";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                $query33 = ("select estado from evidencias_candidato
                                where id_plan='$plan' and id_norma='$idn[0]' and id_candidato='$row[USUARIO_ID]'");
                                $statement33 = oci_parse($connection, $query33);
                                $resp33 = oci_execute($statement33);
                                $estado = oci_fetch_array($statement33, OCI_BOTH);
                                ?>
                                <tr>
                                    <td><?php echo $numero + 1; ?></td>
                                    <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                    <td><?= $row[DOCUMENTO]?></td>
                                    <?php
                                    if($row[TIPO_NOVEDAD]==null){
                                        if ($estado[0] == NULL || $estado[0] == 0) {
                                            ?>
                                            <td><a href="emitir_juicio_ev.php?idca=<?php echo $row["USUARIO_ID"] ?>&norma=<?php echo $idn[0] ?>&idplan=<?php echo $plan ?>" >Registrar Valoraciones</a></td>
                                        <?php } else { ?>
                                            <td>No Disponible</td>
                                            <?php
                                        }
                                        
                                    }
                                    else{
                                        echo "<td><font style='color:red'>".  utf8_encode( "No se puede registrar valoraciones ya que el candidato presenta una novedad de tipo: $row[TIPO_NOVEDAD]")."</font></td>";
                                    }
                                    if ($estado[0] == NULL || $estado[0] == 0) {
                                        ?>
                                        <td><strong><label style="color: #cd0a0a">Sin Juicio</label></strong></td>
                                        <?php
                                    } else if ($estado[0] == 1) {
                                        ?>
                                        <td><strong><label style="color: #23838b">Nivel Avanzado</label></strong></td>
                                    <?php } else if ($estado[0] == 2) { ?>
                                        <td><strong><label style="color: #cd0a0a">Aun No Competente</label></strong></td>
                                    <?php } else if ($estado[0] == 3) { ?>
                                        <td><strong><label style="color: #23838b">Nivel Intermedio</label></strong></td>
                                    <?php } else if ($estado[0] == 4) { ?>
                                        <td><strong><label style="color: #23838b">Nivel Básico</label></strong></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $numero++;
                            }
                            $queryInforme = "SELECT COUNT(*) AS CANTIDAD "
                                    . "FROM T_INFORME_CUALITATIVO_PROYECTO "
                                    . "WHERE ID_PLAN_EVIDENCIAS= $plan";
                            $statementInforme = oci_parse($connection, $queryInforme);
                            oci_execute($statementInforme);
                            $informe = oci_fetch_array($statementInforme, OCI_BOTH);
                            ?>
                        </table>
                    </fieldset>
                    <br>
                    <?php if ($informe['CANTIDAD'] < 1) { ?>
                        <a href="informe_cualitativo_proyecto.php?id_plan=<?php echo $plan ?>" style="font-size: 16px; font-weight: bold">Diligenciar Informe Cualitativo De Proyecto</a>
                    <?php } else { ?>
                        <a href="modificar_informe_cualitativo_proyecto.php?id_plan=<?php echo $plan ?>" style="font-size: 16px; font-weight: bold">Modificar Informe Cualitativo De Proyecto</a>
                    <?php } ?>
                    <br>
                </center>
            </form>
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