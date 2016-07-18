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
            <div id="contenedorcito">
                <?php
                $proyecto = $_GET["proyecto"];
                ?>
                <br>
                <center><strong>Centros del Proyecto</strong></center>
                </br>

                <form name="f1" onSubmit="return validar2()" 
                      action="guardar_centro_proyecto_n.php?proyecto=<?php echo $proyecto ?>" method="post" >
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    <br></br>
                    <center>
                        <table id="demotable1">
                            <thead><tr>
                                    <th><strong>Regional</strong></th>
                                    <th><strong>Codigo Centro</strong></th>
                                    <th><strong>Centro</strong></th>
                                    <th><strong>Seleccionar</strong></th>
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
                            $query = "SELECT 
   r.nombre_regional REGIONAL, 
   ce.codigo_centro CODIGO_CENTRO  ,
   ce.nombre_centro CENTRO  ,
   ce.id_centro 
FROM centro rce
INNER JOIN regional r ON rce.codigo_regional =  r.codigo_regional
INNER JOIN centro ce ON rce.codigo_centro =  ce.codigo_centro
order by regional asc";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                utf8_encode($row["REGIONAL"]) . "</font></td>";
                                echo "<td width=\"5%\"><font face=\"verdana\">" .
                                $row["CODIGO_CENTRO"] . "</font></td>";
                                echo "<td width=\"25%\"><font face=\"verdana\">" .
                                utf8_encode($row["CENTRO"]) . "</font></td>";
                                ?>

                                <td width="10%"><input name="codigo[]" type="checkbox" value="<?php echo $row["ID_CENTRO"]; ?>"><br /></input></td>

                                <?php
                                $numero++;
                            }
                            ?>
                        </table>
                </form>
                <br></br>
                <center><input name="send" type="submit" id="send" value="Asociar"></input></center>
                <br></br>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>



    </body>
</html>