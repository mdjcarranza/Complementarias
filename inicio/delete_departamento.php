<?php
require_once('../conexion/conexion.php');
$clave = isset($_GET['ClaveDepa']) ? $_GET['ClaveDepa'] : 0 ;
$sql = 'DELETE FROM departamento WHERE ClaveDepa = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($clave));

$results = $statement->fetchAll();
header('Location: departamentos.php');
