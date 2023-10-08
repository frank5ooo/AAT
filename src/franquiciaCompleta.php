<?php

namespace TrabajoSube;

class FranquiciaCompleta extends Tarjeta {
    public function descontar($precio) {
        // Descuento completo (boleto gratuito)
            echo "Boleto gratuito para jubilados.\n";
            return true;
    }
}