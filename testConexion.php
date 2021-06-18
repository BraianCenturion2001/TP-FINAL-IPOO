<?php

include_once 'BaseDatos.php';
$baseDeDatos = new BaseDatos();
$conexion = $baseDeDatos->Iniciar();

if($conexion){
    echo "LA CONEXION ES EXITOSA!!! \n";
}else{
    $errorCarga = $baseDeDatos->getError();
    echo $errorCarga;
}


?>