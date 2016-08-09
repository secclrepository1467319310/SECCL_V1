<?php
$conexion = oci_connect("SENA", "admin", "localhost/XE");
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link type="text/css" href="css/html5reset-1.6.1.css" rel="stylesheet">
        <link type="text/css" href="css/estilo2.css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $sql = "select * from  ENCUESTA_LIVE WHERE ID_USUARIO = 1";
        $datos = oci_parse($conexion, $sql);
        oci_execute($datos);
        $numrows = oci_fetch_all($datos, $results);
        if ($numrows < 1) {
            ?>
            <div class="contenGeneralEncuLive">
                <form action="guardarEncuestaLive.php" method="post">
                    Le gustaria:<br><br>
                    Alternativa 1 Básico,Intermedio,Avanzado:<input type="radio" name="encuLive" value="1" required=""><br>
                    Alternativa 2 Junior,Senior,Master:<input type="radio" name="encuLive" value="2"><br>
                    <input type="hidden" value="1" name="idUsuario">
                    <input type="submit" value="Votar" class="btnEnviarEncuLive">
                </form>
            </div>
            <?php
        } else {
            
        }
        ?>

    </body>
</html>
