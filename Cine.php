<?php

include_once "Funcion.php";

class Cine extends Funcion{
    private $genero;
    private $paisOrigen;
    private $mensajeoperacion;

    public function __construct($objTeatro, $nombre, $horarioInicio, $duracion, $costo, $genero, $paisOrigen){
		parent::__construct($objTeatro, $nombre, $horarioInicio, $duracion, $costo);
        $this->genero = $genero;
        $this->paisOrigen = $paisOrigen;
    }

    public function getGenero(){
        return $this->genero;
    }
    public function getPaisOrigen(){
        return $this->paisOrigen;
    }
    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setGenero($genero){
        $this->genero = $genero;
    }
    public function setPaisOrigen($paisOrigen){
        $this->paisOrigen = $paisOrigen;
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
		$consultaTeatro="SELECT * FROM cine WHERE idFuncion=".$idFuncion;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaTeatro)){
				if($row=$base->Registro()){
					$id = ($row['idFuncion']);
                    $this->setGenero($row['genero']);
                    $this->setPaisOrigen($row['paisOrigen']);

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
		$consultaCine="SELECT * FROM cine";
		if ($condicion!=""){
		    $consultaCine=$consultaCine.' where '.$condicion;
		}
		$consultaCine.=" order by idFuncion";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaCine)){				
				$arreglo= array();
				while($row2=$base->Registro()){
					$idFuncion = ($row2['idFuncion']);

					$cine = new Cine('','','','','','','');
					$cine->buscar($idFuncion);
					array_push($arreglo, $cine);
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
			$consultaInsertar = "INSERT INTO cine(idFuncion, genero, paisOrigen) VALUES (".$idFuncionPadre.",'".$this->getGenero()."','".$this->getPaisOrigen()."')";
			if($base->Iniciar()){
				if($base->Ejecutar($consultaInsertar)){
					$resp = true;
				}else{
					$this->setmensajeoperacion($base->getError());
				}
			}else{
				$this->setmensajeoperacion($base->getError());
			}
			return $resp;
		}
	}

    public function modificar(){
	    $resp = false; 
	    $base = new BaseDatos();
		if (parent::modificar()){
			$idFuncionPadre = parent::getId();
			$consultaModificar = "UPDATE cine SET genero='".$this->getGenero()."', paisOrigen='".$this->getPaisOrigen()."' WHERE idFuncion=".$idFuncionPadre;
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
	}

    public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
			$idFuncionPadre = parent::getId();
			$consultaBorrar = "DELETE FROM cine WHERE idFuncion=".$idFuncionPadre;
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

    public function __toString()
    {
		$cadena = parent::__toString();
		$cadena .= "GÉNERO: ".$this->getGenero()."\n"."PAÍS DE ORIGEN: ".$this->getPaisOrigen()."\n";
        return  $cadena;
    }
}

?>