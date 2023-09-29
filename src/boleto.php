<?php
namespace TrabajoSube;

use Exception;

require 'colectivo.php';
require 'tarjeta.php';

class Boleto {
    
    private $precioMostrado; // Precio a mostrar en el boleto

    public function __construct($linea , $precio, $precioMostrado) 
    {
        $this->linea = $linea;
        $this->precio = $precio;
        $this->precioMostrado = $precioMostrado;
    }

    public function __toString() 
    {
        return "Boleto de colectivo - Línea " . $this->linea . " - Precio: $" . number_format($this->precioMostrado, 2);
    }
}

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
