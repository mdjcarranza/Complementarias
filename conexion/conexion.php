<?php

$dsn = 'mysql:dbname=mydb;host=localhost';
$user = 'mdjcarranza';
$password = 'Vivamexico123';

try{

	$pdo = new PDO(	$dsn, 
					$user, 
					$password
					);

}catch( PDOException $e ){
	echo 'Error al conectarnos: ' . $e->getMessage();
}
?>
