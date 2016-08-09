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
            <strong> Principios de la Evaluación y la Certificación de la Competencia Laboral-ECCL</strong>
                            <br />
                            La evaluación y certificación de la competencia laboral (ECCL) se soporta en cuatro principios fundamentales:<br/><br/>
                    
                            <p align="justify">
                    <strong>Equidad:</strong> Es accesible a toda persona, evitando 
                    toda práctica discriminatoria, barreras o restricciones, teniendo 
                    en cuenta el cumplimiento de los requisitos de ingreso establecidos 
                    en esta guía y los definidos en los Esquemas de Evaluación y 
                    Certificación de Competencias Laborales (ECCL). <br/><br/>
                    <strong>Imparcialidad:</strong> Está basado en las evidencias 
                    requeridas por la Norma de Competencia Laboral  (NCL) y en
                    los resultados de evaluación a partir de instrumentos válidos 
                    y confiables,  garantizando la objetividad y transparencia 
                    en el procedimiento. <br/><br/>
                    <strong>Excelencia:</strong> Es el cumplimiento del 100% en 
                    cada una de las evidencias exigidas en la Norma de Competencia
                    Laboral que demuestra el candidato  para poder ostentar que 
                    es COMPETENTE. <br/><br/>
                    <strong>Transparencia:</strong> La información del proceso 
                    es clara, precisa y concreta y está disponible para los 
                    diferentes actores. <br/><br/>
                    
                    <strong> Características de la  Evaluación y Certificación de Competencias Laborales-ECCL</strong>
                    <br/><br/>
                    <strong>Gratuito:</strong> Se fundamenta en que para el 
                    candidato no representa pagos en dinero, especie,  directos
                    e indirectos al SENA o a las empresas, independientemente de
                    la línea de atención que se establezca (Alianza o Demanda Social). <br/><br/>
                    <strong>Accesible:</strong> Se accede de forma voluntaria a 
                    la Evaluación y Certificación de la Competencia Laboral de
                    manera libre y espontánea y no por obligación o deber,
                    teniendo en cuenta que el candidato es quien decide en 
                    qué momento puede demostrar las evidencias de desempeño
                    y producto requeridas por la Norma de Competencia Laboral
                    (NCL) a certificar. Las evidencias de conocimiento son 
                    programadas por el SENA, previa concertación,  aún en 
                    los casos de obligatoriedad legal o por política 
                    institucional como es el caso de funciones productivas
                    que revisten alto riesgo para la comunidad o que 
                    constituyen un factor importante para la calidad en
                    la prestación del servicio correspondiente. <br/><br/>
                    <strong>Sistémico:</strong> El procedimiento se ciñe a las 
                    fases, requisitos y condiciones establecidas en esta guía y
                    en los Esquemas de Evaluación y Certificación de Competencias 
                    Laborales (ECCL). <br/><br/>
                    <strong>Legítimo:</strong> Se define y establece por el 
                    Organismo Certificador SENA de manera auténtica y propia 
                    garantizando el cumplimiento de la  normatividad interna 
                    y externa. Se suma a esta característica  las evidencias 
                    presentadas por el candidato de manera individual a través 
                    de las cuales demuestra su autoría y propiedad, bajo un 
                    marco legal establecido. <br/><br/>
                    <strong>Práctico:</strong> Se centra en la experiencia y 
                    experticia que debe demostrar un candidato sin importar la 
                    forma o manera de cómo,  cuándo  y dónde adquirió la competencia. <br/><br/>
                    <strong>Estandarizado:</strong> Se basa en un modelo propio 
                    y de uso exclusivo del SENA a nivel nacional, soportado en 
                    Normas adoptadas, adaptadas o reconocidas por los sectores
                    productivos y Esquemas de Evaluación y Certificación de 
                    Competencias Laborales. <br/><br/>
                    <strong>Válido:</strong> Mide evidencias de conocimiento, 
                    desempeño y producto requeridos para el desempeño competente
                    de una función productiva. <br/><br/>
                    <strong>Justo:</strong> Brinda a todos y cada uno de los 
                    candidatos las mismas oportunidades en la valoración de 
                    evidencias y certificación. <br/><br/>
                    <strong>Confiable:</strong> El proceso de evaluación mide 
                    consistentemente las evidencias que debe demostrar un candidato. <br/><br/>
                    <strong>Independiente:</strong> Los actores que intervienen 
                    en el proceso no deben desempeñar más de un rol
                    simultáneamente ni hacer parte de otro proceso. <br/><br/>
                    </p>
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