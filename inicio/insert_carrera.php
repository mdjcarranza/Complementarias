<?php
	require_once('../conexion/conexion.php');
	$title = 'Carreras';
	$title_menu = 'Carreras';

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO carreras ( clave_carrera, nombre_carrera ) VALUES( ?, ? )';

  		$clave = isset($_POST['clave_carrera']) ? $_POST['clave_carrera']: '';
  		$nombre = isset($_POST['nombre_carrera']) ? $_POST['nombre_carrera']: '';

  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($clave,$nombre));

	}

	$sql_status = 'SELECT * FROM carrera ORDER BY clave_carrera';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute();
	$results_status = $statement_status->fetchAll();
	include("../extend/header.php");
?>
<div class="container">

			<div class="row">
				<form method="post" class="col s12">
					<div class="row">
						<h2>Insertar carrera</h2>
						<hr>
						<div class="input-field col s12">
          				<input placeholder="Clave" name="clave_carrera" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s12">
          				<input placeholder="Nombre" name="nombre_carrera" type="text">
        				</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="carreras.php" class="btn waves-effect waves-light" type="submit" >Regresar</a>
        		</form>
      		</div>
			<div class="row">
				<div class="col s12">
				    <h3>Carreras</h3>
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
					    	<td><?php echo $rs2['clave_carrera']?></td>
							<td><?php echo $rs2['nombre_carrera']?></td>
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