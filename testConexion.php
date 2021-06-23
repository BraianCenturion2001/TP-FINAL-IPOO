<?php

include_once 'BaseDatos.php';
$baseDeDatos = new BaseDatos();
$conexion = $baseDeDatos->Iniciar(); //Inicio la conexión

if($conexion){ //Compruebo si la conexión es exitosa
    echo "LA CONEXION ES EXITOSA!!! \n";
}else{
    $errorCarga = $baseDeDatos->getError();
    echo $errorCarga;
}
?>