<?php
//candidatoncl_c: Muestra las normas para asociarlas al proyecto en la que esta registrado el usuario
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
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito">
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

            $proyecto = $_GET["proyecto"];
            ?>


            <br>
            <center><strong>Información Candidato del Proyecto</strong></center>
            </br>

            <form name="f1" onSubmit="return validar2()" 
                  action="guardar_ncl_candidato_c.php?proyecto=<?php echo $proyecto ?>&id=<?php echo $_GET[id] ?>" method="post" >
                <br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                <br></br>
                <center>
                    <table id="demotable1">
                        <thead><tr>
                                <th><strong>Código Mesa</strong></th>
                                <th><strong>Mesa</strong></th>
                                <th><strong>Código Norma</strong></th>
                                <th><strong>Versión</strong></th>
                                <th><strong>Título Norma</strong></th>
                                <th><strong>Seleccionar</strong></th>
                            </tr></thead>
                        <tbody>
                        </tbody>

                        <?php
                        $query8 = ("SELECT ID_PROVISIONAL FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                        $statement8 = oci_parse($connection, $query8);
                        $resp8 = oci_execute($statement8);
                        $pro = oci_fetch_array($statement8, OCI_BOTH);

                        $q = "select id_norma from detalles_poa where id_provisional='$pro[0]'";
                        $statement3 = oci_parse($connection, $q);
                        oci_execute($statement3);
                        $numero3 = 0;
                        $btnhabilitado = false;
                        while ($row3 = oci_fetch_array($statement3, OCI_BOTH))
                        {
                            $query = "select mesa.nombre_mesa,norma.codigo_mesa,norma.codigo_norma,norma.version_norma,
                                norma.titulo_norma,norma.id_norma from norma
                                join mesa
                                on mesa.codigo_mesa=norma.codigo_mesa
                                where norma.id_norma='$row3[ID_NORMA]'";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;

                            $qcompcandidatonp = "SELECT * FROM CANDIDATOS_PROYECTO CP WHERE CP.ID_PROYECTO=$_GET[proyecto] AND CP.ID_CANDIDATO=$_GET[id] AND CP.ID_NORMA=$row3[ID_NORMA] ";

                            $scompcandidatono = oci_parse($connection, $qcompcandidatonp);
                            oci_execute($scompcandidatono);
                            $rcompcandidatonp = oci_fetch_array($scompcandidatono, OCI_NUM);
                            $btnhabilitado = !$rcompcandidatonp ? true : false;

                            $querycanc = ("SELECT PROYECTO,GRUPO FROM T_NOVEDADES_CANDI_GRUP WHERE USUARIO_CANDIDATO='$_GET[id]' AND NORMA = '$row3[ID_NORMA]' AND TIPO_NOVEDAD='4' AND FECHA_REGISTRO >= ADD_MONTHS(TO_DATE(SYSDATE,'DD/MM/YYYY'),-12)");
                            $statementcanc = oci_parse($connection, $querycanc);
                            $respcanc = oci_execute($statementcanc);
                            $cancelacion = oci_fetch_all($statementcanc, $rowNov);
                            $cancelacion = ($cancelacion) ? 1 : 0;

                            $queryproy = ("SELECT ID_PROYECTO,ID_REGIONAL,ID_CENTRO FROM PROYECTO WHERE ID_PROYECTO = {$rowNov['PROYECTO'][0]}");
                            $statementproy = oci_parse($connection, $queryproy);
                            $respproy = oci_execute($statementproy);
                            $proyecto = oci_fetch_all($statementproy, $rowProy);

                            while ($row = oci_fetch_array($statement, OCI_BOTH))
                            {
                                echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                $row["CODIGO_MESA"] . "</font></td>";
                                echo "<td width=\"5%\"><font face=\"verdana\">" .
                                $row["NOMBRE_MESA"] . "</font></td>";
                                echo "<td width=\"5%\"><font face=\"verdana\">" .
                                $row["CODIGO_NORMA"] . "</font></td>";
                                echo "<td width=\"2%\"><font face=\"verdana\">" .
                                $row["VERSION_NORMA"] . "</font></td>";
                                echo "<td width=\"25%\"><font face=\"verdana\">" .
                                utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                ?>

                                <td width="10%">
                                    <?php
                                    if ($cancelacion == 1)
                                    {
                                        echo "<br/><b style='color:red'>Candidato cancelado por decisión del comite ECCL en R{$rowProy['ID_REGIONAL'][0]}_C{$rowProy['ID_CENTRO'][0]}_P{$rowNov['PROYECTO'][0]}_G{$rowNov['GRUPO'][0]}</b><br/>";
                                    }
                                    else
                                    {
                                        echo $rcompcandidatonp ? "YA ASOCIADA" : '<input name="codigo[]" type="checkbox" value="' . $row[ID_NORMA] . '"><br /></input>';
                                    }
                                    ?>
                                </td>
                                <?php
                                $numero3++;
                            }
                            $numero++;
                        }
                        //var_dump($btnhabilitado);
                        ?>
                    </table>
            </form>
            <br></br>
            <center><input name="send" type="submit" id="send" value="Asociar" ></input></center>
            <br></br>

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