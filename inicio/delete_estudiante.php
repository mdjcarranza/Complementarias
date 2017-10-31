<?php
require_once('../conexion/conexion.php');
$noControl = isset($_GET['No_control']) ? $_GET['No_control'] : 0 ;
$sql = 'DELETE FROM estudiante WHERE No_control = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($noControl));

$results = $statement->fetchAll();
header('Location: estudiantes.php');
