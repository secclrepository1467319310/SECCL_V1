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
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_crear_grupo.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {

                if ($("[name='seg_intento[]']").length) {
                    $("[name='usuario[]']").on("change", function() {
//                        alert(this.checked);
                        if (this.checked) {
                            $("[name='seg_intento[]']", $(this).parent().parent()).prop("disabled", false)
                        } else {

                            $("[name='seg_intento[]']", $(this).parent().parent()).prop("disabled", true)

                        }
                    })
                }
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
        <script language="javascript">
            function validar()
            {
                while (!document.f2.evaluador.checked)
                {
                    window.alert("Seleccione un Evaluador");
                    return false;
                }

                while (!document.f2.usuario.checked)
                {
                    window.alert("Seleccione Candidatos");
                    return false;
                }

            }
        </script>

    </head>
    <body onload="inicio()">
<?php include ('layout/cabecera.php') ?>
        <div id="contenedorcito" >
            <br>
            <center><h1>Creación de Grupos</h1></center>
<?php
require_once("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$proyecto = $_GET['proyecto'];
$idnorma = $_GET['norma'];

$query34 = ("  SELECT n.codigo_norma,reg.codigo_norma "
        . "      FROM norma n "
        . " LEFT JOIN t_normas_reguladas reg "
        . "        ON n.codigo_norma= reg.codigo_norma"
        . "     WHERE n.id_norma='$idnorma'");
$statement34 = oci_parse($connection, $query34);
$resp34 = oci_execute($statement34);
$norma = oci_fetch_array($statement34, OCI_BOTH);


$query35 = ("select max(n_grupo) from proyecto_grupo where id_proyecto='$proyecto' and id_norma='$idnorma'");
$statement35 = oci_parse($connection, $query35);
$resp35 = oci_execute($statement35);
$grupo = oci_fetch_array($statement35, OCI_BOTH);
$g = $grupo[0] + 1;
$f = date('d/m/Y');

$queryAuto = "SELECT * FROM T_NOVEDADES_GRUPOS WHERE ID_PROYECTO=$proyecto AND N_GRUPO=$g AND ID_NORMA=$idnorma AND ESTADO_REGISTRO = 1 AND TIPO_NOVEDAD=2";
$statementAuto = oci_parse($connection, $queryAuto);
oci_execute($statementAuto);
$numAuto = oci_fetch_all($statementAuto, $rowAuto);
$qNovedadMin6Can= "SELECT * FROM T_NOVEDADES_GRUPOS WHERE ID_PROYECTO=$proyecto AND N_GRUPO=$g AND ID_NORMA=$idnorma AND ESTADO_REGISTRO = 1 AND TIPO_NOVEDAD=4";
$sNovedadMin6Can = oci_parse($connection, $qNovedadMin6Can);
oci_execute($sNovedadMin6Can);
$nNovedadMin6Can = oci_fetch_all($sNovedadMin6Can, $rNovedadMin6Can);
?>
            <form class='proyecto' id='f2'  name="f2" action="guardar_grupo.php?idnorma=<?php echo $idnorma; ?>" method="post">
                <input type="hidden" name="auto_grupo" id="auto_grupo" value="<?php echo $numAuto ?>" />
                <input type="hidden" name="auto_grupo2" id="auto_grupo2" value="<?php echo $nNovedadMin6Can ?>" />
                <!--onsubmit="return validar()"-->
                <center>
                    <fieldset>
                        <legend><strong>Información General del Grupo</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th><strong>Proyecto</strong></th>
                                <td><input name="proyecto" type="text" readonly="readonly" value="<?php echo $proyecto ?>" ></td>
                                <th><strong>Norma</strong></th>
                                <td><input name="norma" type="text" readonly="readonly" value="<?php echo $norma[0] ?>" ></td>
                            </tr>
                            <tr>
                                <th><strong>Fecha</strong></th>
                                <td><input name="fecha" type="text" readonly="readonly" value="<?php echo $f ?>" ></td>
                                <th><strong>Grupo N°</strong></th>
                                <td><input name="grupo" type="text" readonly="readonly" value="<?php echo $g ?>" ></td>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Asignar Evaluador</strong></legend>
                        <table>
                            <tr>
                                <th>Documento</th>
                                <th>Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Nombre</th>
                                <th>Seleccionar</th>

                            </tr>
<?php
$query1 = ("select id_evaluador from evaluador_proyecto where id_proyecto='$proyecto' and id_norma='$idnorma'");
$statement1 = oci_parse($connection, $query1);
oci_execute($statement1);
$numero3 = 0;
$numero2 = 0;
while ($row3 = oci_fetch_array($statement1, OCI_BOTH)) {
    $query2 = "SELECT USUARIO_ID,DOCUMENTO,PRIMER_APELLIDO,SEGUNDO_APELLIDO,NOMBRE FROM USUARIO WHERE DOCUMENTO='$row3[ID_EVALUADOR]'";
    $numero3++;

    $statement2 = oci_parse($connection, $query2);
    oci_execute($statement2);
    while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
        ?>                                    
                                    <tr>
                                        <td><?php echo $row["DOCUMENTO"]; ?></td>
                                        <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
        <?php
        $query11 = ("select count(*) from proyecto_grupo where id_evaluador='$row[USUARIO_ID]' and id_norma='$idnorma' and id_proyecto='$proyecto'");
        $statement11 = oci_parse($connection, $query11);
        $resp11 = oci_execute($statement11);
        $control = oci_fetch_array($statement11, OCI_BOTH);
//                                    if ($control[0] == 0) {
//                                        
        ?>
                                        <td><input name="evaluador" type="radio" value="<?php echo $row["USUARIO_ID"]; ?>"><br /></input></td>
                                        <?php
//                                    } else {
//                                        
                                        ?>

                                        <!--<td><input name="evaluador"  type="radio" value="//<?php echo $row["USUARIO_ID"]; ?>"><br /></input></td>-->
                                        <?php
//                                    }
//                                    
                                        ?>
                                    </tr>
                                        <?php
                                        $numero2++;
                                    }
                                }
                                ?>
                        </table>

                    </fieldset>
                    <br>
                    <div style="font-weight: bold; font-size: 16px; color:red"><label class='errorVal'>
<?php
if ($_GET['error'] == 1) {
    if ($numAuto > 0) {
        $minimo = 10;
    } else {
        $minimo = 20;
    }
    echo "El grupo debe tener como Mínimo" . $minimo . "candidatos y Máximo 40";
}
?>

                        </label></div>
                    <fieldset>
                        <legend><strong>Asociar Candidatos</strong></legend>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br></br>
                        <center>
                            <table id="demotable1" >
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Documento</th>
                                        <th>Apellido</th>
                                        <th>Segundo Apellido</th>
                                        <th>Nombre</th>
                                        <th>Seleccionar</th>
<?php if ($norma[1]) { ?>
                                            <th>Seleccione los candidatos que participarán por INTENTO</th>
<?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
<?php
$query = "SELECT 
ID_CANDIDATO,
DOCUMENTO,
PRIMER_APELLIDO,
SEGUNDO_APELLIDO,
NOMBRE,
USUARIO_ID
FROM USUARIO U
INNER JOIN CANDIDATOS_PROYECTO PY
ON PY.ID_CANDIDATO=U.USUARIO_ID
WHERE PY.ID_PROYECTO='$proyecto' AND PY.ID_NORMA='$idnorma'
ORDER BY PRIMER_APELLIDO ASC";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$numero = 0;
while ($row = oci_fetch_array($statement, OCI_BOTH)) {
    ?>

                                    <tr>
                                        <td><?php echo $numero + 1; ?></td>
                                        <td><?php echo $row["DOCUMENTO"]; ?></td>
                                        <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                    <?php
                                    $query11 = ("select count(*) from proyecto_grupo where id_candidato='$row[USUARIO_ID]' and id_proyecto='$proyecto' and id_norma='$idnorma'");
                                    $statement11 = oci_parse($connection, $query11);
                                    $resp11 = oci_execute($statement11);
                                    $control = oci_fetch_array($statement11, OCI_BOTH);
                                    $disabled = "";
                                    if ($control[0] == 0) {
                                        ?>
                                            <td><input name="usuario[]" type="checkbox" value="<?php echo $row["USUARIO_ID"]; ?>"><br /></input></td>
                                            <?php
                                        } else {
                                            $disabled = "disabled";
                                            ?>
                                            <td><input name="usuario[]" disabled="disabled" type="checkbox" value="<?php echo $row["USUARIO_ID"]; ?>"><br /></input></td>
                                            <?php
                                        }
                                        ?>
                                        <?php if ($norma[1]) { ?>
                                            <td><input disabled type="checkbox" name="seg_intento[]" value="<?= $row["USUARIO_ID"] ?>"></td>
                                        <?php } ?>
                                    </tr><?php
                                        $numero++;
                                    }
                                    ?>

                            </table>

                    </fieldset>
                    <br>
                    <br></br>
                    <p><label>
                                    <?php // var_dump($numero2); ?>
                                    <?php if ($numero2 > 0) { ?>
                                <input type="submit"  name="insertar"  id="insertar" value="Crear" />
                                <?php } else { ?>
                                No ha seleccionado un evaluador para este grupo
                                <?php } ?>
                        </label></p>
                    <br></br>
                </center>
            </form>
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