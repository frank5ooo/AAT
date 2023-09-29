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
            $precioMostrado = $this->precio; // Precio real por defecto
            if ($tarjeta instanceof MedioBoleto) {
                $precioMostrado = $this->precio / 2; // Precio mostrado para MedioBoleto
            } elseif ($tarjeta instanceof FranquiciaCompleta) {
                $precioMostrado = 0; // Precio mostrado para FranquiciaCompleta
            }

            return new Boleto($this->linea, $this->precio, $precioMostrado);
        } 
    }
}

$colectivo = new Colectivo("101");
?>