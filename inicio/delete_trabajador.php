<?php
require_once('../conexion/conexion.php');
$clave = isset($_GET['rfc_trabajador']) ? $_GET['rfc_trabajador'] : 0 ;
$sql = 'DELETE FROM trabajador WHERE rfc_trabajador = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($clave));

$results = $statement->fetchAll();
header('Location: trabajadores.php');
