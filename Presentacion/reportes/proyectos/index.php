<!DOCTYPE html>
<!--
    Liliana Galeano Cruz
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="jquery.js"></script>
        <script src="cargar_Listas.js"></script>
        <title>Reportes</title>
    </head>
    <body>
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
    </body>
</html>
