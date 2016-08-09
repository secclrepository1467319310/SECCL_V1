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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

    <!--        CREDITOS  CREDITS
    Plantilla modificada por: Jhonatan Andres Garnica Paredes
    Requerimiento: Adaptación imagen corporativa.
    Direccion de Sistema - SENA, Dirección General
    última actualización Octubre /2012
    !-->

    <head>
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
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
            function numeros(e) {
                key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toLowerCase();
                letras = " 0123456789";
                especiales = [8, 37, 39, 46];

                tecla_especial = false
                for (var i in especiales) {
                    if (key == especiales[i]) {
                        tecla_especial = true;
                        break;
                    }
                }

                if (letras.indexOf(tecla) == -1 && !tecla_especial)
                    return false;
            }

        </script>

    </head>
    <body>
        <div id="">


            <?php
            include("../Clase/conectar.php");
            $connection2 = conectar($bd_host, $bd_usuario, $bd_pwd);
            ?>
        </div>

        <div id="" >
            <a id="cleanfilters" href="#">Limpiar Filtros</a>   ||   <a href="expObsAses.php">Exportar a Excel<img src="../images/excel.png" width="26" height="26"></img></a>
            <table id='demotable1'>
                <thead>
                    <tr>
                        <th>ID PROYECTO</th>
                        <th>EMPRESA</th>
                        <th>DESCRIPCION</th>
                        <th>FECHA REGISTRO</th>
                        <th>ASESOR</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <?php
                $query2 = "SELECT ES.NIT_EMPRESA, ES.NOMBRE_EMPRESA, OP.ID_PROYECTO, OP.DESCRIPCION, OP.FECHA_REGISTRO, USU.NOMBRE AS NOMBRE "
                        . "FROM T_OBSER_PROY_ASES OP INNER JOIN USUARIO USU "
                        . "ON OP.USU_REGISTRO = USU.USUARIO_ID "
                        . "INNER JOIN PROYECTO PY "
                        . "ON PY.ID_PROYECTO = OP.ID_PROYECTO "
                        . "LEFT JOIN EMPRESAS_SISTEMA ES "
                        . "ON ES.NIT_EMPRESA = PY.NIT_EMPRESA";
                $statement2 = oci_parse($connection2, $query2);
                oci_execute($statement2);
                $num = 0;
                while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                    ?>
                    <tr>
                        <td><a href="verdetalles_proyecto_c_b2.php?proyecto=<?php echo $row2['ID_PROYECTO'] ?>" target="_blank"><?php echo $row2['ID_PROYECTO'] ?></a></td>
                        <td>
                            <?php
                            if ($row2['NIT_EMPRESA'] != NULL) {
                                echo utf8_encode($row2['NOMBRE_EMPRESA']);
                            }else{
                                echo 'Demanda Social';
                            }
                            ?>
                        </td>
                        <td><?php echo $row2['DESCRIPCION'] ?></td>
                        <td><?php echo $row2['FECHA_REGISTRO'] ?></td>
                        <td><?php echo $row2['NOMBRE'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <?php
        oci_close($connection2);
        ?>
    </body>
</html>
