<?php

namespace TrabajoSube\Tests;

use PHPUnit\Framework\TestCase;
use TrabajoSube\tarjeta;
use TrabajoSube\colectivo;
use TrabajoSube\boleto;
use TrabajoSube\franquiciacompleta;
use TrabajoSube\medioboleto;
use TrabajoSube\tiempoReal;

class boletoTest extends TestCase 
{   
    private $boleto = 120;
    public function testBoletoParaTarjetaNormal() 
    {
        $tiempo = new TiempoReal;
        $tarjeta = new tarjeta(1, $tiempo);
        $colectivo = new colectivo(122);

        $tarjeta->recargar(2000);

        $boleto = new Boleto($tarjeta, $colectivo);

        $this->assertEquals($colectivo, $boleto->getLineaColectivo());
        $this->assertEquals($tarjeta->getSaldo(), $boleto->getSaldo());
        $this->assertEquals($tarjeta->getID(), $boleto->getIDTarjeta());
        $this->assertEquals(date("Y-m-d H:i:s", time()), $boleto->getFecha());
        $this->assertEquals(get_class($tarjeta), $boleto->getTipoTarjeta());
        $this->assertEquals(2000-$this->boleto, $boleto->getSaldoRestante());
        $this->assertEquals($colectivo->getPrecio(), $boleto->getboleto());

        $this->assertEquals("Abona saldo 120 (saldo restante: ". number_format(2000-$this->boleto,2).")", $boleto->getDescripcionExtra());
    }
    
    public function testBoletoParaMedioBoleto() 
    {
        $tiempo = new TiempoReal;
        $tarjeta = new medioboleto(1, $tiempo);
        $medioboleto = $this->boleto/2;

        $colectivo = new colectivo(120);
        $tarjeta->recargar(2000);
        $boleto = new Boleto($tarjeta, $colectivo);

        $this->assertEquals($colectivo, $boleto->getLineaColectivo());
        $this->assertEquals($tarjeta->getSaldo(), $boleto->getSaldo());
        $this->assertEquals($tarjeta->getID(), $boleto->getIDTarjeta());
        $this->assertEquals(date("Y-m-d H:i:s", time()), $boleto->getFecha());
        $this->assertEquals(get_class($tarjeta), $boleto->getTipoTarjeta());
        $this->assertEquals(2000-60, $boleto->getSaldoRestante());
        $this->assertEquals($colectivo->getPrecio(), $boleto->getboleto());

        $this->assertEquals("Abona saldo 60 (saldo restante: ". number_format(2000-$medioboleto,2).")", $boleto->getDescripcionExtra());

    }
    public function testBoletoParaFranquiciaCompleta() 
    {
        $tiempo = new TiempoReal;
        $tarjeta = new franquiciacompleta(1, $tiempo);
        $colectivo = new colectivo(120);
        $tarjeta->recargar(2000);
        $boleto = new Boleto($tarjeta, $colectivo);

        $this->assertEquals($colectivo, $boleto->getLineaColectivo());
        $this->assertEquals($tarjeta->getSaldo(), $boleto->getSaldo());
        $this->assertEquals($tarjeta->getID(), $boleto->getIDTarjeta());
        $this->assertEquals(date("Y-m-d H:i:s", time()), $boleto->getFecha());
        $this->assertEquals(get_class($tarjeta), $boleto->getTipoTarjeta());
        $this->assertEquals(2000, $boleto->getSaldoRestante());
        $this->assertEquals("No abona"." (saldo restante: " . number_format($tarjeta->getSaldo(), 2) . ")", $boleto->getDescripcionExtra());

    }
}

