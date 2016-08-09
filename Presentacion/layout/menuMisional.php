<div id="menu">
    <ul id="nav">
        <li class="top"><a href="../Presentacion/menumisional.php" class="top_link"><span>Inicio</span></a>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Planeación</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/actas.php">Actas</a></li>
                <?php if ($id == 22951) { ?>
                    <li><a href="../Presentacion/areas_claves_cm.php">Áreas Claves</a></li>
                <?php } ?>
                <li><a href="../Presentacion/asignar_auditor_cm.php">Asignar Auditor</a></li>
                <li><a href="../Presentacion/meta_centro.php">Metas Centros</a></li>
            </ul>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Staff</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/instrumentadores_c.php">Instrumentadores</a></li>
                <li><a href="../Presentacion/auditores_regionales.php">Auditores Regionales</a></li>
                <li><a href="../Presentacion/apoyos_regionales.php">Apoyos Regionales</a></li>
            </ul>
        </li>
        <li class="top">
            <a href="#" class="top_link" ><span>Reportes</span></a>
            <ul class="sub" style="width: 165px">
<!--                <li><a href="../Presentacion/reporteregional_ins_cert.php" target="_blank">Inscritos y Certificados Regional</a></li>
                <li><a href="../Presentacion/areas_claves_nacionales.php" target="_blank">Areas Claves Nacionales</a></li>-->
                <li><a href="../Presentacion/reportes_misional.php">Reportes descargables</a></li>
            </ul>
        </li>
        <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>
    </ul>
</div>