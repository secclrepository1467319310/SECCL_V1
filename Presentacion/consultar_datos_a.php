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
        <script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_consultar_datos_a.js"></script>
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
                <br>
                <center>
                    <form name="cons" id="cons" action="cons_candidato_a.php" method="post" >
                        <table>
                            <tr><th>Documento</th><td><input type="text" name="documento"></input></td></tr>
                        </table>
                        <br><input type="submit" name="Consultar" value="Consultar"></input>
                    </form>
                    <br><br>
                    <div id="resultado">
                        <?php
                        $id = $_GET["id"];
                        $documento = $_GET["documento"];
                        $nombre = $_GET["nombre"];
                        $pape = $_GET["pape"];
                        $sape = $_GET["sape"];
                       
                        if($id!=null){

                        ?>
                        <table>
                            <tr><td><label>ID </label></td><td><?php echo $id ?></td></tr>
                            <tr><td><label>Documento </label></td><td><?php echo $documento ?></td></tr>
                            <tr><td><label>Nombres </label></td><td><?php echo $nombre ?></td></tr>
                            <tr><td><label>Primer Apellido </label></td><td><?php echo $pape ?></td></tr>
                            <tr><td><label>Segundo Apellido </label></td><td><?php echo $sape ?></td></tr>
                            <tr><td><label>Consultar Ficha </label></td><td><a href="consultar_ficha.php?id=<?php echo $id ?>" target="blank">Consultar Datos</a></td></tr>
                            <tr><td><label>Modificar Ficha </label></td><td><a href="actualizar_ficha.php?id=<?php echo $id ?>" target="blank">Modificar Datos</a></td></tr>
                        </table>
                        <?php 
                        }
                        ?>
                    </div>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>