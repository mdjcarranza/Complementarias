<?php
	require_once('../conexion/conexion.php');
	$title = 'Actividades';
	$title_menu = 'Actividades';

	$show_form1 = FALSE;

	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE act_complementaria SET clave_act = ?, nombre_act = ? WHERE clave_act = ?';

		$clave = isset($_GET['clave_act']) ? $_GET['clave_act']: '';
		$clave2 = isset($_POST['clave_act2']) ? $_POST['clave_act2']: '';
  		$nombre = isset($_POST['nombre_act']) ? $_POST['nombre_act']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($clave2, $nombre, $clave));
	  	header('Location: actividades.php');
	}

	if(isset( $_GET['clave_act'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT * FROM act_complementaria where clave_act = ?';
		$clave = isset( $_GET['clave_act']) ? $_GET['clave_act'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($clave));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT * FROM act_complementaria WHERE nombre_act like :search';
	$search_terms = isset($_GET['nombre_act']) ? $_GET['nombre_act'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT * FROM act_complementaria';
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
									Ingrese el nombre de la actividad
									<input type="text" name="nombre_act" placeholder = "Ej. Ajedrez">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_actividad.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Actividades</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave actividad</th>
				          	<th>Nombre actividad</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['clave_act']?></td>
							<td><?php echo $rs2['nombre_act']?></td>
							<td><a class="btn waves-effect waves-light" href="actividades.php?clave_act=<?php echo $rs2['clave_act']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_actividad(<?php echo $rs2['clave_act']; ?>)" href="#">ELIMINAR</a>
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
          							<input placeholder="<?php echo $rs_details['clave_act'] ?>" name="clave_act2" type="text" value="<?php echo $rs_details['clave_act'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s12">
          							<input placeholder="<?php echo $rs_details['nombre_act'] ?>" name="nombre_act" type="text" value="<?php echo $rs_details['nombre_act'] ?>">
        						</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="actividades.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Actividades</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave actividad</th>
				          	<th>Nombre actividad</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['clave_act']?></td>
							<td><?php echo $rs2['nombre_act']?></td>
							<td><a class="btn waves-effect waves-light" href="actividades.php?clave_act=<?php echo $rs2['clave_act']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_actividad(<?php echo $rs2['clave_act']; ?>)" href="#">ELIMINAR</a>
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
