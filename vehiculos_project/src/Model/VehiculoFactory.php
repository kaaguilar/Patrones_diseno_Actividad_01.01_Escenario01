<?php
// src/Model/VehiculoFactory.php
// Factory con registro dinámico: permite registrar nuevas clases sin modificar la fábrica.
require_once __DIR__ . '/Vehiculo.php';

class VehiculoFactory {
    private static $registry = [];

    // Registrar una clase para un tipo (ej: 'AUTO' => 'Auto')
    public static function register(string $tipo, string $className, string $filePath = null) {
        $key = strtoupper(trim($tipo));
        self::$registry[$key] = ['class' => $className, 'file' => $filePath];
    }

    // Crear instancia usando el registro
    public static function crearVehiculo(string $tipo, string $placa, string $marca, string $modelo, float $costoBase): Vehiculo {
        $key = strtoupper(trim($tipo));
        if (!isset(self::$registry[$key])) {
            throw new InvalidArgumentException("Tipo de vehículo no registrado: $tipo");
        }
        $entry = self::$registry[$key];
        if (!empty($entry['file'])) {
            $path = $entry['file'];
            if (file_exists($path)) {
                require_once $path;
            } else {
                // intentar cargar desde el mismo directorio
                $alt = __DIR__ . '/' . basename($path);
                if (file_exists($alt)) require_once $alt;
            }
        }
        $className = $entry['class'];
        if (!class_exists($className)) {
            // intentar require automático por convención (ClassName.php)
            $conv = __DIR__ . '/' . $className . '.php';
            if (file_exists($conv)) require_once $conv;
        }
        if (!class_exists($className)) {
            throw new RuntimeException("Clase $className no encontrada para tipo $tipo");
        }
        return new $className($placa, $marca, $modelo, $costoBase);
    }

    // Permite obtener tipos registrados (útil para vista)
    public static function getRegisteredTypes(): array {
        return array_keys(self::$registry);
    }
}

// Registro por defecto (puedes añadir más registros en bootstrap)
// Si usas autoloading, no es necesario pasar file path.
VehiculoFactory::register('AUTO', 'Auto', __DIR__ . '/Auto.php');
VehiculoFactory::register('CAMIONETA', 'Camioneta', __DIR__ . '/Camioneta.php');
VehiculoFactory::register('CAMION', 'Camion', __DIR__ . '/Camion.php');
