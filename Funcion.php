<?php
include_once "BaseDatos.php";
class Funcion{
    private $id;
    private $objTeatro; //cambiar a OBJ teatro
    private $nombre;
    private $horarioInicio;
    private $duracion;
    private $costo;
    private $mensajeoperacion;

    public function __construct($objTeatro, $nombre, $horarioInicio, $duracion, $costo){
        $this->objTeatro = $objTeatro;
        $this->nombre = $nombre;
        $this->horarioInicio = $horarioInicio;
        $this->duracion = $duracion;
        $this->costo = $costo;
    }

    public function getId(){
        return $this->id;
    }
    public function getObjTeatro(){
        return $this->objTeatro;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getHorarioInicio(){
        return $this->horarioInicio;
    }
    public function getDuracion(){
        return $this->duracion;
    }
    public function getCosto(){
        return $this->costo;
    }
    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    public function setObjTeatro($objTeatro){
        $this->objTeatro = $objTeatro;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setHorarioInicio($horarioInicio){
        $this->horarioInicio = $horarioInicio;
    }
    public function setDuracion($duracion){
        $this->duracion = $duracion;
    }
    public function setCosto($costo){
        $this->costo = $costo;
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function cargar($nombre, $horarioInicio, $duracion, $costo){
        $this->setNombre($nombre);
        $this->setHorarioInicio($horarioInicio);
        $this->setDuracion($duracion);
        $this->setCosto($costo);
    }

     /**
	 * Recupera los datos de una funcion por id
	 * @param int $id
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id){
		$base=new BaseDatos();
		$consultaFuncion="SELECT * FROM funcion WHERE idFuncion=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaFuncion)){
				if($row2=$base->Registro()){
				    $idTeatro = ($row2['idTeatro']);
                    $this->setId($row2['idFuncion']);
					$this->setNombre($row2['nombre']);
                    $this->setHorarioInicio($row2['horarioInicio']);
                    $this->setDuracion($row2['duracion']);
                    $this->setCosto($row2['costo']);

                    $teatro = new Teatro("", "", "");
                    $teatro->buscar($idTeatro);

                    $this->setObjTeatro($teatro);

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
	    $arregloFunciones = null;
		$base = new BaseDatos();
        $consultaFuncion = "SELECT * FROM funcion";
        if($condicion!=""){
            $consultaFuncion = $consultaFuncion.' where '.$condicion;
        }
		if($base->Iniciar()){
			if($base->Ejecutar($consultaFuncion)){				
				$arregloFunciones = array();
				while($row2=$base->Registro()){
				    $id = $row2(['idFuncion']);

					$funcion = new Funcion('','','','','');
                    $funcion->buscar($id);
					array_push($arregloFunciones, $funcion);
				}
		 	}else{
                $this->setmensajeoperacion($base->getError());
			}
		}else{
            $this->setmensajeoperacion($base->getError());
		}
	    return $arregloFunciones;
	}	

    public function insertar(){
		$base = new BaseDatos();
		$resp= false;
        $teatro = $this->getObjTeatro();
        $idTeatro = $teatro->getId();
		$consultaInsertar = "INSERT INTO funcion(idTeatro, nombre, horarioInicio, duracion, costo) VALUES (".$idTeatro.",'".$this->getNombre()."','".$this->getHorarioInicio()."' ,".$this->getDuracion().",".$this->getCosto().")";
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
        $idFuncion = $this->getId();
        $consultaModificar = "UPDATE funcion SET nombre='".$this->getNombre()."', horarioInicio='".$this->getHorarioInicio()."', duracion=".$this->getDuracion().", costo=".$this->getCosto()." WHERE idFuncion=".$idFuncion;
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
        $idFuncion = $this->getId();
		if($base->Iniciar()){
			$consultaBorrar = "DELETE FROM funcion WHERE idFuncion=".$idFuncion;
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
        $idTeatro = $this->getObjTeatro()->getId();
        return  "ID FUNCION: ".$this->getId()."\n".
                "ID TEATRO: ".$idTeatro."\n".
                "NOMBRE: ".$this->getNombre()."\n".
                "HORARIO INICIO: ".$this->getHorarioInicio()."\n".
                "DURACIÓN: ".$this->getDuracion()."\n".
                "COSTO DE LA SALA: ".$this->getCosto()."\n";
    }
}

?>