<?php
// src/Model/Camion.php
require_once __DIR__ . '/Vehiculo.php';

class Camion extends Vehiculo {
    public function calcularMatricula(): float {
        return round($this->costoBase * 0.20, 2);
    }
}
