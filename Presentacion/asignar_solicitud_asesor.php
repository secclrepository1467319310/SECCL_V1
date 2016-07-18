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
//var_dump($_POST);
extract($_POST);
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
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/validar_textarea.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {

//                alert('Hola Dina, nos encontramos realizando pruebas en esta vista, por favor no te asustes, gracias y perdon por las molestias.');
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

                <center><?php echo '<font><strong>Asignar solicitudes a los encargados del banco</strong></font>'; ?></center>
                <br>
                <center>
                    <table>
                        <tr><th>N°</th><th>Solicitudes a asignar</th></tr>
                        <?php
                        echo "Asignar las solicitudes <br>";
                        $cnt=1;
                        foreach ($id_solicitud as $valor) {
                            echo "<tr><td>$cnt</td><td>$valor</td></tr>";
                            $valores = $valores.$valor.",";
                            $cnt++;
                        }
    //                    echo $valores;
                        ?>
                    </table>
                    <br>
                    <form action="guardar_asignar_solicitud_asesor.php" method="post">
                        <input type="hidden" name="solicitudes" value="<?php echo $valores; ?>" />
                        <center>
                            <input type="hidden" name="hidEncargado" value="<?php echo $_GET[solicitud]; ?>"/>
                            <table>
                                <tr>
                                    <th>Nombre del Encargado del Banco</th>
                                    <th>Asignar</th>
                                </tr>
                                <?php
                                extract($_POST);
                                $query = "SELECT *
                                    FROM USUARIO
                                    WHERE ROL_ID_ROL = '2' AND ESTADO='1'";
                                $statement = oci_parse($connection, $query);
                                $execute = oci_execute($statement, OCI_DEFAULT);
                                $numRows = oci_fetch_all($statement, $rows);

                                for ($i = 0; $i < $numRows; $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo utf8_encode($rows[NOMBRE][$i] . ' ' . $rows[PRIMER_APELLIDO][$i] . ' ' . $rows[SEGUNDO_APELLIDO][$i]); ?></td>
                                        <td>
                                            <input type="radio" name="radEncargado" value="<?php echo $rows[USUARIO_ID][$i]; ?>"/>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
<!--                                    <tr>
                                        <th>
                                            Observacion
                                        </th>
                                        <td colspan="2" style=" height: 100px;" class="<?php echo $classDivProNac; ?>">
                                            <textarea id="txt" name="txt" maxlength="900" style=" width: 99.5%; height: 85%; "></textarea>
                                            Numero de caracteres: <label id="cantidadImpacto" style="color: red;"></label>
                                        </td>
                                    </tr>-->
                            </table>
                            <br>
                            <input type="submit" name="btnAsignar" value="Asignar"/>
                        </center>
                    </form>                    
                </center>
                <?php
                oci_close($connection);
                ?>



            </div>
        </div>
        <?php include ('layout/pie.php') ?>


    </body>
</html>