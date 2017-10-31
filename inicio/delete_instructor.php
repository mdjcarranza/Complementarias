<?php
require_once('../conexion/conexion.php');
$clave = isset($_GET['rfc_instructor']) ? $_GET['rfc_instructor'] : 0 ;
$sql = 'DELETE FROM instructor WHERE rfc_instructor = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($clave));

$results = $statement->fetchAll();
header('Location: instructores.php');
