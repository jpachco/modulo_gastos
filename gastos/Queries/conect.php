<?php
$usuario= 'magil';
$pass = 'Marcoo0';
$servidor = '190.27.1.13\BI';



$basedatosmf = 'dbdistribucion';
global $conexionmf;
$infomf = array('Database'=>$basedatosmf, 'UID'=>$usuario, 'PWD'=>$pass);
$conexionmf =sqlsrv_connect($servidor, $infomf) or die("no se establecio conexion");


$basedatosrb = 'dbRoberts';
global $conexionrb;
$inforb = array('Database'=>$basedatosrb, 'UID'=>$usuario, 'PWD'=>$pass);
$conexionrb =sqlsrv_connect($servidor, $inforb) or die("no se establecio conexion");


$basedatoshl = 'dbhighlife';
global $conexionhl;
$infohl = array('Database'=>$basedatoshl, 'UID'=>$usuario, 'PWD'=>$pass);
$conexionhl =sqlsrv_connect($servidor, $infohl) or die("no se establecio conexion");
