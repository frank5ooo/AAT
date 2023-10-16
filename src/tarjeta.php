<?php

namespace TrabajoSube;

class Tarjeta 
{
    protected $saldo = 0;
    private $limite_saldo = 6600;
    const cargasAceptadas = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                            800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                            2500, 3000, 3500, 4000];
    protected $saldoPendiente = 0;
    protected $tiempo;
    protected $id;
    protected $tipo;
    public function __construct($id,TiempoInterface $tiempo) 
    {
        $this->tiempo = $tiempo;
        $this->id = $id;
    }
   public function recargar($monto) 
    {
        if (in_array($monto, self::cargasAceptadas)) 
        {
            $this->saldo += $monto;

            if ($this->saldo > $this->limite_saldo) 
            {
                $saldoPendiente = $this->saldo - $this->limite_saldo;
                $this->saldo = $this->limite_saldo;
                $this->saldoPendiente = $saldoPendiente;
            }   
        }
        else
        {
            echo ("Monto de recarga no válido: $monto");
        }
    }

    public function recargarPendiente($monto) //esta funcion es para que no se fije si el monto de recarga es valido en el caso de ser saldo pendiente
    {
        $this->saldo += $monto;

        if ($this->saldo > $this->limite_saldo)
        {
            $saldoPendiente = $this->saldo - $this->limite_saldo;
            $this->saldo = $this->limite_saldo;
            $this->saldoPendiente = $saldoPendiente;
        }
    }

    public function descontar($precio) 
    {   

        if ($this->saldo >= $precio)
        {
            $this->saldo -= $precio;

            if(isset($this->saldoPendiente) && $this->saldoPendiente > 0)
            {
                $this->recargarPendiente($this->saldoPendiente);
            }
            return true;
        }
        else
        {
            if($this->saldo-$precio >= -91.84)  //-91.84 ya que en caso de tener un saldo igual o mayor a este al descontarle los 120 quedaria un saldo igual o mayor a -211.84 
            {
                $this->saldo -= $precio;
                echo "Viaje Plus utilizado";
                return true;
            }
            else
            {  
                echo "Viaje Plus no disponible. \n";
                return false;
            }
        }
    }

    public function getSaldo() 
    {
      return $this->saldo;
    }


    public function getID() 
    {   
        return $this->id;
    }

    public function getTipo()
    {   
        return $this->tipo;
    }

    public function getSaldoPendiente()
    {
        return $this->saldoPendiente;

    }
}

