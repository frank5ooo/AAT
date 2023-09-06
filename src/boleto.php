<?php

require 'colectivo.php';
require 'tarjeta.php';

class Boleto {
    
    public function __construct($linea , $precio) {
        $this->linea = $linea;
        $this->precio = $precio;
    }

    public function __toString() {
    return "Boleto de colectivo - Línea " . $this->linea . " - Precio: $" . number_format($this->precio, 2);
}
}

// Realizar un viaje
$boleto = $colectivo->pagarCon($tarjeta);

if ($boleto) {
    echo "Viaje realizado.\n";
    echo $boleto ;
    echo "\nSaldo restante: $" . number_format($tarjeta->getSaldo(), 2);
} 
else {
    echo "Saldo insuficiente.\n";
}
?>
