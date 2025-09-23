<?php
// src/Model/DAO/VehiculoDAO.php
interface VehiculoDAO {
    public function guardar(Vehiculo $v): int;
    public function listar(): array;
    public function buscarPorPlaca(string $placa): ?Vehiculo;
}
