<?php
class Boleto {
    private $linea;
  
    private $precio = 120;

    public function __construct($linea) {
        $this->linea = $linea;
    }

    public function __toString() {
    return "Boleto de colectivo - Línea " . $this->linea . " - Precio: $" . number_format($this->precio, 2);
}


}


require 'colectivo.php';
require 'tarjeta.php';


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


?>