<?php
    $result=null;
    if(isset($_POST[tipo])){
        extract($_POST);
        require_once("../Clase/conectar.php");
        $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
        $query = "select c.id_certificacion,
                    u.usuario_id,
                    u.documento,
                    TD.DESCRIPCION,
                    u.nombre,
                    u.primer_apellido,
                    u.segundo_apellido,
                    ec.estado
                    from usuario u
                    inner join proyecto_grupo pe
                    on pe.id_candidato=u.usuario_id
                    INNER JOIN TIPO_DOC TD ON U.TIPO_DOC = TD.ID_TIPO_DOC
                    join norma n on (n.id_norma=pe.id_norma)
                    left join certificacion c on ( c.id_candidato=u.usuario_id and c.id_norma=n.id_norma and c.id_proyecto =pe.id_proyecto)
                    join plan_evidencias ple on (ple.id_proyecto=pe.id_proyecto and ple.id_norma=n.id_norma and pe.n_grupo=ple.grupo)
                    left join evidencias_candidato ec on (
                        ec.id_plan=ple.id_plan and ec.id_norma=n.id_norma and ec.id_candidato=u.usuario_id
                    )
                    where  pe.id_proyecto='$proyecto' 
                    and n.codigo_norma='$norma' and u.documento='$cedula' order by u.primer_apellido asc ";
//        echo $query;
        $statement = oci_parse($connection, $query);
        oci_execute($statement);
        $n=  oci_fetch_all($statement, $result);

        $qNormaRegulada="select * from t_normas_reguladas where codigo_norma='$norma'";
        $sNormaRegulada = oci_parse($connection, $qNormaRegulada);
        oci_execute($sNormaRegulada);
        $nNormaRegulada=  oci_fetch_all($sNormaRegulada, $qNormaRegulada);
    }

?>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Comprobar certificado de los candidatos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container"> 
        <img src="http://seccl.sena.edu.co/_img/header.jpg" />
        <form action="" method="post" role="form">
            <div  class="form-group">
                <input type="hidden" name="tipo" value="1"/>
                <label for="norma">Norma:</label>
                <input class="form-control" type="number" required name="norma" value="<?= $_POST[norma]?>" id="norma"/><br/>
                <label for="cedula">Cédula:</label>
                <input class="form-control" type="number" required name="cedula" value="<?= $_POST[cedula]?>" id="cedula"/><br/>
                <label for="proyecto">Proyecto:</label>
                <input class="form-control" type="number" required name="proyecto" value="<?= $_POST[proyecto]?>" id="proyecto"/><br/>
                <input class="btn btn-info" type="submit"/>
            </div>
        </form>
        <?php 
        $nivel="";
//        var_dump($result);
        if($result[ESTADO][0]!=null){
            switch ($result[ESTADO][0]){
                
                case 0:
                    $nivel='SIN EVALUAR ';
                    break;
                case 1:
                    $nivel='COMPETENTE(NIVEL AVANZADO)';
                    break; 
                case 2: 
                    $nivel='AUN NO COMPETENTE';
                    break;
                case 3:
                    $nivel='NIVEL INTERMEDIO';
                    break;
                case 4:
                    $nivel='NIVEL BÁSICO';
                    break;
            }
            echo ' <div class="alert alert-success">
                    <strong>¡Nivel:'.$nivel.'!</strong>
                  </div>' ;
        }
        
        if($result[ID_CERTIFICACION][0]!=null){
            echo ' <div class="alert alert-success">
                    <strong>¡Certificado!</strong>
                  </div>' ;
        }else{
            echo ' <div class="alert alert-warning">
                    <strong>¡No Certificado!</strong>
                  </div>' ;           
            
        }
        if($nNormaRegulada>0){
            echo ' <div class="alert alert-warning">
                    <strong>¡Norma regulada!</strong>
                  </div>' ;
        }else{
                    
            
        }

        
        ?>
        </div>
    </body>
</html>
