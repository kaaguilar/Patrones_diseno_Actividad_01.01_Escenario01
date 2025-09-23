<?php
// src/Model/Auto.php
require_once __DIR__ . '/Vehiculo.php';

class Auto extends Vehiculo {
    public function calcularMatricula(): float {
        return round($this->costoBase * 0.10, 2);
    }
}
