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
            <center><h1>Soportes Portafolio Evidencias</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $plan = $_GET['idplan'];
            ?>
            <?php if ($_GET['mensaje'] == 1) { ?>
                <div class="mensaje">La actualización se realizo Correctamente. </div>
            <?php } elseif ($_GET['mensaje'] == 2) { ?>
                <div class="error">No es posible realizar la actualización, debido a que el candidato ya esta certificado en esta norma. </div>
            <?php } ?>
<!--            <form class='proyecto' name="formmapa" action="guardar_soporte.php?plan=<?php echo $plan ?>" method="post" accept-charset="UTF-8" enctype="multipart/form-data" >
                <center>
                    <fieldset>
                        <legend><strong>Cargar Evidencias</strong></legend>
                        <table>
                        <tr><th>Tipo Documento</th>
                            <td><Select Name="tipodoc" >

                                <?PHP
                                
//                                $query2 = ("select * 
//                                FROM TIPO_DOC_PORTAFOLIO 
//                                WHERE (ID_TDOC_PORTAFOLIO NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29))");
//                                $statement2 = oci_parse($connection, $query2);
//                                oci_execute($statement2);
//                                while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
//                                    $id_td = $row["ID_TDOC_PORTAFOLIO"];
//                                    $doc = $row["NOMBRE_DOCUMENTO"];
//
//                                    echo "<OPTION value=" . $id_td . ">", utf8_encode($doc), "</OPTION>";
//                                }
                                ?>

                            </Select></td></tr>
                        <tr><th>Id Candidato</th><td><input type="text" readonly="readonly" name="idca" value="<?php echo $_GET['idca'] ?>" ></td></tr>
                        <tr><th>Id Norma</th><td><input type="text" readonly="readonly" name="norma" value="<?php echo $_GET['norma'] ?>" ></td></tr>
                        <tr><th>Id Proyecto</th><td><input type="text" readonly="readonly" name="proyecto" value="<?php echo $_GET['proyecto'] ?>" ></td></tr>
                        <tr><th>Grupo</th><td><input type="text" readonly="readonly" name="grupo" value="<?php echo $_GET['grupo'] ?>" ></td></tr>
                        <tr><th>Descripción</th><td><input type="text" name="lob_description"></td></tr>
                        <tr><th>Seleccionar archivo</th><td><input type="file" name="lob_upload"><br><br></td></tr>
                         <tr><td></td><td><input type="submit" value="Subir Documento"> - <input type="reset"></td></tr>
                    </table>
                        <br></br>
                        <p><label>
                            <input type = "submit" name = "insertar" id = "insertar" value = "Guardar" accesskey = "I" />
                            <br></br>
                            <a href = "listar_emision_ev.php?idplan=<?php echo $plan ?>"> Volver </a>
                        </label></p>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Listado de Documentos</strong></legend><br>
                        <center><strong>Portafolio Evidencias</strong></center>
                <br></br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                            <br></br>
                <center>
                    <table border="1" id="demotable1">
    <thead><tr>
            <th><strong>ID</strong></th>
            <th><strong>TIPO DE DOCUMENTO</strong></th>
            <th><strong>DESCRIPCION</strong></th>
            <th><strong>NOMBRE ARCHIVO (en el Servidor)</strong></th>
            <th><strong>VER</strong></th>
            <th></th>
        </tr></thead>
    <tbody>
    </tbody>
    <?php
//    $idca=$_GET['idca'];
//    $proyecto=$_GET['proyecto'];
//    $grupo=$_GET['grupo'];
//    $norma=$_GET['norma'];
//    $query = "SELECT 
//    ID_PORTAFOLIO_EVIDENCIAS,
//    NOMBRE_DOCUMENTO,
//    DESCRIPCION,
//    FILENAME
//    FROM PORTAFOLIO_EVIDENCIAS P
//    INNER JOIN TIPO_DOC_PORTAFOLIO TP
//    ON P.TIPO_DOCUMENTO=TP.ID_TDOC_PORTAFOLIO
//    WHERE ID_PROYECTO='$proyecto' AND ID_NORMA='$norma' AND GRUPO='$grupo' AND ID_CANDIDATO='$idca'";
//    $statement = oci_parse($connection, $query);
//    oci_execute($statement);
//
//    $numero = 0;
//    while ($row = oci_fetch_array($statement, OCI_BOTH)) {
//        
//        echo "<tr><td width=\"\"><font face=\"verdana\">" .
//        $row["ID_PORTAFOLIO_EVIDENCIAS"] . "</font></td>";
//        echo "<td width=\"\"><font face=\"verdana\">" .
//        utf8_encode($row["NOMBRE_DOCUMENTO"]) . "</font></td>";
//        echo "<td width=\"\"><font face=\"verdana\">" .
//        utf8_encode($row["DESCRIPCION"]) . "</font></td>";
//        echo "<td width=\"\"><font face=\"verdana\">" .
//        utf8_encode($row["FILENAME"]) . "</font></td>";
//        echo "<td width=\"\"><a href=\"file_evid.php?id=" . $row["ID_PORTAFOLIO_EVIDENCIAS"] . "\" TARGET=\"_blank\">
//        Ver</a></td>";
//        echo "<td><a href='eliminar_portafolio.php?portafolio=$row[ID_PORTAFOLIO_EVIDENCIAS]&documento=4&proyecto=$proyecto&plan=$plan&norma=$norma&candidato=$idca&grupo=$grupo'>Eliminar</a></td></tr>";
//
//
//        $numero++;
//    }
//    oci_close($connection);
    ?>
</table>
                </center>
                <br></br>
                    </fieldset>
                </center>
            </form>-->
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