<?php
// src/Model/Vehiculo.php
abstract class Vehiculo {
    protected $id;
    protected $placa;
    protected $marca;
    protected $modelo;
    protected $costoBase;

    public function __construct($placa, $marca, $modelo, $costoBase) {
        $this->placa = $placa;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->costoBase = floatval($costoBase);
    }

    public function getPlaca() { return $this->placa; }
    public function getMarca() { return $this->marca; }
    public function getModelo() { return $this->modelo; }
    public function getCostoBase() { return $this->costoBase; }

    abstract public function calcularMatricula(): float;
}
