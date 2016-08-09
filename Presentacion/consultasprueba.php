<?php
session_start();
if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
    echo '<script>window.location = "../index.php"</script>';
}
?>
<!DOCTYPE HTML>
<html lang="es">
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
        <script src="../jquery/jquery-ui.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_cronograma_grupo.js"></script>
        <script src="js/val_cronograma_proyecto.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>

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
        <?php include ('layout/cabecera.php'); 
        require_once("../Clase/conectar.php");?>
        <div id="contenedorcito" >
            <center>
                <form method="post" action=""> 
                    <input name="consulta" type="hidden" value="1"/>
                    
                    <table>
                        <tr>
                            <td><label for="campos">Campos:</label></td>
                            <td><textarea type="text" name="campos" id="campos" ><?php echo $_POST["campos"];?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="tablas">Tablas(use join si es necesario):</label></td>
                            <td><textarea type="text" name="tablas" id="tablas"><?php echo $_POST["tablas"];?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="where">where(order by, group by):</label></td>
                            <td><textarea type="text" name="where" id="where"><?php echo $_POST["where"];?></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="EJECUTAR"></td>
                        </tr>
                    </table>
                </form>
            </center>
        </div>
        <center>
            <?php
                if($_POST["consulta"]=="1"){
                    
                    $consulta="SELECT ".$_POST["campos"]." FROM ".$_POST["tablas"];
                    $consulta=$_POST["where"]==""?$consulta:$consulta." WHERE ".$_POST["where"];
                    echo "<h3>Su consulta : ".$consulta."</h3>";
                    $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                    $query=$consulta;
                    $statement=oci_parse($connection, $query);
                    $result=oci_execute($statement);
                    $error= oci_error($statement);
                    
                    $querystructure='select column_name "Campo", data_type "Tipo de dato", 
                            data_length "Tamaño", nullable "Permite nulos"
                            from all_tab_columns 
                            where table_name = \''.strtoupper($_POST["tablas"]).'\'';
                    $statementstructure=oci_parse($connection, $querystructure);
                    oci_execute($statementstructure);
                    
                    echo "<h3>Estructura</h3>";
                    echo "<table>";
                    echo "<tr>"
                    . "<th>Campos:</th>"
                    . "<th>Tipo de dato:</th>"
                    . "<th>Tamaño:</th>"
                    . "<th>Permite nulos:</th>"                    
                    . "</tr>";
                    while($restucture=  oci_fetch_array($statementstructure,OCI_ASSOC)){
                        echo "<tr><td>".$restucture["Campo"]."</td>";
                        echo "<td>".$restucture["Tipo de dato"]."</td>";
                        echo "<td>".$restucture["Tamaño"]."</td>";
                        echo "<td>".$restucture["Permite nulos"]."</td></tr>";
                        
                    }
                    echo "</table>";
                    if($error){
                        echo "<h3>Errores</h3>";
                        echo "<table>";
                        echo "<tr><td>Codigo de error: </td><td>".$error["code"]."</td></tr>";
                        echo "<tr><td>Mensaje de error: </td><td>".$error["message"]."</td></tr>";
                        echo "</table>";
                    }
                    if($result){
                        echo "<h3>Datos</h3>";
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>N° de fila</th>";
                        for ($i=1; $i <= oci_num_fields($statement); $i++) { 
                            echo "<th>".oci_field_name($statement,$i)."</th>";
                        }
                            echo "</tr>";
                        $nfila=1;
                        while ($row=oci_fetch_array($statement,OCI_NUM)) {
                            echo "<tr>";
                            echo "<td><font color='blue'>$nfila</font></td>";
                            for ($i=0; $i < oci_num_fields($statement); $i++) { 
                                # code...
                                
                                echo "<td>".utf8_encode($row[$i])."</td>";
                            }
                                echo "</tr>";
                            $nfila++;
                        }                        
                        echo "</table>";
                    }
                }

            ?>
        </center>
        <?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>