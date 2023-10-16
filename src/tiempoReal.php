<?php
namespace TrabajoSube;

    class TiempoReal implements TiempoInterface {

    public function time(){
        return time(); 
    }

}
?>