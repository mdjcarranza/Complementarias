<?php
	require_once('../conexion/conexion.php');
	$title = 'Institutos';
	$title_menu = 'Institutos';

	$show_form1 = FALSE;

	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE instituto SET clave_instituto = ?, nombre_instituto = ? WHERE clave_instituto = ?';

		$clave = isset($_GET['clave_instituto']) ? $_GET['clave_instituto']: '';
		$clave2 = isset($_POST['clave_instituto2']) ? $_POST['clave_instituto2']: '';
  		$nombre = isset($_POST['nombre_instituto']) ? $_POST['nombre_instituto']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($clave2, $nombre, $clave));
	  	header('Location: institutos.php');
	}

	if(isset( $_GET['clave_instituto'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT * FROM instituto where clave_instituto = ?';
		$clave = isset( $_GET['clave_instituto']) ? $_GET['clave_instituto'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($clave));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT * FROM instituto WHERE nombre_instituto like :search';
	$search_terms = isset($_GET['nombre_instituto']) ? $_GET['nombre_instituto'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT * FROM instituto';
	$statement_show = $pdo->prepare($sql_show);
	$statement_show->execute();
	$results_show = $statement_show->fetchAll();
	include('../extend/header.php');
?>

		<div class="container">
			<div class="row">
				<div class="col s12">
					<h2>Proyecto de actividades complementarias</h2>
					<hr>
					<?php if($show_form1 == FALSE) {?>
					<form method = "get" class = "center">
						<div class = "row">
							<div class = "col s9">
								<label>
									Ingrese el nombre del instituto
									<input type="text" name="nombre_instituto" placeholder = "Ej. Tecnologico">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_instituto.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Carreras</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave instituto</th>
				          	<th>Nombre instituto</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['clave_instituto']?></td>
							<td><?php echo $rs2['nombre_instituto']?></td>
							<td><a class="btn waves-effect waves-light" href="institutos.php?clave_instituto=<?php echo $rs2['clave_instituto']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_instituto(<?php echo $rs2['clave_instituto']; ?>)" href="#">ELIMINAR</a>
					    </tr>
					    <?php 
				          	}
				        ?>
					</tbody>
					</table>
					<?php 
						} elseif ($show_form1 == TRUE)
						{
						?>
						<form method="post">
							<div class="row">
								<div class="input-field col s12">
          							<input placeholder="<?php echo $rs_details['clave_instituto'] ?>" name="clave_instituto2" type="text" value="<?php echo $rs_details['clave_instituto'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s12">
          							<input placeholder="<?php echo $rs_details['nombre_instituto'] ?>" name="nombre_instituto" type="text" value="<?php echo $rs_details['nombre_instituto'] ?>">
        						</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="institutos.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Institutos</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave instituto</th>
				          	<th>Nombre instituto</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['clave_instituto']?></td>
							<td><?php echo $rs2['nombre_instituto']?></td>
							<td><a class="btn waves-effect waves-light" href="institutos.php?clave_instituto=<?php echo $rs2['clave_instituto']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_instituto(<?php echo $rs2['clave_instituto']; ?>)" href="#">ELIMINAR</a>
					    </tr>
					    <?php 
				          	}
				        ?>
					</tbody>
					</table>
					<?php } ?>
				    
				</div>
			</div>
			<?php
				include('../extend/footer.php');
			?>
