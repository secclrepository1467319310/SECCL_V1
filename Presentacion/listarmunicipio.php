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
        <link rel="shortcut icon" href="./images/iconos/favicon.ico" />
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

        <script language="javascript">

            function envia(num, nome) {

                opener.document.f1.documento.value = num;
                opener.document.f1.nombres.value = nome;
                close();
            }
        </script>

    </head>
    <body>
        <br></br>

        <center>
            <form action=""  enctype="multipart/form-data" name="form2">

                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                <br></br>
                <center>
                    <table id='demotable1'>

                        <thead><tr><th>Id Municipio</th><th>Municipio</th>
                            </tr></thead>
                        <tbody>
                        </tbody>
                        <?php
                        include("../Clase/conectar.php");
                        $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

//                        $q = $_POST['q'];
                        $q=$_GET["q"];


                        $query2 = ("SELECT * FROM MUNICIPIO WHERE ID_DEPARTAMENTO='$q'");
                        $statement2 = oci_parse($connection, $query2);
                        oci_execute($statement2);
                        while ($row = oci_fetch_array($statement2, OCI_BOTH)) { ?>
                        
                        <tr>
                            <td><?php print $row[ID_MUNICIPIO]; ?></td><td><a href="#" onclick="envia(<?php print $row[ID_MUNICIPIO]; ?>, '<?php print utf8_encode($row["NOMBRE_MUNICIPIO"]); ?>');"><?php print utf8_encode($row["NOMBRE_MUNICIPIO"]); ?><input type="hidden" name="nombre" id="nombre" value="<?php print utf8_encode($row["NOMBRE_MUNICIPIO"]); ?>" /></a></td>

                        </tr> <?php
                            
                            }
                            ?>
                    </table>
            </form>
        </center>
    </body>
</html>