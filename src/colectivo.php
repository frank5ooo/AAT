<?php
class Colectivo {
    private $linea;
    
    public function __construct($linea) {
        $this->linea = $linea;
    }

    public function pagarCon($tarjeta) {
        $tarjeta->pagar(120);
        return new Boleto($this->linea);
    }
}

$colectivo = new Colectivo("101");
?>