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
        <script type="text/javascript" src="js/val_registrar_constructor_c.js"></script>

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
                    <center><strong>Registro de Constructores de Ítems del Proyecto</strong></center>
                </br>

                <form name="formmapa" id="f1" action="guardar_constructor_c.php?proyecto=<?php echo $proyecto ?>" 
                      method="post" accept-charset="UTF-8" enctype="multipart/form-data" >

                    <center><table id='demotable1'>
                                <tr><th>Documento</th><td><input type="text" name="documento" onKeyPress="return validar(event)"/></td></tr>
                                <tr><th>Nombres</th><td><input type="text" name="nombres" size="50"  /></td></tr>
                                <tr><th>Primer Apellido</th><td><input type="text" name="pri_apellido" size="50"  /></td></tr>
                                <tr><th>Segundo Apellido</th><td><input type="text" name="seg_apellido" size="50"  /></td></tr>
                                <tr><th>Email</th><td><input type="text" name="email" /></td></tr>
                                <tr><th>Email Personal</th><td><input type="text" name="email2" size="50"  /></td></tr>
                                <tr><th>Celular</th><td><input type="text" name="cel" onKeyPress="return validar(event)"/></td></tr>
                                <tr><th>Teléfono</th><td><input type="text" name="tel" onKeyPress="return validar(event)"/></td></tr>
                                
                        </table></center>

                    <br></br>
                    <center>
                        <p><label>
                                <a href="cronogramai_proyecto_c.php?proyecto=<?php echo $proyecto ?>"> Volver     </a>
                                <br></br>
                                <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I" />
                            </label></p>

                </form>
                <div>

                </div>
                <br></br>
                <form>
                    <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Email SENA</th>
                                <th>Email Personal</th>
                                <th>Celular</th>
                                <th>Teléfono</th>
                                
                        </tr>
                        <?php
                        $query = "SELECT * FROM CONSTRUCTOR_ITEMS WHERE ID_PROYECTO='$proyecto'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr>
                                <td><?php echo $row["DOCUMENTO"]; ?></td>
                                <td><?php echo $row["NOMBRE"]; ?></td>
                                <td><?php echo $row["PRIMER_APELLIDO"]; ?></td>
                                <td><?php echo $row["SEGUNDO_APELLIDO"]; ?></td>
                                <td><?php echo $row["CORREO"]; ?></td>
                                <td><?php echo $row["CORREO2"]; ?></td>
                                <td><?php echo $row["CELULAR"]; ?></td>
                                <td><?php echo $row["TELEFONO"]; ?></td>
                                

                            </tr>


                            <?php
                            $numero++;
                        }
                        
                        ?>
                    </table><br></br>
                </form>
            </div>
        <div class="space">&nbsp;</div>
 	<?php include('layout/pie.php'); ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>