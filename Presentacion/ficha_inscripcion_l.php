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
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

    </head>
    <body onload="inicio()">
 	<?php include ('layout/cabecera.php') ?>
        <div id="contenedorcito">
            
            <?php
                require_once("../Clase/conectar.php");
                $idca = $_GET["idca"];
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                
                $query5 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement5 = oci_parse($connection, $query5);
                $resp5 = oci_execute($statement5);
                $idc = oci_fetch_array($statement5, OCI_BOTH);
                
                $query3 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $reg = oci_fetch_array($statement3, OCI_BOTH);

                $query4 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
                $statement4 = oci_parse($connection, $query4);
                $resp4 = oci_execute($statement4);
                $cen = oci_fetch_array($statement4, OCI_BOTH);
                
                $query7 = ("SELECT nombre_regional FROM regional where codigo_regional =  '$reg[0]'");
                $statement7 = oci_parse($connection, $query7);
                $resp7 = oci_execute($statement7);
                $nomreg = oci_fetch_array($statement7, OCI_BOTH);
                
                $query8 = ("SELECT nombre_centro FROM centro where codigo_centro =  '$cen[0]'");
                $statement8 = oci_parse($connection, $query8);
                $resp8 = oci_execute($statement8);
                $nomcen = oci_fetch_array($statement8, OCI_BOTH);
                
                //--Carga Datos Personal
                
                //----obtener nombre
$strSQL9 = "select nombre from usuario where usuario_id='$idca'";
$statement9 = oci_parse($connection, $strSQL9);
$resp9 = oci_execute($statement9);
$nombre = oci_fetch_array($statement9, OCI_BOTH);
//---obtener apellido
$strSQL10 = "select primer_apellido from usuario where usuario_id='$idca'";
$statement10 = oci_parse($connection, $strSQL10);
$resp10 = oci_execute($statement10);
$pape = oci_fetch_array($statement10, OCI_BOTH);
//---obtener apellido
$strSQL11 = "select segundo_apellido from usuario where usuario_id='$idca'";
$statement11 = oci_parse($connection, $strSQL11);
$resp11 = oci_execute($statement11);
$sape = oci_fetch_array($statement11, OCI_BOTH);
//---obtener documento
$strSQL12 = "select documento from usuario where usuario_id='$idca'";
$statement12 = oci_parse($connection, $strSQL12);
$resp12 = oci_execute($statement12);
$documento = oci_fetch_array($statement12, OCI_BOTH);
//---obtener expedicion libreta
$strSQL13 = "select expedicion from usuario where usuario_id='$idca'";
$statement13 = oci_parse($connection, $strSQL13);
$resp13 = oci_execute($statement13);
$expedicion = oci_fetch_array($statement13, OCI_BOTH);
//---obtener libreta
$strSQL14 = "select libreta_militar from usuario where usuario_id='$idca'";
$statement14 = oci_parse($connection, $strSQL14);
$resp14 = oci_execute($statement14);
$libreta = oci_fetch_array($statement14, OCI_BOTH);
//---obtener FECHA NAC
$strSQL15 = "select to_char(f_nacimiento,'dd/mm/yyyy') from usuario where usuario_id='$idca'";
$statement15 = oci_parse($connection, $strSQL15);
$resp15 = oci_execute($statement15);
$fnacimiento = oci_fetch_array($statement15, OCI_BOTH);
//---obtener id_depto_NAC
$strSQL16 = "select depto_nacimiento from usuario where usuario_id='$idca'";
$statement16= oci_parse($connection, $strSQL16);
$resp16 = oci_execute($statement16);
$iddepto = oci_fetch_array($statement16, OCI_BOTH);
//---obtener id_munc_NAC
$strSQL17 = "select municipio_nacimiento from usuario where usuario_id='$idca'";
$statement17 = oci_parse($connection, $strSQL17);
$resp17 = oci_execute($statement17);
$idmunc = oci_fetch_array($statement17, OCI_BOTH);
//---obtener depto
$strSQL18 = "select nombre_departamento from departamento where id_departamento='$iddepto[0]'";
$statement18= oci_parse($connection, $strSQL18);
$resp18 = oci_execute($statement18);
$depto = oci_fetch_array($statement18, OCI_BOTH);
//---obtener munc
$strSQL19 = "select nombre_municipio from municipio where id_departamento='$iddepto[0]' and id_municipio='$idmunc[0]'";
$statement19 = oci_parse($connection, $strSQL19);
$resp19 = oci_execute($statement19);
$munc = oci_fetch_array($statement19, OCI_BOTH);
//---obtener id_depto_vivi
$strSQL20 = "select depto_residencia from usuario where usuario_id='$idca'";
$statement20= oci_parse($connection, $strSQL20);
$resp20 = oci_execute($statement20);
$iddeptov = oci_fetch_array($statement20, OCI_BOTH);
//---obtener id_munc_vivi
$strSQL21 = "select municipio_residencia from usuario where usuario_id='$idca'";
$statement21 = oci_parse($connection, $strSQL21);
$resp21 = oci_execute($statement21);
$idmuncv = oci_fetch_array($statement21, OCI_BOTH);
//---obtener deptovivi
$strSQL22 = "select nombre_departamento from departamento where id_departamento='$iddeptov[0]'";
$statement22= oci_parse($connection, $strSQL22);
$resp22 = oci_execute($statement22);
$deptov = oci_fetch_array($statement22, OCI_BOTH);
//---obtener muncvivi
$strSQL23 = "select nombre_municipio from municipio where id_departamento='$iddeptov[0]' and id_municipio='$idmuncv[0]'";
$statement23 = oci_parse($connection, $strSQL23);
$resp23 = oci_execute($statement23);
$muncv = oci_fetch_array($statement23, OCI_BOTH);
//---obtener barrio
$strSQL24 = "select barrio from usuario where usuario_id='$idca'";
$statement24 = oci_parse($connection, $strSQL24);
$resp24 = oci_execute($statement24);
$barrio = oci_fetch_array($statement24, OCI_BOTH);
//---obtener direccion domicilio
$strSQL25 = "select direccion_residencia from usuario where usuario_id='$idca'";
$statement25 = oci_parse($connection, $strSQL25);
$resp25 = oci_execute($statement25);
$direccion = oci_fetch_array($statement25, OCI_BOTH);
//---obtener email
$strSQL26 = "select email from usuario where usuario_id='$idca'";
$statement26 = oci_parse($connection, $strSQL26);
$resp26 = oci_execute($statement26);
$email = oci_fetch_array($statement26, OCI_BOTH);
//---obtener telefono
$strSQL27 = "select telefono from usuario where usuario_id='$idca'";
$statement27 = oci_parse($connection, $strSQL27);
$resp27 = oci_execute($statement27);
$telefono = oci_fetch_array($statement27, OCI_BOTH);
//---obtener celular
$strSQL28 = "select celular from usuario where usuario_id='$idca'";
$statement28 = oci_parse($connection, $strSQL28);
$resp28 = oci_execute($statement28);
$celular = oci_fetch_array($statement28, OCI_BOTH);
//---obtener APELLIDO CONTACTO
$strSQL29 = "select primer_apellido from contacto_candidato where id_candidato='$idca'";
$statement29 = oci_parse($connection, $strSQL29);
$resp29 = oci_execute($statement29);
$papec = oci_fetch_array($statement29, OCI_BOTH);
//---obtener segundo CONTACTO
$strSQL30 = "select segundo_apellido from contacto_candidato where id_candidato='$idca'";
$statement30 = oci_parse($connection, $strSQL30);
$resp30 = oci_execute($statement30);
$sapec = oci_fetch_array($statement30, OCI_BOTH);
//---obtener nombre contacto
$strSQL31 = "select nombre from contacto_candidato where id_candidato='$idca'";
$statement31 = oci_parse($connection, $strSQL31);
$resp31 = oci_execute($statement31);
$nombrec = oci_fetch_array($statement31, OCI_BOTH);
//---obtener direccion CONTACTO
$strSQL32 = "select direccion from contacto_candidato where id_candidato='$idca'";
$statement32 = oci_parse($connection, $strSQL32);
$resp32 = oci_execute($statement32);
$direccionc = oci_fetch_array($statement32, OCI_BOTH);
//---obtener telefono CONTACTO
$strSQL33 = "select telefono from contacto_candidato where id_candidato='$idca'";
$statement33 = oci_parse($connection, $strSQL33);
$resp33 = oci_execute($statement33);
$telefonoc = oci_fetch_array($statement33, OCI_BOTH);
//---obtener celulat CONTACTO
$strSQL34 = "select celular from contacto_candidato where id_candidato='$idca'";
$statement34 = oci_parse($connection, $strSQL34);
$resp34 = oci_execute($statement34);
$celularc = oci_fetch_array($statement34, OCI_BOTH);
//---obtener email CONTACTO
$strSQL35 = "select email from contacto_candidato where id_candidato='$idca'";
$statement35 = oci_parse($connection, $strSQL35);
$resp35 = oci_execute($statement35);
$emailc = oci_fetch_array($statement35, OCI_BOTH);
//---obtener parentesco CONTACTO
$strSQL36 = "select parentesco from contacto_candidato where id_candidato='$idca'";
$statement36 = oci_parse($connection, $strSQL36);
$resp36 = oci_execute($statement36);
$parentescoc = oci_fetch_array($statement36, OCI_BOTH);
//---obtener parentesco CONTACTO
$strSQL37 = "select nit_empresa from usuario where usuario_id='$idca'";
$statement37 = oci_parse($connection, $strSQL37);
$resp37 = oci_execute($statement37);
$nit = oci_fetch_array($statement37, OCI_BOTH);
//---obtener parentesco CONTACTO
$strSQL38 = "select nombre_empresa from empresas_sistema where nit_empresa='$nit[0]'";
$statement38 = oci_parse($connection, $strSQL38);
$resp38 = oci_execute($statement38);
$empresa = oci_fetch_array($statement38, OCI_BOTH);
//---obtener tipo documento
$strSQL39 = "select tipo_doc from usuario where usuario_id='$idca'";
$statement39 = oci_parse($connection, $strSQL39);
$resp39 = oci_execute($statement39);
$tdoc = oci_fetch_array($statement39, OCI_BOTH);
//---obtener tipo sexo
$strSQL40 = "select id_sexo from usuario where usuario_id='$idca'";
$statement40 = oci_parse($connection, $strSQL40);
$resp40 = oci_execute($statement40);
$tsexo = oci_fetch_array($statement40, OCI_BOTH);
//---obtener tipo sangre
$strSQL41 = "select id_sanguineo from usuario where usuario_id='$idca'";
$statement41 = oci_parse($connection, $strSQL41);
$resp41 = oci_execute($statement41);
$tsangre = oci_fetch_array($statement41, OCI_BOTH);
//---obtener estrato
$strSQL42 = "select estrato from usuario where usuario_id='$idca'";
$statement42 = oci_parse($connection, $strSQL42);
$resp42 = oci_execute($statement42);
$estrato = oci_fetch_array($statement42, OCI_BOTH);
//---obtener estado civil
$strSQL43 = "select id_estado_civil from usuario where usuario_id='$idca'";
$statement43 = oci_parse($connection, $strSQL43);
$resp43 = oci_execute($statement43);
$civil = oci_fetch_array($statement43, OCI_BOTH);
//---obtener estrato
$strSQL44 = "select id_escolaridad from usuario where usuario_id='$idca'";
$statement44 = oci_parse($connection, $strSQL44);
$resp44 = oci_execute($statement44);
$escolaridad = oci_fetch_array($statement44, OCI_BOTH);
//---obtener estrato
$strSQL45 = "select condicion_laboral from usuario where usuario_id='$idca'";
$statement45 = oci_parse($connection, $strSQL45);
$resp45 = oci_execute($statement45);
$claboral = oci_fetch_array($statement45, OCI_BOTH);
//---obtener estrato
$strSQL46 = "select id_tipo_trabajador_sena from usuario where usuario_id='$idca'";
$statement46 = oci_parse($connection, $strSQL46);
$resp46 = oci_execute($statement46);
$trabajador = oci_fetch_array($statement46, OCI_BOTH);
//---obtener tipo poblacion
$strSQL47 = "select id_tipo_poblacion from usuario where usuario_id='$idca'";
$statement47 = oci_parse($connection, $strSQL47);
$resp47 = oci_execute($statement47);
$tpoblacion = oci_fetch_array($statement47, OCI_BOTH);


                ?>
            
            <br>
                <form id="frmRegEsquema" name="frmRegEsquema" 
                  action="" enctype="multipart/form-data" method="post">
               <br></br>
                    <img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>FICHA DE DATOS CANDIDATOS</strong><br></br>
                    <strong> Evaluación y Certificación de Competencias Laborales</strong>
                    <br></br>
                <table>

                    <thead><tr><th><strong>Código Regional:</strong></th>
                            <td><?php echo $reg[0]; ?></td>
                            <th><strong>Nombre Regional:</strong></th>
                            <td><?php echo utf8_encode($nomreg[0]) ?></td>
                                </thead>
                    <thead><tr><th><strong>Código Centro:</strong></th>
                            <td><?php echo $cen[0]; ?></td>
                            <th><strong>Nombre Centro:</strong></th>
                            <td><?php echo utf8_encode($nomcen[0]) ?></td>
                            </thead>
                </table>
                </center>
            <center><table>
                    </br>
                        <tr><th colspan="5">Identificación del Aspirante</th></tr>
                        <tr>
                            <th>Tipo de Documento</th><th>Número de Documento</th><th>Lugar de Expedición</th><th>Número de Libreta Militar</th>
                        </tr>
                        <tr>
                            <td>
                                <?php if($tdoc[0]==1){?>
                                <input type="radio" value="1" disabled="disabled" checked="checked" name="tipodoc"></input>T.I.
                                <?php }else{ ?>
                                <input type="radio" value="1" disabled="disabled" name="tipodoc"></input>T.I.
                                <?php }?>
                                <?php if($tdoc[0]==2){?>
                                <input type="radio" value="2" disabled="disabled" checked="checked" name="tipodoc"></input>C.C.
                                <?php }else{ ?>
                                <input type="radio" value="2" disabled name="tipodoc"></input>C.C.
                                <?php }?>
                                <?php if($tdoc[0]==3){?>
                                <input type="radio" value="3" disabled="disabled" checked="checked" name="tipodoc"></input>C.E.
                                <?php }else{ ?>
                                <input type="radio" value="3" disabled="disabled"  name="tipodoc"></input>C.E.
                                <?php }?>
                                <?php if($tdoc[0]==4){?>
                                <input type="radio" value="4" disabled="disabled" checked="checked" name="tipodoc"></input>P.T.
                                <?php }else{ ?>
                                <input type="radio" value="4" disabled="disabled"  name="tipodoc"></input>P.T.
                                <?php }?>
                            </td>
                            <td><input type="text" name="documento" readonly="readonly" value="<?php echo $documento[0] ?>" /></td>
                            <td><input type="text" name="expedicion" size="50" readonly="readonly" value="<?php echo $expedicion[0] ?>" /></td>
                            <td><input type="text" name="libreta" size="20" readonly="readonly" value="<?php echo $libreta[0] ?>""/></td>
                        </tr>
                    </table></center>
                <br></br>
                    <br>
                        <center><strong>CC</strong> :&nbsp;Cédula de ciudadanía &nbsp;&nbsp;<strong>CE</strong> :&nbsp;Cédula de Extranjería &nbsp;&nbsp;<strong>TI</strong> :&nbsp;Tarjeta de Identidad &nbsp;&nbsp;<strong>P.T.</strong> :&nbsp;Número de Pasaporte</center>
                    </br>
                    <table>
                        <tr><th colspan="4">Información Detallada Aspirante</th></tr>
                        <tr><th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre Completo</th><th>Fecha de nacimiento</th></tr>
                        <tr>
                            <td><input type="text" size="" name="papellido" readonly="readonly" value="<?php echo utf8_encode($pape[0]) ?>"></input></td>
                            <td><input type="text" size="" name="sapellido" readonly="readonly" value="<?php echo utf8_encode($sape[0]) ?>"></input></td>
                            <td><input type="text" size="" name="nombre" readonly="readonly" value="<?php echo utf8_encode($nombre[0] ) ?>"></input></td>
                            <td><input type="text" size="" name="fnacimiento" readonly="readonly" value="<?php echo $fnacimiento[0] ?> "></input></td>
                        </tr>
                        <tr><th>Departamento de Nacimiento</th><th>Municipio de Nacimiento</th><th>Género</th><th>Grupo Sanguíneo</th></tr>
                        <tr>
                            <td><input type="text" size="" name="deptonac" readonly="readonly" value="<?php echo $depto[0] ?>" ></input></td>
                            <td><input type="text" size="" name="municipionac" readonly="readonly" value="<?php echo $munc[0] ?>" ></input></td>
                            <td>
                                <?php if($tsexo[0]==1){ ?>
                                <input type="radio" value="1" disabled="disabled" checked="checked" name="sexo" ></input>Masculino
                                
                                <input type="radio" value="2" disabled="disabled" name="sexo" ></input>Femenino
                                <?php }else if($tsexo[0]==2){ ?>
                                <input type="radio" value="1" disabled="disabled" name="sexo" ></input>Masculino
                                
                                <input type="radio" value="2" disabled="disabled" checked="checked" name="sexo"  ></input>Femenino
                                <?php }else { ?>
                                <input type="radio" value="1" disabled="disabled" name="sexo" ></input>Masculino
                                
                                <input type="radio" value="2" disabled="disabled" checked="checked" name="sexo"  ></input>Femenino
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($tsangre[0]==1){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="1" name="sangre"  ></input>O+
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="1" name="sangre"  ></input>O+
                                <?php } ?>
                                <?php if($tsangre[0]==2){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="2" name="sangre" input>O-
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="2" name="sangre" input>O-
                                <?php } ?>
                                <?php if($tsangre[0]==3){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="3" name="sangre"  ></input>A+
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="3" name="sangre"  ></input>A+
                                <?php } ?>
                                <?php if($tsangre[0]==4){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="4" name="sangre"></input>A-<br>
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="4" name="sangre"></input>A-<br>
                                <?php } ?>
                                <?php if($tsangre[0]==5){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="5" name="sangre"  ></input>B+
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="5" name="sangre"  ></input>B+
                                <?php } ?>
                                <?php if($tsangre[0]==6){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="6" name="sangre" input>B-
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="6" name="sangre" input>B-
                                <?php } ?>
                                <?php if($tsangre[0]==7){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="7" name="sangre"  ></input>AB+
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="7" name="sangre"  ></input>AB+
                                <?php } ?>
                                <?php if($tsangre[0]==8){ ?>
                                <input type="radio" disabled="disabled" checked="checked" value="8" name="sangre"></input>AB-
                                <?php }else{ ?>
                                <input type="radio" disabled="disabled" value="8" name="sangre"></input>AB-
                                <?php } ?>
                                
                            </td>
                            </td>
                        </tr>
                        <tr><th>Departamento de Domicilio</th><th>Municipio de Domicilio</th><th>Barrio</th><th>Dirección de Domicilio</th></tr>
                        <tr>
                            <td><input type="text" size="" name="deptodom" readonly="readonly" value="<?php echo $deptov[0] ?>" ></input></td>
                            <td><input type="text" size="" name="municipiodom" readonly="readonly" value="<?php echo $muncv[0] ?>" ></input></td>
                            <td><input type="text" size="" name="barrio" readonly="readonly" value="<?php echo $barrio[0] ?>" ></input></td>
                            <td><input type="text" size="50" name="domicilio" readonly="readonly" value="<?php echo utf8_encode($direccion[0]) ?>"></input></td>
                            
                        </tr>
                        <tr><th>Teléfono</th><th>Celular</th><th>Estado Civil</th><th>Estrato</th></tr>
                        <tr>
                            <td><input type="text" size="" name="telefono" readonly="readonly" value="<?php echo $telefono[0] ?>" ></input></td>
                            <td><input type="text" size="" name="celular" readonly="readonly" value="<?php echo $celular[0] ?>"></input></td>
                            <td>
                                <?php if($civil[0]==1){ ?>
                                <input type="radio" value="1" disabled="disabled" checked="checked"  name="estado"></input>Soltero(a)
                                <?php }else{ ?>
                                <input type="radio" value="1" disabled="disabled" name="estado"></input>Soltero(a)
                                <?php } ?>
                                <?php if($civil[0]==2){ ?>
                                <input type="radio" value="2" disabled="disabled" checked="checked" name="estado"></input>Unión Libre<br>
                                <?php }else{ ?>
                                <input type="radio" value="2" disabled="disabled"  name="estado"></input>Unión Libre<br>
                                <?php } ?>
                                <?php if($civil[0]==3){ ?>
                                <input type="radio" value="3" disabled="disabled" checked="checked" name="estado"></input>Casado(a)
                                <?php }else{ ?>
                                <input type="radio" value="3" disabled="disabled" name="estado"></input>Casado(a)
                                <?php } ?>
                                <?php if($civil[0]==4){ ?>
                                <input type="radio" value="4" disabled="disabled" checked="checked" name="estado"></input>Viudo(a)
                                <?php }else{ ?>
                                <input type="radio" value="4" disabled="disabled"  name="estado"></input>Viudo(a)
                                <?php } ?>
                                <?php if($civil[0]==5){ ?>
                                <input type="radio" value="5" disabled="disabled" checked="checked" name="estado"></input>Otro(a)
                                <?php }else{ ?>
                                <input type="radio" value="5" disabled="disabled" name="estado"></input>Otro(a)
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($estrato[0]==1){ ?>
                                <input type="radio" value="1" disabled="disabled" checked="checked" name="estrato"  ></input>Uno (1)
                                <?php }else{ ?>
                                <input type="radio" value="1" disabled="disabled"  name="estrato"  ></input>Uno (1)
                                <?php } ?>
                                <?php if($estrato[0]==2){ ?>
                                <input type="radio" value="2" disabled="disabled" checked="checked" name="estrato"></input>Dos (2)
                                <?php }else{ ?>
                                <input type="radio" value="2" disabled="disabled"  name="estrato"></input>Dos (2)
                                <?php } ?>
                                <?php if($estrato[0]==3){ ?>
                                <input type="radio" value="3" disabled="disabled" checked="checked" name="estrato"></input>Tres (3)<br>
                                <?php }else{ ?>
                                <input type="radio" value="3" disabled="disabled"  name="estrato"></input>Tres (3)<br>
                                <?php } ?>
                                <?php if($estrato[0]==4){ ?>
                                <input type="radio" value="4" disabled="disabled" checked="checked" name="estrato"></input>Cuatro (4)
                                <?php }else{ ?>
                                <input type="radio" value="4" disabled="disabled" name="estrato"></input>Cuatro (4)
                                <?php } ?>
                                <?php if($estrato[0]==5){ ?>
                                <input type="radio" value="5" disabled="disabled" checked="checked" name="estrato"></input>cinco (5)
                                <?php }else{ ?>
                                <input type="radio" value="5" disabled="disabled"  name="estrato"></input>cinco (5)
                                <?php } ?>
                                <?php if($estrato[0]==6){ ?>
                                <input type="radio" value="6" disabled="disabled" checked="checked" name="estrato"></input>Seis (6)
                                <?php }else{ ?>
                                <input type="radio" value="6" disabled="disabled"  name="estrato"></input>Seis (6)
                                <?php } ?>
                               
                            </td>
                        </tr>
                        <tr>
                            <th>Nivel Escolaridad</th>
                            <td>
                                <?php if($escolaridad[0]==1){ ?>
                                <input type="radio" value="1" disabled="disabled" checked="checked" name="escolaridad"></input>Ninguno
                                <?php }else{ ?>
                                <input type="radio" value="1" disabled="disabled"  name="escolaridad"></input>Ninguno
                                <?php } ?>
                                <?php if($escolaridad[0]==2){ ?>
                                <input type="radio" value="2" disabled="disabled" checked="checked" name="escolaridad"></input>Primaria<br>
                                <?php }else{ ?>
                                <input type="radio" value="2" disabled="disabled"  name="escolaridad"></input>Primaria<br>
                                <?php } ?>
                                <?php if($escolaridad[0]==3){ ?>
                                <input type="radio" value="3" disabled="disabled" checked="checked" name="escolaridad"></input>Media
                                <?php }else{ ?>
                                <input type="radio" value="3" disabled="disabled"  name="escolaridad"></input>Media
                                <?php } ?>
                                <?php if($escolaridad[0]==4){ ?>
                                <input type="radio" value="4" disabled="disabled" checked="checked"name="escolaridad"></input>Bachiller<br>
                                <?php }else{ ?>
                                <input type="radio" value="4" disabled="disabled" name="escolaridad"></input>Bachiller<br>
                                <?php } ?>
                                <?php if($escolaridad[0]==5){ ?>
                                <input type="radio" value="5" disabled="disabled" checked="checked" name="escolaridad"></input>Técnico
                                <?php }else{ ?>
                                <input type="radio" value="5" disabled="disabled"  name="escolaridad"></input>Técnico
                                <?php } ?>
                                <?php if($escolaridad[0]==6){ ?>
                                <input type="radio" value="6" disabled="disabled" checked="checked" name="escolaridad"></input>Tecnólogo<br>
                                <?php }else{ ?>
                                <input type="radio" value="6" disabled="disabled"  name="escolaridad"></input>Tecnólogo<br>
                                <?php } ?>
                                <?php if($escolaridad[0]==7){ ?>
                                <input type="radio" value="7" disabled="disabled" checked="checked" name="escolaridad"></input>Profesional
                                <?php }else{ ?>
                                <input type="radio" value="7" disabled="disabled" name="escolaridad"></input>Profesional
                                <?php } ?>
                                <?php if($escolaridad[0]==8){ ?>
                                <input type="radio" value="8" disabled="disabled" checked="checked" name="escolaridad"></input>Especialización<br>
                                <?php }else{ ?>
                                <input type="radio" value="8" disabled="disabled" name="escolaridad"></input>Especialización<br>
                                <?php } ?>
                                <?php if($escolaridad[0]==9){ ?>
                                <input type="radio" value="9" disabled="disabled" checked="checked" name="escolaridad"></input>Maestría
                                <?php }else{ ?>
                                <input type="radio" value="9" disabled="disabled" name="escolaridad"></input>Maestría
                                <?php } ?>
                                <?php if($escolaridad[0]==10){ ?>
                                <input type="radio" value="10" disabled="disabled" checked="checked" name="escolaridad"></input>Doctorado
                                <?php }else{ ?>
                                <input type="radio" value="10" disabled="disabled"  name="escolaridad"></input>Doctorado
                                <?php } ?>
                            </td>
                            <th>Correo Electrónico</th>
                            <td><input type="text" size="50" name="email" readonly="readonly" value="<?php echo utf8_encode($email[0]) ?>" ></input></td>
                        </tr>
                    </table>
                    </br>
                        <center><table>
                                <tr><th colspan="4">Datos de Contacto</th></tr>
                        <tr><th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre Completo</th><th>Dirección Residecia</th></tr>
                        <tr>
                            <td><input type="text" name="cpapellido" readonly="readonly" value="<?php echo $papec[0] ?>" ></input></td>
                            <td><input type="text" name="csapellido" readonly="readonly" value="<?php echo $sapec[0] ?>"  ></input></td>
                            <td><input type="text" name="cnombre" size="50" readonly="readonly" value="<?php echo $nombrec[0] ?>"  ></input></td>
                            <td><input type="text" name="cresidencia" size="30" readonly="readonly" value="<?php echo $direccionc[0] ?>"  ></input></td>
                        </tr>
                        <tr><th>Teléfono</th><th>Celular</th><th>Correo Electrónico</th><th>Parentesco</th></tr>
                        <tr>
                            <td><input type="text" name="ctelefono" readonly="readonly" value="<?php echo $telefonoc[0] ?>"  ></input></td>
                            <td><input type="text" name="ccelular" readonly="readonly" value="<?php echo $celularc[0] ?>"  ></input></td>
                            <td><input type="text" name="cemail" size="50" readonly="readonly" value="<?php echo $emailc[0] ?>"  ></input></td>
                            <td><input type="text" name="cparentesco" readonly="readonly" value="<?php echo $parentescoc[0] ?>"  ></input></td>
                        </tr>
                    </table></center>
                    
                    </br>
                    <center><table>
                        <tr><th colspan="3">Datos Laborales</th></tr>
                        <tr><th>Condición Laboral</th><th>Empresa</th><th>Nit Empresa</th></tr>
                        <tr>
                            <td>
                                <?php if($claboral[0]==1){ ?>
                                <input type="radio" value="1" disabled="disabled" checked="checked" name="claboral"  ></input>Empleado
                                <?php }else{ ?>
                                <input type="radio" value="1" disabled="disabled"  name="claboral"  ></input>Empleado
                                <?php } ?>
                                <?php if($claboral[0]==2){ ?>
                                <input type="radio" value="1" disabled="disabled" checked="checked" name="claboral"  ></input>Desempleado
                                <?php }else{ ?>
                                <input type="radio" value="1" disabled="disabled"  name="claboral"  ></input>Desempleado
                                <?php } ?>
                                <?php if($claboral[0]==3){ ?>
                                <input type="radio" value="1" disabled="disabled" checked="checked" name="claboral"  ></input>Independiente
                                <?php }else{ ?>
                                <input type="radio" value="1" disabled="disabled"  name="claboral"  ></input>Independiente
                                <?php } ?>
                                
                            </td>
                            <td>
                                <input name="nombre_empresa" type="text" size="50" readonly="readonly" value="<?php echo $empresa[0] ?>" ></input>
                            </td>
                            <td>
                                <input name="nit_empresa" id="nit_empresa" type="text" readonly="readonly" value="<?php echo $nit[0] ?>"></input>
                            </td>
                        </tr>
                      </table></center>
                    </br>
                    <center><table>
                            <tr><th colspan="5">Trabajadores SENA</th></tr>
                        <tr>
                            <?php if($trabajador[0]==1){ ?>
                            <td><input type="radio" value="1" disabled="disabled" checked="checked" name="trabajador_sena"></input>Instructor de Planta</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="1" disabled="disabled" name="trabajador_sena"></input>Instructor de Planta</td>
                            <?php } ?>
                            <?php if($trabajador[0]==2){ ?>
                            <td><input type="radio" value="2" disabled="disabled" checked="checked" name="trabajador_sena"></input>Instructor de Contrato</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="2" disabled="disabled"  name="trabajador_sena"></input>Instructor de Contrato</td>
                            <?php } ?>
                            <?php if($trabajador[0]==3){ ?>
                            <td><input type="radio" value="3" disabled="disabled" checked="checked" name="trabajador_sena"></input>Coordinador Académico</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="3" disabled="disabled" name="trabajador_sena"></input>Coordinador Académico</td>
                            <?php } ?>
                            <?php if($trabajador[0]==4){ ?>
                            <td><input type="radio" value="4" disabled="disabled" checked="checked" name="trabajador_sena"></input>Asesor de Planta</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="4" disabled="disabled" name="trabajador_sena"></input>Asesor de Planta</td>
                            <?php } ?>
                            <?php if($trabajador[0]==5){ ?>
                            <td><input type="radio" value="5" disabled="disabled" checked="checked" name="trabajador_sena"></input>Asesor de Contrato</td><br>
                            <?php }else{ ?>
                            <td><input type="radio" value="5" disabled="disabled" name="trabajador_sena"></input>Asesor de Contrato</td><br>
                            <?php } ?>
                            
                        </tr>
                        <tr>
                            <?php if($trabajador[0]==6){ ?>
                            <td><input type="radio" value="6" disabled="disabled" checked="checked" name="trabajador_sena"></input>Profesionales de Planta</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="6" disabled="disabled"  name="trabajador_sena"></input>Profesionales de Planta</td>
                            <?php } ?>
                            <?php if($trabajador[0]==7){ ?>
                            <td><input type="radio" value="7" disabled="disabled" checked="checked" name="trabajador_sena"></input>Profesionales de Contrato</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="7" disabled="disabled"  name="trabajador_sena"></input>Profesionales de Contrato</td>
                            <?php } ?>
                            <?php if($trabajador[0]==8){ ?>
                            <td><input type="radio" value="8" disabled="disabled" checked="checked" name="trabajador_sena"></input>Técnicos y Asistenciales de Planta</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="8" disabled="disabled"  name="trabajador_sena"></input>Técnicos y Asistenciales de Planta</td>
                            <?php } ?>
                            <?php if($trabajador[0]==9){ ?>
                            <td><input type="radio" value="9" disabled="disabled" checked="checked" name="trabajador_sena"></input>Técnico y Asistenciales de Contrato</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="9" disabled="disabled"  name="trabajador_sena"></input>Técnico y Asistenciales de Contrato</td>
                            <?php } ?>
                            <?php if($trabajador[0]==10){ ?>
                            <td><input type="radio" value="10" disabled="disabled" checked="checked" name="trabajador_sena"></input>Trabajadores Oficiales</td><br>
                            <?php }else{ ?>
                            <td><input type="radio" value="10" disabled="disabled"  name="trabajador_sena"></input>Trabajadores Oficiales</td><br>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($trabajador[0]==11){ ?>
                            <td><input type="radio" value="11" disabled="disabled" checked="checked" name="trabajador_sena"></input>Directivos</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="11" disabled="disabled" name="trabajador_sena"></input>Directivos</td>
                            <?php } ?>
                            
                        </tr>
                    </table></center>
                    </br>
                    <table>
                        <tr><th colspan="5">Tipo de Población</th></tr>
                        <tr>
                            <?php if($tpoblacion[0]==1){ ?>
                            <td><input type="radio" value="1" disabled="disabled" checked="checked" name="poblacion"></input>ABANDONO O DESPOJO FORZADO DE TIERRAS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="1" disabled="disabled" name="poblacion"></input>ABANDONO O DESPOJO FORZADO DE TIERRAS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==13){ ?>
                            <td><input type="radio" value="13" disabled="disabled" checked="checked" name="poblacion"></input>HERIDO</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="13" disabled="disabled"  name="poblacion"></input>HERIDO</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==2){ ?>
                            <td><input type="radio" value="2" disabled="disabled" checked="checked" name="poblacion"></input>ADOLESCENTE DESVINCULADO DE GRUPOS ARMADOS ORGANIZADOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="2" disabled="disabled" name="poblacion"></input>ADOLESCENTE DESVINCULADO DE GRUPOS ARMADOS ORGANIZADOS</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==14){ ?>
                            <td><input type="radio" value="14" disabled="disabled" checked="checked" name="poblacion"></input>INDIGENAS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="14" disabled="disabled"  name="poblacion"></input>INDIGENAS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==3){ ?>
                            <td><input type="radio" value="3" disabled="disabled" checked="checked" name="poblacion"></input>ADOLESCENTE TRABAJADOR</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="3" disabled="disabled"  name="poblacion"></input>ADOLESCENTE TRABAJADOR</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==15){ ?>
                            <td><input type="radio" value="15" disabled="disabled" checked="checked" name="poblacion"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="15" disabled="disabled"  name="poblacion"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==4){ ?>
                            <td><input type="radio" value="4" disabled="disabled" checked="checked" name="poblacion"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="4" disabled="disabled" name="poblacion"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==16){ ?>
                            <td><input type="radio" value="16" disabled="disabled" checked="checked" name="poblacion"></input>JOVENES VULNERABLES</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="16" disabled="disabled" name="poblacion"></input>JOVENES VULNERABLES</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==5){ ?>
                            <td><input type="radio" value="5" disabled="disabled" checked="checked" name="poblacion"></input>AMENAZA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="5" disabled="disabled" name="poblacion"></input>AMENAZA</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==17){ ?>
                            <td><input type="radio" value="17" disabled="disabled" checked="checked" name="poblacion"></input>MINAS ANTIPERSONAL,MUNICION SIN EXPLOTAR,Y ARTEFACTO EXPLOSIVO IMPROVISADO </td>
                            <?php }else{ ?>
                            <td><input type="radio" value="17" disabled="disabled" name="poblacion"></input>MINAS ANTIPERSONAL,MUNICION SIN EXPLOTAR,Y ARTEFACTO EXPLOSIVO IMPROVISADO </td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==6){ ?>
                            <td><input type="radio" value="6" disabled="disabled" checked="checked" name="poblacion"></input>DELITOS CONTRA LA LIBERTAD Y  LA INTEGRIDAD SEXUAL EN DESARROLLO DEL CONFLICTO ARMADO</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="6" disabled="disabled" name="poblacion"></input>DELITOS CONTRA LA LIBERTAD Y  LA INTEGRIDAD SEXUAL EN DESARROLLO DEL CONFLICTO ARMADO</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==18){ ?>
                            <td><input type="radio" value="18" disabled="disabled" checked="checked" name="poblacion"></input>NEGRITUDES</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="18" disabled="disabled" name="poblacion"></input>NEGRITUDES</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==7){ ?>
                            <td><input type="radio" value="7" disabled="disabled" checked="checked" name="poblacion"></input>DESPLAZADOS DISCAPACITADOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="7" disabled="disabled" name="poblacion"></input>DESPLAZADOS DISCAPACITADOS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==19){ ?>
                            <td><input type="radio" value="19" disabled="disabled" checked="checked" name="poblacion"></input>PERSONAS EN PROCESO DE REINTEGRACION</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="19" disabled="disabled" name="poblacion"></input>PERSONAS EN PROCESO DE REINTEGRACION</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==8){ ?>
                            <td><input type="radio" value="8" disabled="disabled" checked="checked" name="poblacion"></input>DESPLAZADOS POR FENOMENOS NATURALEZ CABEZA DE FAMILIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="8" disabled="disabled" name="poblacion"></input>DESPLAZADOS POR FENOMENOS NATURALEZ CABEZA DE FAMILIA</td>
                            <?php } ?>
                        </tr>    
                        <tr>
                            <?php if($tpoblacion[0]==20){ ?>
                            <td><input type="radio" value="20" disabled="disabled" checked="checked" name="poblacion"></input>RECLUTAMIENTO FORZADO</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="20" disabled="disabled" name="poblacion"></input>RECLUTAMIENTO FORZADO</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==9){ ?>
                            <td><input type="radio" value="9" disabled="disabled" checked="checked" name="poblacion"></input>DESPLAZADOS POR LA VIOLENCIA CABEA DE FAMILIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="9" disabled="disabled" name="poblacion"></input>DESPLAZADOS POR LA VIOLENCIA CABEA DE FAMILIA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==21){ ?>
                            <td><input type="radio" value="21" disabled="disabled" checked="checked" name="poblacion"></input>REMITIDOS POR EL PAL</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="21" disabled="disabled" name="poblacion"></input>REMITIDOS POR EL PAL</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==10){ ?>
                            <td><input type="radio" value="10" disabled="disabled"  checked="checked" name="poblacion"></input>DISCAPACITADO LIMITACION AUDITIVA O SORDA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="10" disabled="disabled" name="poblacion"></input>DISCAPACITADO LIMITACION AUDITIVA O SORDA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==22){ ?>
                            <td><input type="radio" value="22" disabled="disabled" checked="checked" name="poblacion"></input>SECUESTRO</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="22" disabled="disabled" name="poblacion"></input>SECUESTRO</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==11){ ?>
                            <td><input type="radio" value="11" disabled="disabled" checked="checked" name="poblacion"></input>DISCAPACITADO LIMITACION VISUAL O CIEGA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="11" disabled="disabled" name="poblacion"></input>DISCAPACITADO LIMITACION VISUAL O CIEGA</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==23){ ?>
                            <td><input type="radio" value="23" disabled="disabled" checked="checked" name="poblacion"></input>SOLDADOS CAMPESINOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="23" disabled="disabled" name="poblacion"></input>SOLDADOS CAMPESINOS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==12){ ?>
                            <td><input type="radio" value="12" disabled="disabled" checked="checked" name="poblacion"></input>DISCAPACITADOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="12" disabled="disabled" name="poblacion"></input>DISCAPACITADOS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==24){ ?>
                            <td><input type="radio" value="24" disabled="disabled" checked="checked" name="poblacion"></input>TORTURA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="24" disabled="disabled" name="poblacion"></input>TORTURA</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==25){ ?>
                            <td><input type="radio" value="25" disabled="disabled" checked="checked" name="poblacion"></input>ACTOS TERRORISTA/ATENTADOS/COMBATES/ENFRENTAMIENTOS/HOSTIGAMIENTOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="25" disabled="disabled" name="poblacion"></input>ACTOS TERRORISTA/ATENTADOS/COMBATES/ENFRENTAMIENTOS/HOSTIGAMIENTOS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==37){ ?>
                            <td><input type="radio" value="37" disabled="disabled" checked="checked" name="poblacion"></input>HOMICIDIO/MASACRE</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="37" disabled="disabled" name="poblacion"></input>HOMICIDIO/MASACRE</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==26){ ?>
                            <td><input type="radio" value="26" disabled="disabled" checked="checked" name="poblacion"></input>ADOLESCENTE EN CONFLICTO CON LA LEY PENAL</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="26" disabled="disabled" name="poblacion"></input>ADOLESCENTE EN CONFLICTO CON LA LEY PENAL</td>
                            <?php } ?>
                        </tr>    
                        <tr>
                            <?php if($tpoblacion[0]==38){ ?>
                            <td><input type="radio" value="38" disabled="disabled" checked="checked" name="poblacion"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="38" disabled="disabled" name="poblacion"></input>INDIGENAS DESPLAZADOS POR LA VIOLENCIA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==27){ ?>
                            <td><input type="radio" value="27" disabled="disabled" checked="checked" name="poblacion"></input>AFROCOLOMBIANOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="27" disabled="disabled" name="poblacion"></input>AFROCOLOMBIANOS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==39){ ?>
                            <td><input type="radio" value="39" disabled="disabled" checked="checked" name="poblacion"></input>INPEC</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="39" disabled="disabled" name="poblacion"></input>INPEC</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==28){ ?>
                            <td><input type="radio" value="28" disabled="disabled"  checked="checked" name="poblacion"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="28" disabled="disabled" name="poblacion"></input>AFROCOLOMBIANOS DESPLAZADOS POR LA VIOLENCIA CABEZA DE FAMILIA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==40){ ?>
                            <td><input type="radio" value="40" disabled="disabled" checked="checked" name="poblacion"></input>MICROEMPRESAS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="40" disabled="disabled" name="poblacion"></input>MICROEMPRESAS</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==29){ ?>
                            <td><input type="radio" value="29" disabled="disabled" checked="checked" name="poblacion"></input>ARTESANOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="29" disabled="disabled" name="poblacion"></input>ARTESANOS</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==41){ ?>
                            <td><input type="radio" value="41" disabled="disabled" checked="checked" name="poblacion"></input>MUJER CABEZA DE FAMILIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="41" disabled="disabled" name="poblacion"></input>MUJER CABEZA DE FAMILIA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==30){ ?>
                            <td><input type="radio" value="30" disabled="disabled" checked="checked" name="poblacion"></input>DESAPARICION FORZADA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="30" disabled="disabled" name="poblacion"></input>DESAPARICION FORZADA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==42){ ?>
                            <td><input type="radio" value="42" disabled="disabled" checked="checked" name="poblacion"></input>PALENQUEROS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="42" disabled="disabled" name="poblacion"></input>PALENQUEROS</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==31){ ?>
                            <td><input type="radio" value="31" disabled="disabled" checked="checked" name="poblacion"></input>DESPLAZADOS POR FENOMENOS NATURALES</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="31" disabled="disabled" name="poblacion"></input>DESPLAZADOS POR FENOMENOS NATURALES</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==43){ ?>
                            <td><input type="radio" value="43" disabled="disabled" checked="checked" name="poblacion"></input>RAIZALES</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="43" disabled="disabled" name="poblacion"></input>RAIZALES</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==32){ ?>
                            <td><input type="radio" value="32" disabled="disabled" checked="checked" name="poblacion"></input>DESPLAZADOS POR LA VIOLENCIA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="32" disabled="disabled" name="poblacion"></input>DESPLAZADOS POR LA VIOLENCIA</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==44){ ?>
                            <td><input type="radio" value="44" disabled="disabled" checked="checked"  name="poblacion"></input>REMITIDOS POR EL CIE</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="44" disabled="disabled" name="poblacion"></input>REMITIDOS POR EL CIE</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==33){ ?>
                            <td><input type="radio" value="33" disabled="disabled" checked="checked" name="poblacion"></input>DISCAPACITADO COGNITIVO</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="33" disabled="disabled"  name="poblacion"></input>DISCAPACITADO COGNITIVO</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==45){ ?>
                            <td><input type="radio" value="45" disabled="disabled" checked="checked" name="poblacion"></input>ROM</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="45" disabled="disabled" name="poblacion"></input>ROM</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==34){ ?>
                            <td><input type="radio" value="34" disabled="disabled" checked="checked" name="poblacion"></input>DISCAPACITADO LIMITACION FISICA O MOTORA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="34" disabled="disabled" name="poblacion"></input>DISCAPACITADO LIMITACION FISICA O MOTORA</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==46){ ?>
                            <td><input type="radio" value="46" disabled="disabled"  checked="checked" name="poblacion"></input>SOBREVIVIENTES MINAS ANTIPERSONALES</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="46" disabled="disabled" name="poblacion"></input>SOBREVIVIENTES MINAS ANTIPERSONALES</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==35){ ?>
                            <td><input type="radio" value="35" disabled="disabled" checked="checked" name="poblacion"></input>DISCAPACITADO MENTAL</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="35" disabled="disabled" name="poblacion"></input>DISCAPACITADO MENTAL</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==47){ ?>
                            <td><input type="radio" value="47" disabled="disabled" checked="checked" name="poblacion"></input>TERCERA EDAD</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="47" disabled="disabled" name="poblacion"></input>TERCERA EDAD</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==36){ ?>
                            <td><input type="radio" value="36" disabled="disabled" checked="checked" name="poblacion"></input>EMPRENDEDORES</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="36" disabled="disabled" name="poblacion"></input>EMPRENDEDORES</td>
                            <?php } ?>
                            <?php if($tpoblacion[0]==48){ ?>
                            <td><input type="radio" value="48" disabled="disabled" checked="checked" name="poblacion"></input>VINCULADO DE NIÑOS,NIÑAS Y ADOLESCENTES A ACTIVIDADES RELACIONADA CON GRUPOS ARMADOS</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="48" disabled="disabled" name="poblacion"></input>VINCULADO DE NIÑOS,NIÑAS Y ADOLESCENTES A ACTIVIDADES RELACIONADA CON GRUPOS ARMADOS</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if($tpoblacion[0]==49){ ?>
                            <td><input type="radio" value="49" disabled="disabled" checked="checked" name="poblacion" ></input>NINGUNA</td>
                            <?php }else{ ?>
                            <td><input type="radio" value="49" disabled="disabled" name="poblacion" ></input>NINGUNA</td>
                            <?php } ?>
                        </tr>
                    </table>
            </br>
            <?php
                echo "<h3>Nota: Esta información se va a compartir con la agencia pública de empleo.<h3/>";
            ?>
            <table>
                <tr>
                    <th colspan="5">Normas de Competencia Laboral en las que desea Certificarse</th>
                </tr>
                <tr>
                    <th>Id Norma</th><th>Código de la NCL</th><th>Vrs NCL</th><th>Título de la NCL</th><th>Verificar Estado</th>
                </tr>
                <tr>
            
            <?php
            $proyecto=$_GET['proyecto'];
            $eva=$_GET['eva'];
            $idnorma=$_GET['norma'];
            $g=$_GET['grupo'];
            $idca=$_GET['idca'];
                        $query = "select 
codigo_norma,
version_norma,
titulo_norma
from norma where id_norma='$idnorma'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
            
                                    <td><?php echo $idnorma; ?></td>
                                    <td><?php echo $row["CODIGO_NORMA"]; ?></td>
                                    <td><?php echo $row["VERSION_NORMA"]; ?></td>
                                    <td><?php echo utf8_encode($row["TITULO_NORMA"]); ?></td>
                                    <td>
                                        <?php 
                                        if($tdoc[0]==null || $documento[0]==null || $expedicion[0]==null ||$pape[0]==null  ||$nombre[0]==null ||$fnacimiento[0]==null||$depto[0]==null ||$tsexo[0]==null ||$tsangre[0]==null ||$deptov[0]==null ||$barrio[0]==null ||$direccion[0]==null ||$celular[0]==null ||$civil[0]==null ||$estrato[0]==null ||$escolaridad[0]==null ||$email[0]==null ||$claboral[0]==null){
                                            echo  "<font color=red>Faltán algunos datos, no puede verificar la inscripción.</font> <br/><a href='actualizar_ficha.php?id=$idca'>Actualizar datos</a><br/>";
                                            echo "falta: ";
                                            $faltantes="";
                                            if($tdoc[0]==null ){
                                                    $faltantes.="Tipo de documento, ";
                                            }
                                            if($documento[0]==null ){
                                                    $faltantes.= "Documento, ";
                                            }
                                            if($expedicion[0]==null ){
                                                    $faltantes.= "Expedicion, ";
                                            }
                                            if($pape[0]==null ){
                                                    $faltantes.= "Primer apellido, ";
                                            }
                                            
                                            if($nombre[0]==null ){
                                                    $faltantes.= "Nombre, ";
                                            }
                                            if($fnacimiento[0]==null){
                                                    $faltantes.= "Fecha de nacimiento, ";
                                            }
                                            if($depto[0]==null ){
                                                    $faltantes.= "Departamento de nacimiento, ";
                                            }
                                            if($tsexo[0]==null ){
                                                    $faltantes.= "Sexo, ";
                                            }
                                            if($tsangre[0]==null ){
                                                    $faltantes.= "Sangre, ";
                                            }
                                            if($deptov[0]==null ){
                                                    $faltantes.= "Deptartamento de domicilio, ";
                                            }
                                            if($barrio[0]==null ){
                                                    $faltantes.= "Barrio, ";
                                            }
                                            if($direccion[0]==null ){
                                                    $faltantes.= "Dirección, ";
                                            }
                                            if($celular[0]==null ){
                                                    $faltantes.= "Celular, ";
                                            }
                                            if($civil[0]==null ){
                                                    $faltantes.= "Estado civil, ";
                                            }
                                            if($estrato[0]==null ){
                                                    $faltantes.= "Estrato, ";
                                            }
                                            if($escolaridad[0]==null ){
                                                    $faltantes.= "Escolaridad, ";
                                            }
                                            if($email[0]==null ){
                                                    $faltantes.= "Email, ";
                                            }
                                            if($claboral[0]==null){
                                                    $faltantes.= "Condición laboral, ";
                                            }
                                            echo substr($faltantes,0, strlen($faltantes)-2).".";
                                        }else{
                                            ?>
                                        <a href="verificar_inscripcion_l.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>&idca=<?php echo $idca ?>">Verificar</a></td>
                                    <?php
                                        }?>   
                                </tr>
                                 <?php
                            $numero++;
                        }
                        ?>
                            </table>
                           
                <br>
                <center><strong>Declaración de Aceptación de Condiciones</strong></center>
                <p align="justify" style="font-size: 8px ">
                He  leído  y comprendido y por ello firmo  el presente documento como evidencia de aceptación de los requisitos especificados que debo cumplir para acceder a optar por la Certificación, en caso de no cumplir  las condiciones dadas por la Norma, Titulación, perfil y /o esquema de Certificación para la cual me presente, reconozco que no seré admitido y/o certificado  en el proceso; BAJO LA GRAVEDAD DE JURAMENTO declaro al Servicio Nacional de Aprendizaje SENA que la información suministrada es veraz y puede ser verificada por el SENA durante todo el proceso; Igualmente declaro que vengo  libremente  ante  el  SENA  para acceder  al proceso de Certificación de Competencia Laboral, que estoy solicitando.
Autorizo a entregar la información de este proceso a las entidades y autoridades que lo soliciten, como también a que el SENA  utilice  la información suministrada en mi proceso de evaluación para generar datos estadísticos e indicadores.
Manifiesto que el SENA  proporcionó la descripción vigente y detallada del proceso de certificación, incluidos  los documentos con los requisitos para la certificación, los derechos y deberes de los usuarios y/o aspirante y/o candidato.
Conozco y acepto las anteriores disposiciones, y hago oficial mi solicitud para ser candidato en la Norma, Titulación, perfil y/o  esquema de certificación de ________________________________
                </p>
            </form>
<!--            <center><br>
            <input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
            </center>-->
        </div>
 	<?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>