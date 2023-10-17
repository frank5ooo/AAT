<?php

namespace TrabajoSube;

class Tarjeta 
{
    protected $saldo = 0;
    private $limite_saldo = 6600;
    protected $precio = 120;
    protected $cantViajesEnElMes;    
    const cargasAceptadas = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 
                            800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 
                            2500, 3000, 3500, 4000];
    protected $saldoPendiente=0;
    protected $tiempo;
    protected $id;
    protected $tipo;
    protected $mesActual=0;
    public function __construct($id,TiempoInterface $tiempo) 
    {
        $this->tiempo = $tiempo;
        $this->id = $id;
    }

    public function recargar($monto) 
    {   
        $saldofake=$this->saldo + $monto;
       // echo"\nsaldofakerecarga". $saldofake;

        if (in_array($monto, self::cargasAceptadas) && $saldofake < $this->limite_saldo) 
        {
            $this->saldo += $monto;
        }
        else
        {   
            if ($saldofake > $this->limite_saldo) 
            {   
                //echo"\nSALDOofakerecarga". $saldofake;

                $saldoPendiente = $saldofake - $this->limite_saldo;
                $this->saldo = $this->limite_saldo;
                $this->saldoPendiente = $saldoPendiente;
                // echo"\nsaldoPendienterecarga".$this->saldoPendiente;
                // echo"\nsaldorecarga".$this->saldo;

            }   
        }
    }

    public function recargarPendiente($monto) //esta funcion es para que no se fije si el monto de recarga es valido en el caso de ser saldo pendiente
    {   
        //echo"\nmonto".$monto;
        $saldofake=$this->saldo + $monto;

        if ($saldofake+= $monto > $this->limite_saldo)
        {   
            //echo"\nsaldo".$this->saldo;

            $saldoPendiente = $saldofake - $this->limite_saldo;
            $this->saldo = $this->limite_saldo;
            $this->saldoPendiente = $saldoPendiente;
            //echo"\nsaldo11  ".$this->saldo;
        }
    }

    public function descontar($precio) 
    {
        $mesActual = date('m', $this->tiempo->time());

        if ($this->mesActual < date('m', $this->tiempo->time())) 
        {
            $this->mesActual = $mesActual;
            $this->cantViajesEnElMes = 0;
        }
        
        if($this->cantViajesEnElMes<=29)
        {
            $this->precio = 120;
        }
        if($this->cantViajesEnElMes>=30 && $this->cantViajesEnElMes<=79)
        {
            $this->precio= 96;
        }
        elseif ($this->cantViajesEnElMes>=80)
        {
            $this->precio = 90;
        }

//        echo"\ncantViajesEnElMes: ". $this->cantViajesEnElMes;

        if ($this->saldo >= $precio)
        {
            $this->mesActual= $mesActual;
            $this->cantViajesEnElMes++;
            $this->saldo -= $precio;
            if($this->saldoPendiente>0)
            {
                $this->recargarPendiente($this->saldoPendiente);
            }
            //echo"saldoFinal".$this->saldo;
            return true;
        }
        else
        {
            if($this->saldo >= -91.84)  //-91.84 ya que en caso de tener un saldo igual o mayor a este al descontarle los 120 quedaria un saldo igual o mayor a -211.84 
            {
                $this->saldo -= $precio;
                $this->cantViajesEnElMes++;
                echo "Viaje Plus utilizado";
                return true;
            }
            else
            {  
                echo "Viaje Plus no disponible. \n";
                return false;
            }
        }

        // $this->cantViajesEnElMes++;
    }

    public function getSaldo() 
    {
      return $this->saldo;
    }
    public function getPrecio() 
    {
        return $this->precio;
    }
    public function getID() 
    {   
        return $this->id;
    }
    public function getTipo()
    {   
        return $this->tipo;
    }
    public function getCantViajesEnElMes()
    {
        return $this->cantViajesEnElMes;
    }

    public function getMesActual()
    {
        return $this->mesActual;
    }
}