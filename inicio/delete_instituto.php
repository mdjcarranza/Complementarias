<?php
require_once('../conexion/conexion.php');
$clave = isset($_GET['clave_instituto']) ? $_GET['clave_instituto'] : 0 ;
$sql = 'DELETE FROM instituto WHERE clave_instituto = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($clave));

$results = $statement->fetchAll();
header('Location: institutos.php');
