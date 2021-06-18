<?php

include_once "Funcion.php";

class FuncionTeatro extends Funcion{
    private $mensajeoperacion;

    public function __construct($objTeatro, $nombre, $horarioInicio, $duracion, $costo){
		parent::__construct($objTeatro, $nombre, $horarioInicio, $duracion, $costo);
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
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
		$consultaFuncionTeatro="SELECT * FROM funcionTeatro WHERE idFuncion=".$idFuncion;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaFuncionTeatro)){
				if($row2=$base->Registro()){
				    $id = ($row2['idFuncion']);

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
		$consultaFuncionTeatro="SELECT * FROM funcionTeatro";
		if ($condicion!=""){
		    $consultaFuncionTeatro=$consultaFuncionTeatro.' where '.$condicion;
		}
		$consultaFuncionTeatro.=" order by idFuncion";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaFuncionTeatro)){				
				$arreglo= array();
				while($row2=$base->Registro()){
				    $idFuncion = ($row2['idFuncion']);

					$funcionTeatro = new FuncionTeatro('','','','','');
                    $funcionTeatro->buscar($idFuncion);
					array_push($arreglo, $funcionTeatro);
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
		if(parent::insertar()){
			$idFuncionPadre = parent::getId();
			$consultaInsertar = "INSERT INTO funcionTeatro(idFuncion) VALUES (".$idFuncionPadre.")";
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
		if (parent::modificar()){
			$idFuncionPadre = parent::getId();
			$consultaModificar = "UPDATE functionTeatro SET idFuncion=".$idFuncionPadre." WHERE idFuncion=".$idFuncionPadre;
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
			$consultaBorrar = "DELETE FROM funcionTeatro WHERE idFuncion=".$idFuncionPadre;
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
        return  $cadena;
    }
}

?>