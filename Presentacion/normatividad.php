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
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

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

        <script>
            function aMayusculas(obj, id) {
                obj = obj.toUpperCase();
                document.getElementById(id).value = obj;
            }
        </script>

    </head>
    <body onload="inicio()">
        <div id="flotante">
            <input type="button" value="X" onclick="cerrar('flotante')"
                   class="boton_verde2"></input> Se recomienda el uso de Google Chrome
            para una correcta visualizaci&oacute;n. Para descargarlo haga clic <a
                href="https://www.google.com/intl/es/chrome/browser/?hl=es"
                target="_blank">aqu&iacute;</a>
        </div>
        <div id="top">
            <div class="total" style="background:url(../_img/bck.header.jpg) no-repeat; height:40px;">
                <div class="min_space">&nbsp;</div>
                <div class="float_right" style="margin-right:20px;">
                    <a href="https://twitter.com/senacomunica" rel="external"><img src="../_img/rs.twitter.jpg" alt="SENA en Twiiter" /></a>&nbsp;
                    <a href="http://www.facebook.com/sena.general" rel="external"><img src="../_img/rs.facebook.jpg" alt="SENA en Facebook" /></a>&nbsp;
                    <a href="https://plus.google.com/111618152086006296623/posts" rel="external"><img src="../_img/rs.googleplus.jpg" alt="SENA en Google+" /></a>&nbsp;
                    <a href="http://pinterest.com/SENAComunica/" rel="external"><img src="../_img/rs.pinterest.jpg" alt="SENA en Pinterest" /></a>&nbsp;
                </div>		
            </div>
        </div>
        <div id="header" class="bck_lightgray">
            <div class="total">
                <a href="../index.php"><img src="../_img/header.jpg"/></a>
                <div class="total" style="background-image:url(../_img/bck.header2.jpg); height:3px;"></div>
                <div id="menu">
                    <ul id="nav">
                        <li class="top"><a href="../index.php" class="top_link"><span>Inicio</span></a></li>
                        <li class="top"><a href="./que.php" class="top_link"><span>¿Qué es CCL?</span></a></li>
                        <li class="top"><a href="./principios.php" class="top_link top_link"><span>Principios y Características ECCL</span></a></li>
                        <li class="top"><a href="./normatividad.php" class="top_link top_link"><span>Normatividad </span></a></li>
                        <li class="top"><a href="./instrumentos.php" class="top_link top_link"><span>Catálogo de Instrumentos</span></a></li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Consultar</span></a>
                        <ul class="sub">
                                        <li><a href="./oferta.php">Oferta</a></li>
                                        <li><a href="http://certificados.sena.edu.co" target="blank">Certificados</a></li>
                                        <li><a href="./memorias.php">Documentos</a></li>
                        </ul>
                        </li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Atención al Ciudadano</span></a>
                            <ul class="sub">
                                <li><a href="http://sciudadanos.sena.edu.co/SolicitudIndex.aspx" target="blank">PQRSF</a></li>
                                <li><a href="./contacto.php">Contáctenos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div></div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div class="total" style="height: 680px;">
            <strong>Normatividad del Proceso de Evaluación y Certificación de Competencias Laborales</strong>
            <br></br>
            <form style="height:600px;width:1050px;overflow:scroll;">
            <table>
                <tr><th>Descripción</th><th>Descarga</th></tr>
                <tr>    
                    <td>Manual de Identidad Corporativa</td><td><a href="Documentos/Manual de Identidad Corporativa SENA 2013 vigente.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>
                    <th>Acuerdos</th><th>Descarga</th>
                </tr>
                <tr>    
                    <td>Acuerdo 006 de 2010 Por el cual se reglamentan la Conformación, Proceso de Selección y Funciones de las Mesas Sectoriales.</td><td><a href="Documentos/Normatividad/Acuerdos a publicar SECCL/Acuerdo 6 de 2010 Por el cual se reglamentan la Conformación, Proceso de Selección y Funciones de las Mesas Sectoriales..pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>
                    <th>Documentos Conpes</th><th>Descarga</th>
                </tr>
                <tr>    
                    <td>CONPES 81 DE 2004 consolidación del Sistema Nacional de Formación Para el Trabajo.</td><td><a href="Documentos/Normatividad/Conpes a publicar SECCL/CONPES 3674 Lineamientos de política para el fortalecimiento del Sistema de Formación de Capital Humano (SFCH).pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>CONPES 3674 Lineamientos de política para el fortalecimiento del Sistema de Formación de Capital Humano (SFCH)</td><td><a href="Documentos/Normatividad/Conpes a publicar SECCL/CONPES 81 DE 2004 consolidación del Sistema Nacional de Formación Para el Trabajo.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>conpes_2945.</td><td><a href="Documentos/Normatividad/Conpes a publicar SECCL/conpes_2945.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>
                    <th>Decretos</th><th>Descarga</th>
                </tr>
                <tr>    
                    <td>Decreto 933 de 2003 Por medio del cual se reglamenta el Contrato de Aprendizaje y se dictan otras disposiciones.</td><td><a href="Documentos/Normatividad/Decretos a publicar SECCL/DECRETO 2364 DEL 22 DE NOVIEMBRE DE 2012 . Por medio del cual se reglamenta el artículo 7 de la Ley 527 de 1999, sobre la firma electrónica y se dictan otras dispos.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>DECRETO 2364 DEL 22 DE NOVIEMBRE DE 2012 . Por medio del cual se reglamenta el artículo 7 de la Ley 527 de 1999, sobre la firma electrónica y se dictan otras dispos</td><td><a href="Documentos/Normatividad/Decretos a publicar SECCL/Decreto 933 de 2003 Por medio del cual se reglamenta el Contrato de Aprendizaje y se dictan otras disposiciones..pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>Decreto249_SENA por el cual se modifica la estructura del Servicio Nacional de Aprendizaje, SENA.</td><td><a href="Documentos/Normatividad/Decretos a publicar SECCL/Decreto249_SENA por el cual se modifica la estructura del Servicio Nacional de Aprendizaje, SENA..pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>
                    <th>OIT</th><th>Descarga</th>
                </tr>
                <tr>    
                    <td>La Recomendación 195 de 2004</td><td><a href="Documentos/Normatividad/Documentos OIT a publicar SECCL/La Recomendación 195 de 2004.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>
                    <th>Leyes</th><th>Descarga</th>
                </tr>
                <tr>    
                    <td>L0734_02  Por el cual se expide el Código único Disciplinario</td><td><a href="Documentos/Normatividad/Leyes a publicar SECCL/L0734_02  Por el cual se expide el Código único Disciplinario.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>LEY 962 DE 2005por la cual se dictan disposiciones sobre racionalización de trámites y procedimientos administrativos de los organismos y entidades del Estado y de los</td><td><a href="Documentos/Normatividad/Leyes a publicar SECCL/LEY 962 DE 2005por la cual se dictan disposiciones sobre racionalización de trámites y procedimientos administrativos de los organismos y entidades del Estado y de los.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>LEY 1098 DE 2006</td><td><a href="Documentos/Normatividad/Leyes a publicar SECCL/LEY 1098 DE 2006.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>ley_527_1999</td><td><a href="Documentos/Normatividad/Leyes a publicar SECCL/ley_527_1999.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>    
                    <td>LEY_872_DE_2003</td><td><a href="Documentos/Normatividad/Leyes a publicar SECCL/LEY_872_DE_2003.pdf" target="blank"><img src="../images/btnDescargar.gif"></img></a></td>
                </tr>
                <tr>
                    <th>NTGC y Normas ISO</th><th>Descarga</th>
                </tr>
                <tr>    
                    <td>Auditoría Interna de Gestión - ISO-19011-2011</td><td><a href="Documentos/Normatividad/NTGC y normas ISO a publicar SECCL/Auditoría Interna de Gestión - ISO-19011-2011.pdf" target="blank"></a></td>
                </tr>
                <tr>    
                    <td>IS0 17024 DE 2003</td><td><a href="Documentos/Normatividad/NTGC y normas ISO a publicar SECCL/IS0 17024 DE 2003.pdf" target="blank"></a></td>
                </tr>
                <tr>    
                    <td>ISO-9001-2008</td><td><a href="Documentos/Normatividad/NTGC y normas ISO a publicar SECCL/ISO-9001-2008.pdf" target="blank"></a></td>
                </tr>
                <tr>    
                    <td>ISO-17000-2005-</td><td><a href="Documentos/Normatividad/NTGC y normas ISO a publicar SECCL/ISO-17000-2005-.pdf" target="blank"></a></td>
                </tr>
                <tr>    
                    <td>NTCGP 1000 2009</td><td><a href="Documentos/Normatividad/NTGC y normas ISO a publicar SECCL/NTCGP 1000 2009.pdf" target="blank"></a></td>
                </tr>
                
            </table>
            </form>
        </div>
        <div class="espacio">&nbsp;</div>
    </div>
    <div class="space">&nbsp;</div>
    <div class="total"><div class="linea_horizontal">&nbsp;</div></div>
    <div class="space">&nbsp;</div>
    <div class="min_space">&nbsp;</div>
    <div class="total" style="border-top: 2px solid #888;">
        <table align="right">
            <tr class="font14 bold">
                <td rowspan="2">
                    <a href="http://wsp.presidencia.gov.co" title="Gobierno de Colombia" rel="external"><img src="../_img/links/gobierno.jpg" alt="logo Gobierno de Colombia" /></a> &nbsp; 
                </td>
                <td>
                    <a href="http://mintrabajo.gov.co/" title="Ministerio de Trabajo" rel="external"><img src="../_img/links/mintrabajo.jpg" alt="logo Ministerio de Trabajo" /></a> &nbsp; 
                </td>
            </tr>
            <tr>
                <td>
                    <a href="http://www.mintic.gov.co/" title="Ministerio de Tecnologías de la Información y las Comunicaciones" rel="external"><img src="../_img/links/mintic.jpg" alt="logo Ministerio de Tecnologías de la Información y las Comunicaciones" /></a>
                </td>
            </tr>
        </table>
        <div class="space">&nbsp;</div>
    </div>

    <div class="bck_orange">
        <div class="space">&nbsp;</div>
        <div class="total center white">
            Última modificación 08/04/2013 4:00 PM<br /><br />
            .:: Servicio Nacional de Aprendizaje SENA – Dirección General Calle 57 No. 8-69, Bogotá D.C - PBX (57 1) 5461500<br />
            Línea gratuita de atención al ciudadano Bogotá 5925555 – Resto del país 018000 910270<br />
            Horario de atención: lunes a viernes de 8:00 am a 5:30 pm                        <br />
            <span class="font13 white">Correo electrónico para notificaciones judiciales: <a href="mailto:notificacionesjudiciales@sena.edu.co" class="bold white" rel="external">notificacionesjudiciales@sena.edu.co</a></span> <br />
            Todos los derechos reservados © 2012 ::.
        </div>
        <div class="total right">
            <a href="#top"><img src="../_img/top.gif" alt="Subir" title="Subir" /></a> &nbsp;
        </div>
        <!--<div class="space">&nbsp;</div>-->
    </div>

    <map name="Map2">
        <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
        <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
        <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
    </map>
</body>
</html>