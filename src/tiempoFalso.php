<?php

namespace TrabajoSube;

use TrabajoSube\tiempoInterface;

class TiempoFalso implements TiempoInterface {

    protected $tiempo; 
    protected $dia; 
    protected $hora; 

    public function __construct($inicio = 0){
        $this->tiempo = $inicio;
        $this->dia= date('l',$inicio);
        $this->hora = date('G',$this->tiempo);
    }
    public function time(){
        return $this->tiempo; 
    }

    public function avanzar($segs){
        $this->tiempo+= $segs; 
        $this->dia = date('l', $this->tiempo);
        $this->hora= date('G',$this->tiempo);
    }

    public function AvanzarDia($dia)
    {
        return $this->avanzar($dia*86400);
    }

    public function GetDia()
    {
        return $this->dia;
    }
    

    public function GetHora()
    {
        return $this->hora;
    }
}

?>