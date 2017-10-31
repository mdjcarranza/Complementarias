<?php
	require_once('../conexion/conexion.php');
	$title = 'Institutos';
	$title_menu = 'Institutos';

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO instituto ( clave_instituto, nombre_instituto ) VALUES( ?, ? )';

  		$clave = isset($_POST['clave_instituto']) ? $_POST['clave_instituto']: '';
  		$nombre = isset($_POST['nombre_instituto']) ? $_POST['nombre_instituto']: '';

  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($clave,$nombre));

	}

	$sql_status = 'SELECT * FROM instituto ORDER BY clave_instituto';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute();
	$results_status = $statement_status->fetchAll();
	include("../extend/header.php");
?>
<div class="container">

			<div class="row">
				<form method="post" class="col s12">
					<div class="row">
						<h2>Insertar instituto</h2>
						<hr>
						<div class="input-field col s12">
          				<input placeholder="Clave" name="clave_instituto" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s12">
          				<input placeholder="Nombre" name="nombre_instituto" type="text">
        				</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="institutos.php" class="btn waves-effect waves-light" type="submit" >Regresar</a>
        		</form>
      		</div>
			<div class="row">
				<div class="col s12">
				    <h3>Institutos</h3>
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
					    	<td><?php echo $rs2['clave_instituto']?></td>
							<td><?php echo $rs2['nombre_instituto']?></td>
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