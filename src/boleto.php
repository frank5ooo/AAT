<?php
namespace TrabajoSube;
class Boleto {
    private $fecha;
    private $tipoTarjeta;
    private $lineaColectivo;
    private $boleto;
    private $saldo;

    private $saldoRestante;

    private $idTarjeta;
    private $descripcionExtra;

    public function __construct($tarjeta, $lineaColectivo) 
    {
        $this->lineaColectivo = $lineaColectivo;
        $this->saldo = $tarjeta->getSaldo(); 
        $this->idTarjeta = $tarjeta->getID();
        $this->fecha = date("Y-m-d H:i:s");
        $this->tipoTarjeta = get_class($tarjeta); 
        $this->boleto = $tarjeta->getPrecio();
        $this->descripcionExtra = "";

        // Verificar si se canceló el saldo negativo.
        if ($tarjeta->getSaldo() >= ($this->boleto)) 
        {   
            if(get_class($tarjeta)=="TrabajoSube\MedioBoleto")
            {   
                $medioboleto = $this->boleto/2;
                $this->saldoRestante = $tarjeta->getSaldo() - $medioboleto;
                $this->descripcionExtra = "Abona saldo " . $medioboleto . " (saldo restante: " . number_format($this->saldoRestante, 2) . ")";
            }
            elseif(get_class($tarjeta)=="TrabajoSube\FranquiciaCompleta")
            {   
                $this->saldoRestante = $tarjeta->getSaldo();
                $this->descripcionExtra = "No abona" . " (saldo restante: " . number_format($this->saldoRestante, 2) . ")";
            }
            else
            {
                $this->saldoRestante = $tarjeta->getSaldo() - $this->boleto;
                $this->descripcionExtra = "Abona saldo " . $this->boleto . " (saldo restante: " . number_format($this->saldoRestante, 2) . ")";
            }
        }
    }

    public function getFecha() 
    {
        return $this->fecha;
    }

    public function getTipoTarjeta() 
    {   
        return $this->tipoTarjeta;
    }

    public function getLineaColectivo() 
    {
        return $this->lineaColectivo;
    }

    public function getboleto() 
    {
        return $this->boleto;
    }

    public function getSaldo() 
    {
        return $this->saldo;
    }

    public function getSaldoRestante() 
    {
        return $this->saldoRestante;
    }

    public function getIDTarjeta() 
    {
        return $this->idTarjeta;
    }

    public function getDescripcionExtra() 
    {
        return $this->descripcionExtra;
    }
}


?>
