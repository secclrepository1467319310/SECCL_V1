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
<script type="text/javascript" language="JavaScript">
      function validar(){
        var form = document.f2;
        var total = 0;
        for(var i = 0; i < form.codigo.length; i++){
          //cuento la cantidad de input activos
          if(form.codigo[i].checked){
            total = total+1;
          }
        }  //cierre for
        if(total==2){
          for(i = 0; i < form.codigo.length; i++){
            //deshabilito el resto de checkbox
            if(!form.codigo[i].checked){
              form.codigo[i].disabled=true;
              form.insertar.disabled=false;
            }
          }
        }else{
          for(i = 0; i < form.codigo.length; i++){
            // habilito los checkbox cuando el total es menor que 3
            form.codigo[i].disabled=false;
            form.insertar.disabled=true;
          }
        }
        return false;
      } //cierre función
    </script>

    </head>
    <body onload="inicio()">
        <?php

        function restaFechas($dFecIni, $dFecFin) {
            $dFecIni = str_replace("-", "", $dFecIni);
            $dFecIni = str_replace("/", "", $dFecIni);
            $dFecFin = str_replace("-", "", $dFecFin);
            $dFecFin = str_replace("/", "", $dFecFin);

            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

            $date1 = mktime(0, 0, 0, $aFecIni[2], $aFecIni[1], $aFecIni[3]);
            $date2 = mktime(0, 0, 0, $aFecFin[2], $aFecFin[1], $aFecFin[3]);

            return round(($date2 - $date1) / (60 * 60 * 24));
        }
        ?>
 	<?php include ('layout/cabecera.php') ?>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito" style="height:600px;width:1010px;overflow:scroll;">
                <?php
                require_once("../Clase/conectar.php");
                
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                $ideva=$_GET['ideva'];
                
                
                ?>

                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>REGISTRO DE MESAS EN LAS QUE PUEDE EVALUAR</strong><br></br>
                    <strong> Certificación de Competencias Laborales</strong>
                    <br>
                    
                    <form name="f2" action="guardar_norma_evaluador.php" method="post">
                       <table>
                            <tr>
                                <th>Documento Evaluador</th>
                                <td><input name="ideva" type="text" size="1" readonly value="<?php echo $ideva ?>"></input></td>
                            </tr>
                        </table>
                        <br>
                        <strong>Por Favor Seleccione las Normas en las cuales es apto para evaluar</strong>
                        <br><br>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                                <br></br>
                                <center>
                                <br>
                                <strong>
                                </br>
                                <table id="demotable1" >
                                <thead><tr>
                                        <th><strong>Id Ncl</strong></th>
                                        <th><strong>Código Mesa</strong></th>
                                        <th><strong>Nombre Mesa</strong></th>
                                        <th><strong>Código Norma</strong></th>
                                        <th><strong>Versión Norma</strong></th>
                                        <th><strong>Título Norma</strong></th>
                                        <th><strong>Expiración Norma</strong></th>
                                        <th><strong>Seleccionar</strong></th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

                                <?php
                                
                                $query = "select UNIQUE
id_evaluador,
id_mesa,
nombre_mesa,
id_norma,
codigo_norma,
version_norma,
titulo_norma,
TO_CHAR(expiracion_norma,'dd/mm/yyyy') AS EXPIRACION_NORMA
from  evaluador_mesa ev
inner join mesa m 
on ev.id_mesa=m.codigo_mesa
inner join norma n
on ev.id_mesa=n.codigo_mesa
where ev.id_evaluador='$ideva'";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero=0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                    echo "<tr><td width=\"\"><font face=\"verdana\">" .
                                    $row["ID_NORMA"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["ID_MESA"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($row["NOMBRE_MESA"]) . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["CODIGO_NORMA"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["VERSION_NORMA"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["EXPIRACION_NORMA"] . "</font></td>";
                                    
                                    $date1 = $row["EXPIRACION_NORMA"];
                                    $date2 = date("d/m/y");

                                            // Compara Fechas

                                            $d = restaFechas($date2, $date1);

                                            if ($d > 195) {
                                                ?>
                                    <td width=""><input name="codigo[]" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                    
                                        <?php        
                                            } else if ($d <= 195) {
                                                //vuelve y juega el disabled
                                                ?>
                                    <td width=""><input name="codigo[]"  type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                    
                                    <?php
                                            }
                                    $numero++;
                                }
                                oci_close($connection);
                                ?>
                            </table>
                        <br></br>
                        <p><label>
                                <input type="submit" name="insertar"  id="insertar" value="Siguiente" />
                        </label></p>
                    </form>
                    
                </center>
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