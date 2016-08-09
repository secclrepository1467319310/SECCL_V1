<!DOCTYPE html>
<!--
    Liliana Galeano Cruz
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="jquery.js"></script>
        <script src="cargar_Listas.js"></script>
        <link rel="stylesheet" type="text/css" href="../../../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/tabla.css" />
        <title>Reportes</title>
    </head>
    <body onload="inicio()">
        <?php include ('../../layout/cabecera.php') ?>
        <form action="envioDatos.php" method="POST">
            <a>2006</a><input type="checkbox" value="2006" name="chkPeriodo[]"/>
            <a>2007</a><input type="checkbox" value="2007" name="chkPeriodo[]"/>
            <a>2008</a><input type="checkbox" value="2008" name="chkPeriodo[]"/>
            <a>2009</a><input type="checkbox" value="2009" name="chkPeriodo[]"/>
            <a>2010</a><input type="checkbox" value="2010" name="chkPeriodo[]"/>
            <a>2011</a><input type="checkbox" value="2011" name="chkPeriodo[]"/>
            <a>2012</a><input type="checkbox" value="2012" name="chkPeriodo[]"/>
            <a>2013</a><input type="checkbox" value="2013" name="chkPeriodo[]"/>
            <a>2014</a><input type="checkbox" value="2014" name="chkPeriodo[]"/>
            <a>2015</a><input type="checkbox" value="2015" name="chkPeriodo[]"/>
            <a>2016</a><input type="checkbox" value="2016" name="chkPeriodo[]"/>
            <br>
            <br>
            <select name="ddlEmpresa">
                <option value="-1">Seleccione..</option>
                <option value="1">Alianza</option>
                <option value="2">Demanda social</option>
            </select>
            <br>
            <br>
            <a>Regional</a><input type="checkbox" id="regional" value="regional" name="chkRegional"/>
            <div class="divRegional">

            </div>
            <br>
            <a>Centro</a><input type="checkbox" id="centro" value="centro" name="chkCentro"/>
            <div class="divCentro">

            </div>
            <br>
            <a>Mesa</a><input type="checkbox" id="mesa" value="mesa" name="chkMesa"/>
            <div class="divMesa">

            </div>
            <br>
            <a>Norma</a><input type="checkbox" id="norma" value="norma" name="chkNorma"/>
            <div class="divNorma">

            </div>
            <br>
            <input type="submit" value="generar">
        </form>
        <div class="space">&nbsp;</div>
        <?php include ('../../layout/pie.php') ?>

        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en lí­nea" title="Pagos en lí­nea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>
