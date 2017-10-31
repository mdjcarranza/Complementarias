<?php
	require_once('../conexion/conexion.php');
	$title = 'Actividades';
	$title_menu = 'Actividades';
	$sql_carrera = 'SELECT * FROM act_complementaria';

	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO act_complementaria ( clave_act, nombre_act ) VALUES( ?, ? )';

  		$clave = isset($_POST['clave_act']) ? $_POST['clave_act']: '';
  		$nombre = isset($_POST['nombre_act']) ? $_POST['nombre_act']: '';

  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($clave,$nombre));

	}

	$sql_status = 'SELECT * FROM act_complementaria ORDER BY clave_act';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute();
	$results_status = $statement_status->fetchAll();
	include("../extend/header.php");
?>
<div class="container">

			<div class="row">
				<form method="post" class="col s12">
					<div class="row">
						<h2>Insertar actividad</h2>
						<hr>
						<div class="input-field col s12">
          				<input placeholder="Clave" name="clave_act" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s12">
          				<input placeholder="Nombre" name="nombre_act" type="text">
        				</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="actividades.php" class="btn waves-effect waves-light" type="submit" >Regresar</a>
        		</form>
      		</div>
			<div class="row">
				<div class="col s12">
				    <h3>Actividades</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave</th>
				          	<th>Nombre</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['clave_act']?></td>
							<td><?php echo $rs2['nombre_act']?></td>
					    </tr>
					    <?php 
				          	}
				        ?>
					</tbody>
					</table>
				</div>
			</div>
<?php 
	include("../extend/footer.php");
 ?>