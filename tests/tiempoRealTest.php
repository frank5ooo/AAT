<?php

namespace TrabajoSube\Tests;
use PHPUnit\Framework\TestCase;
use TrabajoSube\TiempoReal;

class TiempoRealTest extends TestCase 
{
    public function testTime() 
    {
        $tiempo = new TiempoReal();

        $this->assertIsInt($tiempo->time());
    }
}