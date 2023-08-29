<?php
class Colectivo {
    private $linea;

    public function __construct($linea) {
        $this->linea = $linea;
    }

    public function pagarCon($tarjeta) {
        $tarjeta->descontar(120);
        return new Boleto($this->linea);
    }
}


// Crear un colectivo
$colectivo = new Colectivo("101");
?>



