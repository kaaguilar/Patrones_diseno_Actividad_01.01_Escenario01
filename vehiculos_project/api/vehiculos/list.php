<?php
// api/vehiculos/list.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../src/Controller/VehiculoController.php';

$ctrl = new VehiculoController();
$res = $ctrl->listar();
echo json_encode($res);
