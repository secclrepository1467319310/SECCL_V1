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
            <div id="contenedorcito" style="height:600px;width:1050px;overflow:scroll;">
                <div id="consulta">
                    <center>
                        <form action="cons_portafolio_b.php" method="GET">
                            <tr>
                                <td><label>Tipo Rol</label></td>
                                <td>
                                    <Select Name="rol" onchange="this.form.submit();" >

                                        <?PHP
                                        $query2 = ("SELECT * FROM ROL");
                                        $statement2 = oci_parse($connection, $query2);
                                        oci_execute($statement2);
                                        while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                            $id_td = $row["ID_ROL"];
                                            $doc = $row["DESCRIPCION"];

                                            echo "<OPTION value=" . $id_td . ">", utf8_encode($doc), "</OPTION>";
                                        }
                                        ?>

                                    </Select>

                                </td>
                            </tr>
                        </form>
                    </center>
                </div>


                <div id="resultado">
                    <?php
                    $r = $_GET['rol'];
                    if ($r <> NULL) {
                        ?>
                        <br><br>
                        <center><strong>Documentos En Mi Portafolio</strong></center>
                        <br></br>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br></br>
                        <center>
                            <table border="1" id="demotable1">
                                <thead><tr>
                                        <th><strong>ROL</strong></th>
                                        <th><strong>NOMBRE</strong></th>
                                        <th><strong>PRIMER APELLIDO</strong></th>
                                        <th><strong>SEGUNDO APELLIDO</strong></th>
                                        <th><strong>TIPO DE DOCUMENTO</strong></th>
                                        <th><strong>DESCRIPCION</strong></th>
                                        <th><strong>VER</strong></th>
                                    </tr></thead>
                                <tbody>
                                </tbody>
    <?php
    $query = "select 
r.descripcion ROL,
u.nombre,
u.primer_apellido,
u.segundo_apellido,
p.id_portafolio,
tp.nombre_documento,
p.descripcion,
p.bin_data
from portafolio p
inner join tipo_doc_portafolio tp
on tp.id_tdoc_portafolio=p.tipo_documento
inner join usuario u
on u.usuario_id=p.id_usuario
inner join rol r
on u.rol_id_rol=$r
";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $numero = 0;
    while ($row = oci_fetch_array($statement, OCI_BOTH)) {

        echo "<tr><td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["ROL"]) . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["NOMBRE"]) . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["PRIMER_APELLIDP"]) . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["SEGUNDO_APELLIDO"]) . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["NOMBRE_DOCUMENTO"]) . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["DESCRIPCION"]) . "</font></td>";
        echo "<td width=\"\"><a href=\"file.php?id=" . $row["ID_PORTAFOLIO"] . "\" TARGET=\"_blank\">
        Ver</a></td></tr>";


        $numero++;
    }
    oci_close($connection);
    ?>
                            </table>
                        </center>
                                <?php
                            } else {
                                ?>
                        <br><br>
                        <center>Favor Seleccionar rol</center>
                        <?php }
                    ?>
                    <br></br>
                </div>



            </div>
        </div>
<?php include ('layout/pie.php') ?>


    </body>
</html>