<?php
// src/Model/DAO/MySQLVehiculoDAO.php
require_once __DIR__ . '/VehiculoDAO.php';

class MySQLVehiculoDAO implements VehiculoDAO {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function guardar(Vehiculo $v): int {
        $matricula = $v->calcularMatricula();
        $tipo = (new ReflectionClass($v))->getShortName(); // Auto/Camioneta/Camion

        $sql = "INSERT INTO vehiculos (tipo, placa, marca, modelo, costoBase, matricula) VALUES (:tipo, :placa, :marca, :modelo, :costoBase, :matricula)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':tipo' => $tipo,
            ':placa' => $v->getPlaca(),
            ':marca' => $v->getMarca(),
            ':modelo' => $v->getModelo(),
            ':costoBase' => $v->getCostoBase(),
            ':matricula' => $matricula
        ]);
        return intval($this->pdo->lastInsertId());
    }

    public function listar(): array {
        $sql = "SELECT * FROM vehiculos ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorPlaca(string $placa): ?Vehiculo {
        $sql = "SELECT * FROM vehiculos WHERE placa = :placa LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':placa' => $placa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        // usar factory dinámico para reconstruir el objeto
        require_once __DIR__ . '/../VehiculoFactory.php';
        $factory = new VehiculoFactory(); // not needed, usar estático
        return VehiculoFactory::crearVehiculo($row['tipo'], $row['placa'], $row['marca'], $row['modelo'], floatval($row['costoBase']));
    }
}
