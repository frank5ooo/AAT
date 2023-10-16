<?php
namespace TrabajoSube;

class Colectivo 
{
    protected $linea;
    protected $precio = 120;

    public function __construct($linea) 
    {
        $this->linea = $linea;
    }

    public function pagarCon($tarjeta) 
    {
        if($tarjeta->descontar($this->precio))
        {
            $boleto = new Boleto($tarjeta, $this);
        }
    }

    public function getPrecio()
    {   
        return $this->precio;
    }

 
}

?>