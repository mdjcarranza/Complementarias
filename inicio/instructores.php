<?php
	require_once('../conexion/conexion.php');
	$title = 'Instructores';
	$title_menu = 'Instructores';

	$sql_carrera = 'SELECT * FROM act_complementaria';
	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	$show_form1 = FALSE;
	$show_form2 = FALSE;
	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE instructor SET rfc_instructor = ?, nombre_instructor = ?, apellido_paterno_instructor = ?, apellido_materno_instructor = ?, act_complementaria_clave_act = ? WHERE rfc_instructor = ?';

		$clave = isset($_GET['rfc_instructor']) ? $_GET['rfc_instructor']: '';
		$clave2 = isset($_POST['rfc_instructor2']) ? $_POST['rfc_instructor2']: '';
  		$nombre = isset($_POST['nombre_instructor']) ? $_POST['nombre_instructor']: '';
  		$apellido_p = isset($_POST['apellido_paterno_instructor']) ? $_POST['apellido_paterno_instructor']: '';
  		$apellido_m = isset($_POST['apellido_materno_instructor']) ? $_POST['apellido_materno_instructor']: '';
  		$foranea = isset($_POST['act_complementaria_clave_act']) ? $_POST['act_complementaria_clave_act']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($clave2,$nombre,$apellido_p,$apellido_m,$foranea, $clave));
	  	header('Location: instructores.php');
	}

	if(isset( $_GET['rfc_instructor'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT instructor.*, act_complementaria.nombre_act FROM instructor INNER JOIN act_complementaria ON act_complementaria.clave_act = instructor.act_complementaria_clave_act WHERE rfc_instructor = ?';
		$clave = isset( $_GET['rfc_instructor']) ? $_GET['rfc_instructor'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($clave));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT instructor.*, act_complementaria.nombre_act FROM instructor INNER JOIN act_complementaria ON act_complementaria.clave_act = instructor.act_complementaria_clave_act where nombre_instructor like :search';
	$search_terms = isset($_GET['nombre_instructor']) ? $_GET['nombre_instructor'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT instructor.*, act_complementaria.nombre_act FROM instructor INNER JOIN act_complementaria ON act_complementaria.clave_act = instructor.act_complementaria_clave_act';
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
									Ingrese el nombre del instructor
									<input type="text" name="nombre_instructor" placeholder = "Ej. Leonel">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_instructor.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Instructores</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>RFC instructor</th>
				          	<th>Nombre</th>
				            <th>Apellido Paterno</th>
				            <th>Apellido Materno</th>
				            <th>Actividad complementaria</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['rfc_instructor']?></td>
							<td><?php echo $rs2['nombre_instructor']?></td>
							<td><?php echo $rs2['apellido_paterno_instructor']?></td>
							<td><?php echo $rs2['apellido_materno_instructor']?></td>
							<td><?php echo $rs2['act_complementaria_clave_act']?></td>
							<td><a class="btn waves-effect waves-light" href="instructores.php?rfc_instructor=<?php echo $rs2['rfc_instructor']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_instructor(<?php echo $rs2['rfc_instructor']; ?>)" href="#">ELIMINAR</a>
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
          							<input placeholder="<?php echo $rs_details['rfc_instructor'] ?>" name="rfc_instructor2" type="text" value="<?php echo $rs_details['rfc_instructor'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s4">
          							<input placeholder="<?php echo $rs_details['nombre_instructor'] ?>" name="nombre_instructor" type="text" value="<?php echo $rs_details['nombre_instructor'] ?>">
        						</div>
        						<div class="input-field col s4">
        							
          							<input placeholder="<?php echo $rs_details['apellido_paterno_instructor'] ?>" name="apellido_paterno_instructor" type="text" value="<?php echo $rs_details['apellido_paterno_instructor'] ?>">
        						</div>
        						<div class="input-field col s4">
        					 		
          						<input placeholder="<?php echo $rs_details['apellido_materno_instructor'] ?>" name="apellido_materno_instructor" type="text" value="<?php echo $rs_details['apellido_materno_instructor'] ?>">
        						</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
                  					<select name="act_complementaria_clave_act">
                  						<option value="" disabled selected>Elige la actividad complementaria</option>
                  						<?php 
				        					foreach($results as $rs) {
				        				?>
  										<option value="<?php echo $rs['clave_act']?>" <?php $selected = ($rs_details['nombre_act'] == $rs['nombre_act']) ? "SELECTED" : ""; echo $selected ?>><?php echo $rs['nombre_act']?></option>
  										<?php 
				          					}
				        				?>
									</select>
									<label>Actividad complementaria</label>
								</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="instructores.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Instructores</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>RFC instructor</th>
				          	<th>Nombre</th>
				            <th>Apellido Paterno</th>
				            <th>Apellido Materno</th>
				            <th>Actividad complementaria</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['rfc_instructor']?></td>
							<td><?php echo $rs2['nombre_instructor']?></td>
							<td><?php echo $rs2['apellido_paterno_instructor']?></td>
							<td><?php echo $rs2['apellido_materno_instructor']?></td>
							<td><?php echo $rs2['act_complementaria_clave_act']?></td>
							<td><a class="btn waves-effect waves-light" href="instructores.php?rfc_instructor=<?php echo $rs2['rfc_instructor']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_instructor(<?php echo $rs2['rfc_instructor']; ?>)" href="#">ELIMINAR</a>
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
