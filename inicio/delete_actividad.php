<?php
require_once('../conexion/conexion.php');
$clave = isset($_GET['clave_act']) ? $_GET['clave_act'] : 0 ;
$sql = 'DELETE FROM act_complementaria WHERE clave_act = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($clave));

$results = $statement->fetchAll();
header('Location: actividades.php');
