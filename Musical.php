<?php

include_once "Funcion.php";

class Musical extends Funcion{
    private $director;
    private $cantPersonas;
    private $mensajeoperacion;

    public function __construct($objTeatro, $nombre, $horarioInicio, $duracion, $costo, $director, $cantPersonas){
		parent::__construct($objTeatro, $nombre, $horarioInicio, $duracion, $costo);
        $this->director = $director;
        $this->cantPersonas = $cantPersonas;
    }

    public function getDirector(){
        return $this->director;
    }
    public function getCantPersonas(){
        return $this->cantPersonas;
    }
    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setDirector($director){
        $this->director = $director;
    }
    public function setCantPersonas($cantPersonas){
        $this->cantPersonas = $cantPersonas;
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    /**
	 * @param int $id
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idFuncion){
		$base=new BaseDatos();
		$consultaTeatro="SELECT * FROM musical WHERE idFuncion=".$idFuncion;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaTeatro)){
				if($row=$base->Registro()){
				    $id = ($row['idFuncion']);
					$this->setDirector($row['director']);
                    $this->setCantPersonas($row['cantPersonas']);

					parent::buscar($id);

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

    public static function listar($condicion){
	    $arreglo = null;
		$base = new BaseDatos();
		$consultaMusical="SELECT * FROM musical INNER JOIN funcion ON musical.idFuncion = funcion.idFuncion";
		if ($condicion!=""){
		    $consultaMusical=$consultaMusical.' where '.$condicion;
		}
		if($base->Iniciar()){
			if($base->Ejecutar($consultaMusical)){				
				$arreglo= array();
				while($row2=$base->Registro()){
					$idFuncion = ($row2['idFuncion']);

					$musical = new Musical('', '', '', '', '', '', '');
					$musical->buscar($idFuncion);
					array_push($arreglo, $musical);
				}
		 	}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
            $this->setmensajeoperacion($base->getError());
		}
	    return $arreglo;
	}

    public function insertar(){
		$base = new BaseDatos();
		$resp= false;
		if (parent::insertar()){
			$idFuncionPadre = parent::getId();
			$consultaInsertar = "INSERT INTO musical(idFuncion, director, cantPersonas) VALUES (".$idFuncionPadre.",'".$this->getDirector()."',".$this->getCantPersonas().")";
			if($base->Iniciar()){
				if($base->Ejecutar($consultaInsertar)){
					$resp = true;
				}else{
					$this->setmensajeoperacion($base->getError());
				}
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}
		return $resp;
	}

    public function modificar(){
	    $resp = false; 
	    $base = new BaseDatos();
		if(parent::modificar()){
			$idFuncionPadre = parent::getId();
			$consultaModificar = "UPDATE musical SET director='".$this->getDirector()."', cantPersonas='".$this->getCantPersonas()."' WHERE idFuncion=".$idFuncionPadre;
			if($base->Iniciar()){
				if($base->Ejecutar($consultaModificar)){
					$resp = true;
				}else{
					$this->setmensajeoperacion($base->getError());
				}
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}
		return $resp;
	}
    
    public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$idFuncionPadre = parent::getId();
			$consultaBorrar = "DELETE FROM musical WHERE idFuncion=".$idFuncionPadre;
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
		$cadena = parent::__toString();
		$cadena .= "DIRECTOR: ".$this->getDirector()."\n"."CANTIDAD DE PERSONAS: ".$this->getCantPersonas()."\n";
		return  $cadena;
    }
}

?>