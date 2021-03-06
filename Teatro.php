<?php

include_once 'BaseDatos.php';

class Teatro{
    private $idTeatro;
    private $nombre;
    private $direccion;
    private $mensajeoperacion;
	private $coleccionFunciones;

    public function __construct($nombre, $direccion){
        $this->nombre = $nombre;
        $this->direccion = $direccion;
    }

    public function getId(){
        return $this->idTeatro;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }
	public function getColeccionFunciones(){
		$id = $this->getId();
		
        $condicion = "funcion.idTeatro=".$id;

		$teatroFuncion = new FuncionTeatro('','','','','');
		$musical = new Musical('','','','','','','');
		$cine = new Cine('','','','','','','');

        $coleccionTeatro = $teatroFuncion->listar($condicion);
        $coleccionMusical = $musical->listar($condicion);
        $coleccionCine = $cine->listar($condicion);

		$coleccion = array_merge($coleccionTeatro, $coleccionMusical,$coleccionCine);

		return $coleccion;
	}

    public function setId($id){
        $this->idTeatro = $id;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }
    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }
	public function setColeccionFunciones($coleccionFunciones){
		$this->coleccionFunciones = $coleccionFunciones;
	}

	public function darCostosPorFuncion($tipo, $idTeatro){
		$acumCostos = 0;
		$base = new BaseDatos();

		//no comillas en tipo
		$consultaCostos = "SELECT funcion.costo from funcion INNER JOIN ".$tipo." ON funcion.idFuncion=".$tipo.".idFuncion WHERE funcion.idTeatro=".$idTeatro;

		if($base->Iniciar()){
            if($base->Ejecutar($consultaCostos)){
                $coleccionCostos = array();
				while($row2=$base->Registro()){
                    $costo = ($row2['costo']);
                    array_push($coleccionCostos, $costo);
				}
            }else{
                echo "ERROR EN LA EJECUCION DE LA BUSQUEDA DE PRECIO: " . $base->getError();
            }
        }else{
            echo "ERROR: " . $base->getError();
        }

		foreach($coleccionCostos as $costoActual){
			$acumCostos = $acumCostos + $costoActual;
		}

		return $acumCostos;

	}

	public function darCostos($id){
		$totalFuncionTeatro = 0;
		$totalMusical = 0;
		$totalCine = 0;

		//Recorro cada tipo de funci??n y traigo sus precios acumulados
		$precioFuncionTeatro = $this->darCostosPorFuncion('funcionTeatro',$id);
		$precioMusical = $this->darCostosPorFuncion('musical', $id);
		$precioCine = $this->darCostosPorFuncion('cine', $id);

		//Aplico el porcentaje extra
		$totalFuncionTeatro = ($precioFuncionTeatro + (($precioFuncionTeatro / 100) * 45));
		$totalMusical = ($precioMusical + (($precioMusical / 100) * 12));
		$totalCine = ($precioCine + (($precioCine / 100) * 65));

		//Obtengo el total
		$precioFinalTotal = $totalFuncionTeatro + $totalMusical + $totalCine;
		return $precioFinalTotal;
	}

	public function cargar($nombre, $direccion){
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }

    /**
	 * Recupera los datos de un teatro por id
	 * @param int $id
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idTeatro){
		$base=new BaseDatos();
		$consultaTeatro="SELECT * FROM teatro WHERE idTeatro=".$idTeatro;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaTeatro)){
				if($row2=$base->Registro()){
				    $this->setId($idTeatro);
					$this->setNombre($row2['nombre']);
					$this->setDireccion($row2['direccion']);
					$resp= true;
				}
		 	}else{
                $this->setmensajeoperacion($base->getError());
			}
		}else{
            $this->setmensajeoperacion($base->getError());
		}
        return $resp;
	}

    /**
     * Se genera una lista que ordena los teatros seg??n el nombre
     */
    public static function listar($condicion){
	    $arregloTeatro = null;
		$base = new BaseDatos();
		$consultaTeatro = "Select * from teatro ";
        if($condicion!=""){
            $consultaTeatro = $consultaTeatro.' where '.$condicion;
        }
		$consultaTeatro.="order by nombre";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaTeatro)){				
				$arregloTeatro= array();
				while($row2=$base->Registro()){
				    $idTeatro= ($row2['idTeatro']);

					$teatro = new Teatro('', '');
					$teatro->buscar($idTeatro);
					array_push($arregloTeatro, $teatro);
				}
		 	}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
            $this->setmensajeoperacion($base->getError());
		}
	    return $arregloTeatro;
	}
    
    public function insertar(){
		$base = new BaseDatos();
		$resp= false;
		$consultaInsertar = "INSERT INTO teatro(nombre, direccion) VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setId($id);
			    $resp = true;
			}else{
                $this->setmensajeoperacion($base->getError());
			}
		}else{
            $this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}

    public function modificar(){
	    $resp = false; 
	    $base = new BaseDatos();
		$idTeatro = $this->getId();
		$consultaModificar = "UPDATE teatro SET nombre='".$this->getNombre()."',direccion='".$this->getDireccion()."' WHERE idTeatro=".$idTeatro;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModificar)){
			    $resp = true;
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
            $this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}

    public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		$idTeatro = $this->getId();
		if($base->Iniciar()){
			$consultaBorrar = "DELETE FROM teatro WHERE idTeatro=".$idTeatro;
			if($base->Ejecutar($consultaBorrar)){
			    $resp = true;
			}else{
                $this->setmensajeoperacion($base->getError());
			}
		}else{
            $this->setmensajeoperacion($base->getError());
		}
		return $resp; 
	}

    public function __toString(){
        return  "ID TEATRO: ".$this->getId()."\n".
                "NOMBRE: ".$this->getNombre()."\n".
                "DIRECCI??N: ".$this->getDireccion()."\n";
    }
}

?>