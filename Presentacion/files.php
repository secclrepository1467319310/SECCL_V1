<?php
$directorio = "../";

if (isset($_GET[file])) {
    if (is_file($_GET[file])) {
//        echo "hola";
//        $file = fopen($_GET[file], "r");
////        var_dump(fread($file, filesize($_GET[file])));
//        echo fread($file, filesize($_GET[file]));
//        fclose($file);
        $fichero = $_GET[file];
        if (file_exists($fichero)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($fichero) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fichero));
            readfile($fichero);
            exit;
        }
    } else {
        $directorio = $_GET[file] . "/";
        $ficheros1 = scandir($directorio);
//$ficheros2  = scandi  r($directorio, 1);
        echo "<pre>";
//        print_r($ficheros1);
        for ($i = 0; $i < count($ficheros1); $i++) {
            echo "<a href='?file=$directorio" . "$ficheros1[$i]'>" . $ficheros1[$i] . "<a><br/>";
        }
    }
} else {
    $directorio = '../';
    $ficheros1 = scandir($directorio);
//$ficheros2  = scandi  r($directorio, 1);
    echo "<pre>";
//    print_r($ficheros1);
    for ($i = 0; $i < count($ficheros1); $i++) {
        echo "<a href='?file=$directorio" . "$ficheros1[$i]'>" . $ficheros1[$i] . "<a><br/>";
    }
}
if (isset($_POST[type])) {
//    echo "hola1";
    if ($_POST[type] == 1) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $nombreDirectorio = $directorio;
            $nombreFichero = $_FILES['file']['name'];

            $nombreCompleto = $nombreDirectorio . $nombreFichero;
            echo $nombreCompleto;
            if (is_file($nombreCompleto)) {
//            $idUnico = time();
//            $nombreFichero = $idUnico . "-" . $nombreFichero;
            }

            move_uploaded_file($_FILES['file']['tmp_name'], $nombreDirectorio . $nombreFichero);
            echo "<script>window.location.href=window.location.href</script>";
        } else
            print ("No se ha podido subir el fichero");
    }
    if ($_POST[type] == 2) {        
        mkdir("$directorio"."$_POST[directory]", 0700);
        echo "<script>window.location.href=window.location.href</script>";
    }
}
?>
<form enctype="multipart/form-data" method="POST">
    <input type='hidden' name='type' value='1'/>
    <input type='file' name='file' />
    <input type='submit'/>
</form>
<form method="POST">
    <input type='hidden' name='type' value='2'/>
    <input type='text' name='directory' />
    <input type='submit'/>    
</form>