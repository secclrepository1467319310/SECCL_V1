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
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_centros_proyecto_nacional.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="js/cargar_datos_proyectos_nacionales.js" type="text/javascript"></script>
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
                <center>
                    <form id="frmCentrosProyectoNacional" action="guardar_normas_proyecto_nacional.php" method="post">
                        <input type="hidden" name="proNac" value="<?php echo $_GET[proNac]; ?>"
                               <label id="valError"></label>
                        <center>
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
                        </center><br></br>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>