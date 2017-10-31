<?php
require_once('../conexion/conexion.php');
$clave = isset($_GET['clave_carrera']) ? $_GET['clave_carrera'] : 0 ;
$sql = 'DELETE FROM carrera WHERE clave_carrera = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($clave));

$results = $statement->fetchAll();
header('Location: carreras.php');
