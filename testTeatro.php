<?php

include 'Teatro.php';
include 'Funcion.php';
include 'FuncionTeatro.php';
include 'Musical.php';
include 'Cine.php';

function crearTeatro(){
    echo "INGRESE EL NOMBRE DEL NUEVO TEATRO: ";
    $nombre = trim(fgets(STDIN));
    echo "INGRESE LA DIRECCIÓN DEL NUEVO TEATRO: ";
    $direccion = trim(fgets(STDIN));

    $teatro = new Teatro ($nombre, $direccion);

    $respuestaInsertar = $teatro->insertar();

    if ($respuestaInsertar){
        echo "CREACION DEL TEATRO EXITOSA!!! \n";
        echo $teatro;
    } else {
        echo "ERROR EN LA CARGA! ".$teatro->getmensajeoperacion()."\n";
    }
}

function modificarTeatro($objTeatro){
    echo "------------------ INFORMACIÓN ACTUAL --------------------- \n";
    echo "NOMBRE DEL TEATRO: ".$objTeatro->getNombre()."\n";
    echo "DIRECCIÓN DEL TEATRO: ".$objTeatro->getDireccion()."\n";

    echo "------------------- NUEVA INFORMACIÓN -------------------- \n";
    echo "INGRESE NOMBRE: ";
    $nuevoNombre = trim(fgets(STDIN));
    echo "INGRESE DIRECCIÓN: ";
    $nuevaDire = trim(fgets(STDIN));

    $objTeatro->cargar($nuevoNombre, $nuevaDire);

    $respuestaModificar = $objTeatro->modificar();

    if ($respuestaModificar){        
        echo "---------------- TEATRO ".$objTeatro->getId()." MODIFICADO -------------------- \n";
        echo $objTeatro;
    } else {
        echo "MODIFICACÓN ERRONEA! ".$objTeatro->getmensajeoperacion()."\n";
    }
}

function crearFuncion($teatro){
    echo "------------------ FUNCIÓN -------------------- \n";
    echo "INGRESE EL NOMBRE DE LA FUNCIÓN: ";
    $nombreFuncion = trim(fgets(STDIN));
    echo "INGRESE EL HORARIO DE INICIO DE LA FUNCIÓN: ";
    $horarioFuncion = trim(fgets(STDIN));
    echo "INGRESE LA DURACIÓN DE LA FUNCIÓN: ";
    $duracionFuncion = trim(fgets(STDIN));
    echo "INGRESE EL COSTO DE LA FUNCIÓN: ";
    $costoFuncion = trim(fgets(STDIN));
    echo "---------------------------------------------- \n";

    //$funcionNueva = new Funcion($teatro, $nombreFuncion, $horarioFuncion, $duracionFuncion, $costoFuncion);
    //$respFuncion = $funcionNueva->insertar();

    //if($respFuncion){
       // $idFuncion = $funcionNueva->getId();

        $arrayInfo = array('teatro'=>$teatro, 'nombre'=>$nombreFuncion, 'horario'=>$horarioFuncion, 'duracion'=>$duracionFuncion, 'costo'=>$costoFuncion);

        echo "ELIJA DE QUE TIPO SERÁ LA FUNCIÓN: \n";
        echo "( 1 ) FUNCIÓN DE TEATRO \n";
        echo "( 2 ) MUSICAL \n";
        echo "( 3 ) CINE \n";
        $opcionFuncion = trim(fgets(STDIN));

        if ($opcionFuncion==1){
            crearFuncionTeatro($arrayInfo);
        } elseif ($opcionFuncion==2){
            crearMusical($arrayInfo);
        } elseif ($opcionFuncion==3){
            crearCine($arrayInfo);
        } else {
            echo "OPCIÓN ERRONEA!!! \n";
        }
    //}
}

function crearFuncionTeatro($objFuncion){
    echo "------------------- FUNCIÓN DE TEATRO -------------------- \n";
    $funcionTeatro = new FuncionTeatro($objFuncion['teatro'], $objFuncion['nombre'], $objFuncion['horario'], $objFuncion['duracion'], $objFuncion['costo']);

    $respuestaInsertar = $funcionTeatro->insertar();

    if ($respuestaInsertar){
        echo "FUNCIÓN AÑADIDA CON ÉXITO!!! \n";
        echo $funcionTeatro;
    } else {
        echo "FUNCIÓN NO AÑADIDA ".$funcionTeatro->getmensajeoperacion()."\n";
    }
}

function crearMusical($objFuncion){
    echo "------------------- MUSICAL -------------------- \n";
    echo "INGRESE EL NOMBRE DEL DIRECTOR DEL MUSICAL: ";
    $director = trim(fgets(STDIN));
    echo "INGRESE LA CANTIDAD DE PERSONAS QUE ASISTIRAN AL MUSICAL: ";
    $cantPersonas = trim(fgets(STDIN));
    echo "---------------------------------------------- \n";

    $musical = new Musical($objFuncion['teatro'], $objFuncion['nombre'], $objFuncion['horario'], $objFuncion['duracion'], $objFuncion['costo'], $director, $cantPersonas);

    $respuestaInsertar = $musical->insertar();

    if ($respuestaInsertar){
        echo "FUNCIÓN AÑADIDA CON ÉXITO!!! \n";
        echo $musical;
    } else {
        echo "FUNCIÓN NO AÑADIDA ".$musical->getmensajeoperacion()."\n";
    }
}

function crearCine($objFuncion){
    echo "------------------ CINE ----------------------- \n";
    echo "INGRESE EL GÉNERO DE LA PELÍCULA: ";
    $genero = trim(fgets(STDIN));
    echo "INGRESE EL PAÍS DE ORIGEN DE LA PELÍCULA: ";
    $pais = trim(fgets(STDIN));
    echo "---------------------------------------------- \n";

    $cine = new Cine($objFuncion['teatro'], $objFuncion['nombre'], $objFuncion['horario'], $objFuncion['duracion'], $objFuncion['costo'], $genero, $pais);
    
    $respuestaInsertar = $cine->insertar();

    if ($respuestaInsertar){
        echo "CINE AÑADIDO CON ÉXITO!!! \n";
        echo $cine;
    } else {
        echo "CINE NO AÑADIDO ".$cine->getmensajeoperacion()."\n";
    }
}

function modificarFuncion($objFuncion){
    echo "------------------ INFORMACIÓN ACTUAL --------------------- \n";
    echo "NOMBRE DE LA FUNCIÓN: ".$objFuncion->getNombre()."\n";
    echo "HORARIO DE INICIO DE LA FUNCIÓN: ".$objFuncion->getHorarioInicio()."\n";
    echo "DURACIÓN DE LA FUNCIÓN: ".$objFuncion->getDuracion()."\n";
    echo "COSTO DE LA FUNCIÓN: ".$objFuncion->getCosto()."\n";

    echo "------------------- NUEVA INFORMACIÓN -------------------- \n";
    echo "INGRESE EL NOMBRE: ";
    $nuevoNombre = trim(fgets(STDIN));
    echo "INGRESE EL HORARIO DE INICIO: ";
    $nuevoHorario = trim(fgets(STDIN));
    echo "INGRESE LA DURACIÓN: ";
    $nuevaDuracion = trim(fgets(STDIN));
    echo "INGRESE EL COSTO: ";
    $nuevoCosto = trim(fgets(STDIN));

    $objFuncion->cargar($nuevoNombre, $nuevoHorario, $nuevaDuracion, $nuevoCosto);

    $respuestaModificar = $objFuncion->modificar();

    if ($respuestaModificar){
        echo "---------------- FUNCIÓN ".$objFuncion->getId()." MODIFICADA -------------------- \n";
        echo $objFuncion;
    } else {
        echo "MODIFICACÓN ERRONEA! ".$objFuncion->getmensajeoperacion()."\n";
    }
}

function mostrarFuncion($arreglo){
    $contador = 1;
    if (count($arreglo)<1){
        echo "#################### SIN FUNCIONES #################### \n";
    } else {
        foreach($arreglo as $funcionActual){
            echo "·········· FUNCIÓN Nº: ".$contador." ·········· \n";
            echo $funcionActual;
            $contador ++;
        }
    }
}


//PROGRAMA PRINCIPAL

//Creo un teatro y una funcion vacia 
$teatroVacio = new Teatro('', '');
$funcionVacia = new Funcion('', '', '', '', '');

$funcionTeatroVacio = new FuncionTeatro('', '', '', '', '');
$funcionCineVacio = new Cine('', '', '', '', '', '', '');
$funcionMusicalVacio = new Musical('', '', '', '', '', '', '');

do{
    echo "-------------------- MENÚ PRINCIPAL -------------------- \n";
    echo "----------------------- TEATROS ------------------------ \n";
    echo "( 1 ) CREAR UN TEATRO \n";
    echo "( 2 ) MODIFICAR UN TEATRO \n";
    echo "( 3 ) ELIMINAR UN TEATRO \n";
    echo "( 4 ) LISTAR TEATROS \n";
    echo "---------------------- FUNCIONES ----------------------- \n";
    echo "( 5 ) CREAR UNA FUNCIÓN \n";
    echo "( 6 ) MODIFICAR UNA FUNCIÓN \n";
    echo "( 7 ) ELIMINAR UNA FUNCIÓN \n";
    echo "( 8 ) LISTAR FUNCIONES \n";
    echo "----------------------- OTROS -------------------------- \n";
    echo "( 9 ) DAR COSTOS \n";
    echo "( 10 ) SALIR \n";
    echo "SELECCIONE UNA OPCIÓN: ";
    $respuesta = trim(fgets(STDIN));

    switch($respuesta){
        case '1':
            crearTeatro();
        break;
        case '2':
            $coleccionTeatros = $teatroVacio->listar("");
            $numero = 1;
            if (count($coleccionTeatros)<1){
                echo "########## NO HAY TEATROS ########## \n";
            }else{
                echo "########## COLECCION TEATROS ########## \n";
                foreach($coleccionTeatros as $teatroActual){
                    echo "·········· TEATRO Nº: ".$numero." ·········· \n";
                    echo $teatroActual;
                    $numero ++;
                }
                echo "------------------------------------------------ \n";
                echo "INGRESE EL ID DEL TEATRO A MODIFICAR: ";
                $idBuscar = trim(fgets(STDIN));

                $respuestaBuscar = $teatroVacio->buscar($idBuscar); //Si lo encuentra setea los datos

                if ($respuestaBuscar){
                    echo "TEATRO ENCONTRADO!!! \n";
                    modificarTeatro($teatroVacio);
                } else {
                    echo "BUSQUEDA ERRÓNEA ".$teatroVacio->getmensajeoperacion()."\n";
                }
            }
        break;
        case '3':
            $coleccionTeatros = $teatroVacio->listar("");
            $numero = 1;
            if (count($coleccionTeatros)<1){
                echo "########## NO HAY TEATROS ########## \n";
            }else{
                echo "########## COLECCION TEATROS ########## \n";
                foreach($coleccionTeatros as $teatroActual){
                    echo "·········· TEATRO Nº: ".$numero." ·········· \n";
                    echo $teatroActual;
                    $numero ++;
                }
                echo "------------------------------------------------ \n";
                echo "INGRESE EL ID DEL TEATRO A ELIMINAR: ";
                $idEliminar = trim(fgets(STDIN));

                $respuestaBuscar = $teatroVacio->buscar($idEliminar); //Si lo encuentra setea los datos

                if ($respuestaBuscar){
                    echo "TEATRO ENCONTRADO!!! \n";
                    $respuestaEli = $teatroVacio->eliminar();

                        if ($respuestaEli){
                            echo "ELIMINACIÓN EXITOSA!!! \n";
                        } else {
                            echo "ELIMINACIÓN ERRONEA! ".$teatroVacio->getmensajeoperacion()."\n";
                        }
                } else {
                    echo "BUSQUEDA ERRÓNEA ".$teatroVacio->getmensajeoperacion()."\n";
                }
            }
        break;
        case '4':
            $coleccionTeatros = $teatroVacio->listar("");
            $numero = 1;
            if (count($coleccionTeatros)<1){
                echo "########## NO HAY TEATROS ########## \n";
            }else{
                echo "########## COLECCION TEATROS ########## \n";
                foreach($coleccionTeatros as $teatroActual){
                    echo "·········· TEATRO Nº: ".$numero." ·········· \n";
                    echo $teatroActual;
                    $numero ++;
                }
            }
        break;
        case '5':
            $coleccionTeatros = $teatroVacio->listar("");
            $numero = 1;
            if (count($coleccionTeatros)<1){
                echo "########## NO HAY TEATROS ########## \n";
            }else{
                echo "########## COLECCION TEATROS ########## \n";
                foreach($coleccionTeatros as $teatroActual){
                    echo "·········· TEATRO Nº: ".$numero." ·········· \n";
                    echo $teatroActual;
                    $numero ++;
                }
            }
            echo "------------------------------------------------ \n";
            echo "INGRESE EL ID DEL TEATRO PARA AÑADIRLE UNA FUNCION: ";
            $idTeatro = trim(fgets(STDIN));

            $nuevoTeatro = new Teatro('', '');
            $respuestaBuscar = $nuevoTeatro->buscar($idTeatro); //Si lo encuentra setea los datos

            if ($respuestaBuscar){
                echo "TEATRO ENCONTRADO!!! \n";
                echo $nuevoTeatro;
                crearFuncion($nuevoTeatro);
            } else {
                echo "TEATRO NO ENCONTRADO, REVISE LA LISTA ".$nuevoTeatro->getmensajeoperacion()."\n";
            }
        break;
        case '6':
            echo "INGRESE EL TIPO DE FUNCIÓN QUE QUIERE MODIFICAR \n";
            echo "( 1 ) FUNCIÓN DE TEATRO \n";
            echo "( 2 ) CINE \n";
            echo "( 3 ) MUSICAL \n";
            echo "SELECCIONE UNA OPCIÓN: ";
            $tipo = trim(fgets(STDIN));

            if ($tipo==1){
                $coleccionFuncionesTeatro = $funcionTeatroVacio->listar("");
                mostrarFuncion($coleccionFuncionesTeatro);
                if (count($coleccionFuncionesTeatro)>0){
                    echo "------------------------------------------------ \n";
                    echo "INGRESE EL ID DE LA FUNCIÓN TEATRO A MODIFICAR: ";
                    $idFuncionBuscar = trim(fgets(STDIN));

                    $respuestaBuscar = $funcionVacia->buscar($idFuncionBuscar);

                    if($respuestaBuscar){
                        echo "FUNCIÓN ENCONTRADA!!! \n";
                        modificarFuncion($funcionVacia);
                    } else {
                        echo "BUSQUEDA ERRONEA! ".$funcionVacia->getmensajeoperacion()."\n";
                    }
                }
            } elseif ($tipo==2){
                $coleccionCine = $funcionCineVacio->listar("");
                mostrarFuncion($coleccionCine);
                if (count($coleccionCine)>0){
                    echo "------------------------------------------------ \n";
                    echo "INGRESE EL ID DEL MUSICAL A MODIFICAR: ";
                    $idFuncionBuscar = trim(fgets(STDIN));

                    $respuestaBuscar = $funcionVacia->buscar($idFuncionBuscar);

                    if($respuestaBuscar){
                        echo "FUNCIÓN ENCONTRADA!!! \n";
                        modificarFuncion($funcionVacia);
                    } else {
                        echo "BUSQUEDA ERRONEA! ".$funcionVacia->getmensajeoperacion()."\n";
                    }
                }
            } elseif ($tipo==3){
                $coleccionMusical = $funcionMusicalVacio->listar("");
                mostrarFuncion($coleccionMusical);
                if (count($coleccionMusical)>0){
                    echo "------------------------------------------------ \n";
                    echo "INGRESE EL ID DEL CINE A MODIFICAR: ";
                    $idFuncionBuscar = trim(fgets(STDIN));

                    $respuestaBuscar = $funcionVacia->buscar($idFuncionBuscar);

                    if($respuestaBuscar){
                        echo "FUNCIÓN ENCONTRADA!!! \n";
                        modificarFuncion($funcionVacia);
                    } else {
                        echo "BUSQUEDA ERRONEA! ".$funcionVacia->getmensajeoperacion()."\n";
                    }
                }
            }
        break;
        case '7':
            echo "INGRESE EL TIPO DE FUNCIÓN QUE QUIERE ELIMINAR \n";
            echo "( 1 ) FUNCIÓN DE TEATRO \n";
            echo "( 2 ) CINE \n";
            echo "( 3 ) MUSICAL \n";
            echo "SELECCIONE UNA OPCIÓN: ";
            $tipo = trim(fgets(STDIN));

            if ($tipo==1){
                $coleccionFuncionesTeatro = $funcionTeatroVacio->listar("");
                mostrarFuncion($coleccionFuncionesTeatro);
                if (count($coleccionFuncionesTeatro)>0){
                    echo "------------------------------------------------ \n";
                    echo "INGRESE EL ID DE LA FUNCION DE TEATRO A ELIMINAR: ";
                    $idEliminar = trim(fgets(STDIN));

                    $resp = $funcionVacia->buscar($idEliminar);

                    if($resp){
                        echo "FUNCIÓN ENCONTRADA!!! \n";
                        $resp2 = $funcionVacia->eliminar();
                        if ($resp2){
                            echo "ELIMINACIÓN COMPLETADA!!! \n";
                        }else{
                            echo "ERROR EN LA ELIMINACIÓN!!! ".$funcionTeatroVacio->getmensajeoperacion()."\n";
                        }
                    } else {
                        echo "ERROR EN LA BUSQUEDA!!! ".$funcionTeatroVacio->getmensajeoperacion()."\n";
                    }
                }
            } elseif ($tipo==2){
                $coleccionCine = $funcionCineVacio->listar("");
                mostrarFuncion($coleccionCine);
                if (count($coleccionCine)>0){
                    echo "------------------------------------------------ \n";
                    echo "INGRESE EL ID DEL CINE A ELIMINAR: ";
                    $idEliminar = trim(fgets(STDIN));

                    $resp = $funcionVacia->buscar($idEliminar);

                    if($resp){
                        echo "FUNCIÓN ENCONTRADA!!! \n";
                        $resp2 = $funcionVacia->eliminar();
                        if ($resp2){
                            echo "ELIMINACIÓN COMPLETADA!!! \n";
                        }else{
                            echo "ERROR EN LA ELIMINACIÓN!!! ".$funcionCineVacio->getmensajeoperacion()."\n";
                        }
                    } else {
                        echo "ERROR EN LA BUSQUEDA!!! ".$funcionCineVacio->getmensajeoperacion()."\n";
                    }
                }
            } elseif ($tipo==3){
                $coleccionMusical = $funcionMusicalVacio->listar("");
                mostrarFuncion($coleccionMusical);
                if (count($coleccionMusical)>0){
                    echo "------------------------------------------------ \n";
                    echo "INGRESE EL ID DEL CINE A ELIMINAR: ";
                    $idEliminar = trim(fgets(STDIN));

                    $resp = $funcionVacia->buscar($idEliminar);

                    if($resp){
                        echo "FUNCIÓN ENCONTRADA!!! \n";
                        $resp2 = $funcionVacia->eliminar();
                        if ($resp2){
                            echo "ELIMINACIÓN COMPLETADA!!! \n";
                        }else{
                            echo "ERROR EN LA ELIMINACIÓN!!! ".$funcionMusicalVacio->getmensajeoperacion()."\n";
                        }
                    } else {
                        echo "ERROR EN LA BUSQUEDA!!! ".$funcionMusicalVacio->getmensajeoperacion()."\n";
                    }
                }
            }
        break;
        case '8':
            $coleccionFuncionesTeatro = $funcionTeatroVacio->listar("");
            $coleccionMusical = $funcionMusicalVacio->listar("");
            $coleccionCine = $funcionCineVacio->listar("");

            echo "#################### COLECCION FUNCIONES DE TEATRO #################### \n";
            mostrarFuncion($coleccionFuncionesTeatro);

            echo "#################### COLECCION MUSICALES #################### \n";
            mostrarFuncion($coleccionMusical);
            
            echo "#################### COLECCION CINES #################### \n";
            mostrarFuncion($coleccionCine);
            
        break;
        case '9':
            echo "INGRESE EL ID DEL TEATRO QUE QUIERA CONOCER SUS COSTOS: ";
            $idTeatro = trim(fgets(STDIN));

            $resp = $teatroVacio->buscar($idTeatro);
            if ($resp){
                echo "TEATRO ENCONTRADO!!! \n";
                $costoFinal = $teatroVacio->darCostos($idTeatro);
                echo "EL PRECIO TOTAL A PAGAR POR EL TEATRO ".$idTeatro." ES DE: ".$costoFinal."\n";
            } else {
                echo "ERROR EN LA BÚSQUEDA!!! ".$teatroVacio->getmensajeoperacion()."\n";
            }
        break;
    }
} while ($respuesta <> 10);

echo "-------------------- MENÚ CERRADO ---------------------";

?>