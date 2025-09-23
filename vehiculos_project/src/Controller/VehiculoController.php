<?php
// src/Controller/VehiculoController.php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Model/VehiculoFactory.php';
require_once __DIR__ . '/../Model/DAO/MySQLVehiculoDAO.php';

class VehiculoController {
    private $factory;
    private $dao;

    public function __construct() {
        $this->factory = new VehiculoFactory(); // factory uses static registry
        $pdo = Database::getConnection();
        $this->dao = new MySQLVehiculoDAO($pdo);
    }

    public function crear(array $data): array {
        $required = ['tipo', 'placa', 'marca', 'modelo', 'costoBase'];
        foreach ($required as $f) {
            if (!isset($data[$f]) || trim((string)$data[$f]) === '') {
                return ['success' => false, 'error' => "Campo requerido: $f"];
            }
        }

        try {
            $tipo = $data['tipo'];
            $placa = strtoupper(trim($data['placa']));
            $marca = trim($data['marca']);
            $modelo = trim($data['modelo']);
            $costoBase = floatval($data['costoBase']);

            $veh = VehiculoFactory::crearVehiculo($tipo, $placa, $marca, $modelo, $costoBase);
            $id = $this->dao->guardar($veh);
            return ['success' => true, 'id' => $id, 'matricula' => $veh->calcularMatricula()];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function listar(): array {
        try {
            $rows = $this->dao->listar();
            return ['success' => true, 'data' => $rows];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
