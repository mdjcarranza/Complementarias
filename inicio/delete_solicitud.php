<?php
require_once('../conexion/conexion.php');
$clave = isset($_GET['folio']) ? $_GET['folio'] : 0 ;
$sql = 'DELETE FROM solicitud WHERE folio = ?';

$statement = $pdo->prepare($sql);
$statement->execute(array($clave));

$results = $statement->fetchAll();
header('Location: solicitudes.php');
