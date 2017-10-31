<?php
	require_once('../conexion/conexion.php');
	$title = 'Carreras';
	$title_menu = 'Carreras';

	$show_form1 = FALSE;

	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE carrera SET clave_carrera = ?, nombre_carrera = ? WHERE clave_carrera = ?';

		$clave = isset($_GET['clave_carrera']) ? $_GET['clave_carrera']: '';
		$clave2 = isset($_POST['clave_carrera2']) ? $_POST['clave_carrera2']: '';
  		$nombre = isset($_POST['nombre_carrera']) ? $_POST['nombre_carrera']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($clave2, $nombre, $clave));
	  	header('Location: carreras.php');
	}

	if(isset( $_GET['clave_carrera'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT * FROM carrera where clave_carrera = ?';
		$clave = isset( $_GET['clave_carrera']) ? $_GET['clave_carrera'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($clave));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT * FROM carrera WHERE nombre_carrera like :search';
	$search_terms = isset($_GET['nombre_carrera']) ? $_GET['nombre_carrera'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT * FROM carrera';
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
									Ingrese el nombre de la carrera
									<input type="text" name="nombre_carrera" placeholder = "Ej. Ingenieria en informatica">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_carrera.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Carreras</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave carrera</th>
				          	<th>Nombre carrera</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['clave_carrera']?></td>
							<td><?php echo $rs2['nombre_carrera']?></td>
							<td><a class="btn waves-effect waves-light" href="carreras.php?clave_carrera=<?php echo $rs2['clave_carrera']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_carrera(<?php echo $rs2['clave_carrera']; ?>)" href="#">ELIMINAR</a>
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
          							<input placeholder="<?php echo $rs_details['clave_carrera'] ?>" name="clave_carrera2" type="text" value="<?php echo $rs_details['clave_carrera'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s12">
          							<input placeholder="<?php echo $rs_details['nombre_carrera'] ?>" name="nombre_carrera" type="text" value="<?php echo $rs_details['nombre_carrera'] ?>">
        						</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="carreras.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Carreras</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave carrera</th>
				          	<th>Nombre carrera</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['clave_carrera']?></td>
							<td><?php echo $rs2['nombre_carrera']?></td>
							<td><a class="btn waves-effect waves-light" href="carreras.php?clave_carrera=<?php echo $rs2['clave_carrera']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_carrera(<?php echo $rs2['clave_carrera']; ?>)" href="#">ELIMINAR</a>
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
