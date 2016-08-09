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
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
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
            <strong>Documentos del proceso de Evaluación y Certificación de Competencias Laborales</strong>
            <br></br>
            <form style="height:600px;width:1050px;overflow:scroll;">
                <table>
                    
                    <tr><th>Descripción</th><th>Descargar</th></tr>
                                        <tr>
                        <td>Manual de procedimientos rol de líder</td>
                        <td><a href="Documentos/MANUAL DE PROCEDIMIENTOS ROL DE LIDER.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Manual de procedimientos rol de evaluador</td>
                        <td><a href="Documentos/MANUAL DE PROCEDIMIENTOS ROL DE EVALUADOR.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Manual de procedimientos rol de apoyo</td>
                        <td><a href="Documentos/MANUAL DE PROCEDIMIENTOS ROL DE APOYO.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Videoconferencia 28/03/2016</td>
                        <td><a href="Documentos/Presentación Grupo SECCL 28 marzo 2016 V3.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Videoconferencia 14/09/2015</td>
                        <td><a href="Documentos/Videoconferencia 14 sept.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Videoconferencia Apoyos 08/09/2015</td>
                        <td><a href="Documentos/Videoconferencia Apoyos 08-09-2015.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>ENCUESTA DIC 2014 SATISFACCIÓN DEL CLIENTE PROCESO ECCL</td>
                        <td><a href="Documentos/ENCUESTA DIC 2014 SATISFACCIÓN DEL CLIENTE PROCESO ECCL.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>INFORME FINAL ENCUESTAS CANDIDATOS 2014</td>
                        <td><a href="Documentos/INFORME FINAL ENCUESTAS CANDIDATOS 2014.xls" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Presentación definitiva videoconferencia 19 de junio</td>
                        <td><a href="Documentos/Presentación definitiva videoconferencia 19 de junio.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Formato encuesta de satisfaccion</td>
                        <td><a href="Documentos/Formato encuesta de satisfaccion1.xls" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Aspectos Operativos  BNIE - 2015</td>
                        <td><a href="Documentos/aspectos_operativos_BNIE_2015.msg" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Presentacion Video Conferencia 23/04/2015</td>
                        <td><a href="Documentos/presentacion sistemas 23-04-2015.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Metas año 2015</td>
                        <td><a href="Documentos/METAS 2015.xlsx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Orientaciones para llevar a cabo la Consolidación de los informes de las auditorías realizadas en el último cuatrimestre del año 2014</td>
                        <td><a href="Documentos/Orientaciones Auditoria.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Procedimiento Corrección y eliminación de Certificados</td>
                        <td><a href="Documentos/Procedimiento Correccion Certificados.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Procedimiento Generación de Titulaciones</td>
                        <td><a href="Documentos/Procedimiento Titulación.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Presentación Oficial Sensibilización 2015</td>
                        <td><a href="Documentos/PRESENTACION_SENSIBILIZACION.wmv" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Memorias de encuentro de lideres año 2014</td>
                        <td><a href="Documentos/MEMORIAS_CELECCL_2014.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Memorias de encuentro de Auditores año 2014</td>
                        <td><a href="Documentos/MEMORIAS_CEAUD_2014.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Plantilla Proyecto (03/03/2015)</td>
                        <td><a href="Documentos/Plantilla_Proyecto.xlsx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>

                    <tr>
                        <td>Presentación Videoconferencia Febrero 24 del 2015</td>
                        <td><a href="Documentos/VIDEOCONFERENCIA_FEBRERO_24.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>

                    <tr>
                        <td>Presentación Videoconferencia Febrero 16 del 2015</td>
                        <td><a href="Documentos/VIDEOCONFERENCIA_FEBRERO_16.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>

                    <tr>
                        <td>Áreas Reguladas (NORMAS QUE NO SE PUEDEN CERTIFICAR POR NIVELES - Actualizado 23/12/2014)</td>
                        <td><a href="Documentos/AREAS REGULADAS.xlsx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Suspensión del Servicio APP</td>
                        <td><a href="Documentos/APLICATIVO SECCL .msg" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>PRESENTACION CIRCULAR 4 TRIMESTRE</td>
                        <td><a href="Documentos/PRESENTACION CIRCULAR 4 TRIMESTRE.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Acciones Correctivas</td>
                        <td><a href="Documentos/Acciones correctivas.xls" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>MATRIZ DE CATEGORIZACIÓN DE NO CONFORMIDADES</td>
                        <td><a href="Documentos/MATRIZ DE CATEGORIZACIÓN DE NO CONFORMIDADES.xlsx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Lista de chequeo</td>
                        <td><a href="Documentos/Lista de chequeo.xls" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Formato Informe de Auditorias</td>
                        <td><a href="Documentos/Formato_Informe_de_Auditorias.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Formato Informe de Auditorias</td>
                        <td><a href="Documentos/Formato_Informe_de_Auditorias.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Guia Registro Areas Claves 2015 - Coordinador Misional</td>
                        <td><a href="Documentos/Manual Areas Claves Coordinador Misional.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Guia registro de metas - Coordinador Misional</td>
                        <td><a href="Documentos/Manual Metas Coordinador Misional.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Guia Novedades Aplicativo SECCL - Tercera actualización</td>
                        <td><a href="Documentos/Guia Novedades Aplicativo SECCL - Tercera actualización.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Guia para generar reportes del APP SECCL</td>
                        <td><a href="Documentos/REPORTES.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Guia Novedades Aplicativo SECCL - Segunda actualización</td>
                        <td><a href="Documentos/Guia Novedades Aplicativo SECCL - Segunda actualización.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Nueva norma transversal aprobada para aplicación Nacional</td>
                        <td><a href="Documentos/Nueva norma transversal aprobada para aplicación Nacional.msg" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Pasos - Registro de Evidencias y Emisión de Juicios</td>
                        <td><a href="Documentos/Manual Registro de evidencias.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Mejoras - Novedades App SECCL</td>
                        <td><a href="Documentos/Guia Novedades Aplicativo SECCL.docx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Correo electrónico - Cumplimiento de Metas 2014 - 26/06/2014</td>
                        <td><a href="Documentos/CUMPLIMIENTO DE META 20154.msg" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Reporte Histórico de Certificaciones 2006-2014 Agrupados por Mesa-Norma</td>
                        <td><a href="Documentos/historico certificacion mesa-norma.xlsx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Reporte Histórico de Certificaciones 2006-2014 (Los datos sombreados en verde,son datos generados del app SECCL)</td>
                        <td><a href="Documentos/Reporte Histórico de Certificados.xlsx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video de Apoyo * Creación de Grupos - Formalización Inscripción</td>
                        <td><a href="Documentos/Registro e Inscripcion editado.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Informe Final Evaluación-Certificación de Competencias Laborales</td>
                        <td><a href="Documentos/INFORME FINAL EVAL CERTIFICACION COMPETENCIAS LABORALES.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Manual de USUARIO Oficial app SECCL</td>
                        <td><a href="Documentos/Manual de USUARIO Oficial app SECCL.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Presentación Oficial Sensibilización 2014 - General PECCL</td>
                        <td><a href="Documentos/Presentación Oficial Sensibilización 2014 - General PECCL.ppt" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Presentación Sensibilización 2014 - Candidatos</td>
                        <td><a href="Documentos/Presentación Sensibilización 2014 - Candidatos.ppt" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Presentación Oficial - PECCL - 2014 - Empresarios</td>
                        <td><a href="Documentos/Presentación Oficial - PECCL - 2014 - Empresarios.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Presentación Videoconferencia Febrero 5</td>
                        <td><a href="Documentos/PRESENTACIÓNVIDEOCONFERENCIA FEBRERO 5.ppt" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Anexos del Proceso de Evaluación y Certificación de Competencias Laborales - ECCL</td>
                        <!--<td><a href="Documentos/Memorias Evento/d1/guia/ANEXOS DE ECCL.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>-->
                    </tr>
                    <tr>
                        <td>Anexos del Instructivo - ECCL</td>
                        <!--<td><a href="Documentos/Memorias Evento/d1/guia/Anexos del Instructivo.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>-->
                    </tr>
                    <tr>
                        <td>Formatos del Instructivo - ECCL</td>
                        <!--<td><a href="Documentos/Memorias Evento/d1/guia/Formatos del Instructivo.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>-->
                    </tr>
                    <tr>
                        <td>Formatos de la Guía de Evaluación y Certificación de competencias Laborales - ECCL</td>
                        <!--<td><a href="Documentos/Memorias Evento/d1/guia/FORMATOS GUÍA ECCL.rar" target="blank"><img src="../images/btnDescargar.gif"></a></td>-->
                    </tr>
                    <tr>
                        <td>Guía para Evaluar y Certificar Competencias Laborales - ECCL</td>
                        <!--<td><a href="Documentos/Memorias Evento/d1/guia/GUÍA PARA EVALUAR Y CERTIFICAR COMPETENCIAS LABORALES - VERSIÓN 2.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>-->
                    </tr>
                    <tr>
                        <td>Instructivo para la Construcción de Ítems - ECCL</td>
                        <!--<td><a href="Documentos/Memorias Evento/d1/guia/INSTRUCTIVO PARA  LA CONSTRUCCIÓN DE ÍTEMS E INDICADORES DE EVALUACIÓN DE COMPETENCIAS LABORALES.pdf" target="blank"><img src="../images/btnDescargar.gif"></a></td>-->
                    </tr>
                    <tr>
                        <td>Video de Contextualización - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d1/5-VIDEO DE CONTEXTUALIZACIÓN.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Sopa de Letras - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d1/8- SOPA DE LETRAS EXCEL.xlsx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Sopa de Letras Power Point - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d1/Sopa de Letras.pptx" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Custodia y Confidencialidad - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d2/CUSTODIA Y CONFIDENCIALIDAD.xps" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Novedades Candidato y Procedimiento - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d2/NOVEDADES CANDIDATO Y PROC ECCL.xps" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Formación Complementaria Virtual - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d3/2 - FormacionComplemVirtual CONSTRUCC I_I_CL  vs 2.xps" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Curso de Evaluadores - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d3/3 - CURSO DE EVALUADORES - PRESENTACIÓN.xps" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Periódico - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d3/4 - PERIODICO.txt" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>ISO IEC 17024 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/d3/ISO IEC 17024 2012 Bucaramanga.xps" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 1 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/1.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 2 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/2.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 3 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/3.wmv" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 4 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/4.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 5 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/5.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 6 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/6.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 7 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/7.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 8 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/8.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 9 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/9.wmv" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 10 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/10.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 11 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/11.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 12 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/12.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 13 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/13.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 14 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/14.mp4" target="blank"><img src="../images/btnDescargar.gif"></a></td>
                    </tr>
                    <tr>
                        <td>Video 15 - ECCL</td>
                        <td><a href="Documentos/Memorias Evento/VIDEOS/15.wmv" target="blank"><img src="../images/btnDescargar.gif"></a></td>
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