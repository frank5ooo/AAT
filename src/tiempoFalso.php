<?php

namespace TrabajoSube;

use TrabajoSube\tiempoInterface;

class TiempoFalso implements TiempoInterface
{
    protected $tiempo;

    public function __construct($inicio = 0)
    {
        $this->tiempo = $inicio;
    }
    public function avanzar($segs = 0)
    { 
        $this->tiempo = $segs; 
        $this->mes = date('m', $this->tiempo);
    }
    public function time()
    {
        return $this->tiempo; 
    }

}

?>