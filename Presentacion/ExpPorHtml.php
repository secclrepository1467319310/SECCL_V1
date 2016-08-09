<?php
header('Content-Type: text/html; charset=utf-8');

header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=NOMBRE.xls");

echo utf8_decode($_GET[data]);
?>
