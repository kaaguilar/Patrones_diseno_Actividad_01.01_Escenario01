<?php
// src/Model/Camioneta.php
require_once __DIR__ . '/Vehiculo.php';

class Camioneta extends Vehiculo {
    public function calcularMatricula(): float {
        return round($this->costoBase * 0.15, 2);
    }
}
