<?php
namespace TrabajoSube;


class Colectivo {
    private $linea;
    private $precio = 120;

    public function __construct($linea) {
        $this->linea = $linea;
    }

    public function pagarCon($tarjeta) {
        if($tarjeta->descontar($this->precio))
        {
            return new Boleto($this->linea, $this->precio);   
        } 
        
    }
}

$colectivo = new Colectivo("101");
?>