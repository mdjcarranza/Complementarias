<?php
	require_once('../conexion/conexion.php');
	$title = 'Estudiantes';
	$title_menu = 'Estudiantes';

	$sql_carrera = 'SELECT * FROM carrera';
	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	$show_form1 = FALSE;
	$show_form2 = FALSE;
	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE estudiante SET No_control = ?, nombre_estudiante = ?, apellido_paterno_estudiante = ?, apellido_materno_estudiante = ?, semestre = ?, carrera_clave_carrera = ? WHERE No_control = ?';

		$noControl = isset($_GET['No_control']) ? $_GET['No_control']: '';
		$noControl_2 = isset($_POST['No_control_2']) ? $_POST['No_control_2']: '';
  		$nombreEstudiante = isset($_POST['nombre_estudiante']) ? $_POST['nombre_estudiante']: '';
  		$apellido_p_Estudiante = isset($_POST['apellido_paterno_estudiante']) ? $_POST['apellido_paterno_estudiante']: '';
  		$apellido_m_Estudiante = isset($_POST['apellido_materno_estudiante']) ? $_POST['apellido_materno_estudiante']: '';
  		$semestre = isset($_POST['semestre']) ? $_POST['semestre']: '';
  		$carrera_clave = isset($_POST['carrera_clave_carrera']) ? $_POST['carrera_clave_carrera']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($noControl_2,$nombreEstudiante,$apellido_p_Estudiante,$apellido_m_Estudiante,$semestre,$carrera_clave, $noControl));
	  	header('Location: estudiantes.php');
	}

	if(isset( $_GET['No_control'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT estudiante.*, carrera.nombre_carrera FROM estudiante INNER JOIN carrera ON carrera.clave_carrera = estudiante.carrera_clave_carrera WHERE No_control = ?';
		$noControl = isset( $_GET['No_control']) ? $_GET['No_control'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($noControl));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT estudiante.*, carrera.nombre_carrera FROM estudiante INNER JOIN carrera ON carrera.clave_carrera = estudiante.carrera_clave_carrera where nombre_estudiante like :search';
	$search_terms = isset($_GET['nombre_estudiante']) ? $_GET['nombre_estudiante'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT estudiante.*, carrera.nombre_carrera FROM estudiante INNER JOIN carrera ON carrera.clave_carrera = estudiante.carrera_clave_carrera';
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
									Ingrese el nombre del estudiante
									<input type="text" name="nombre_estudiante" placeholder = "Ej. Pedro">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_estudiante.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Estudiantes</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>No Control</th>
				          	<th>Nombre</th>
				            <th>Apellido Paterno</th>
				            <th>Apellido Materno</th>
				            <th>Semestre</th>
				            <th>Carrera</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['No_control']?></td>
							<td><?php echo $rs2['nombre_estudiante']?></td>
							<td><?php echo $rs2['apellido_paterno_estudiante']?></td>
							<td><?php echo $rs2['apellido_materno_estudiante']?></td>
							<td><?php echo $rs2['semestre']?></td>
							<td><?php echo $rs2['nombre_carrera']?></td>
							<td><a class="btn waves-effect waves-light" href="estudiantes.php?No_control=<?php echo $rs2['No_control']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_estudiante(<?php echo $rs2['No_control']; ?>)" href="#">ELIMINAR</a>
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
          							<input placeholder="<?php echo $rs_details['No_control'] ?>" name="No_control_2" type="text" value="<?php echo $rs_details['No_control'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s4">
          							<input placeholder="<?php echo $rs_details['nombre_estudiante'] ?>" name="nombre_estudiante" type="text" value="<?php echo $rs_details['nombre_estudiante'] ?>">
        						</div>
        						<div class="input-field col s4">
        							
          							<input placeholder="<?php echo $rs_details['apellido_paterno_estudiante'] ?>" name="apellido_paterno_estudiante" type="text" value="<?php echo $rs_details['apellido_paterno_estudiante'] ?>">
        						</div>
        						<div class="input-field col s4">
        					 		
          						<input placeholder="<?php echo $rs_details['apellido_materno_estudiante'] ?>" name="apellido_materno_estudiante" type="text" value="<?php echo $rs_details['apellido_materno_estudiante'] ?>">
        						</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
    								<select name="semestre">
			      						<option value="" disabled>Elige el semestre</option>
			      						<option value="I" <?php $selected = ($rs_details['semestre'] == 'I') ? "SELECTED" : ""; echo $selected ?>>I</option>
			  							<option value="II" <?php $selected = ($rs_details['semestre'] == 'II') ? "SELECTED" : ""; echo $selected ?>>II</option>
			  							<option value="III" <?php $selected = ($rs_details['semestre'] == 'III') ? "SELECTED" : ""; echo $selected ?>>III</option>
			  							<option value="IV" <?php $selected = ($rs_details['semestre'] == 'IV') ? "SELECTED" : ""; echo $selected ?>>IV</option>
			  							<option value="V" <?php $selected = ($rs_details['semestre'] == 'V') ? "SELECTED" : ""; echo $selected ?>>V</option>
			  							<option value="VI" <?php $selected = ($rs_details['semestre'] == 'VI') ? "SELECTED" : ""; echo $selected ?>>VI</option>
			  							<option value="VII" <?php $selected = ($rs_details['semestre'] == 'VII') ? "SELECTED" : ""; echo $selected ?>>VII</option>
			  							<option value="VIII" <?php $selected = ($rs_details['semestre'] == 'VIII') ? "SELECTED" : ""; echo $selected ?>>VIII</option>
			  							<option value="IX" <?php $selected = ($rs_details['semestre'] == 'IX') ? "SELECTED" : ""; echo $selected ?>>IX</option>
			  							<option value="X" <?php $selected = ($rs_details['semestre'] == 'X') ? "SELECTED" : ""; echo $selected ?>>X</option>
			  							<option value="XI" <?php $selected = ($rs_details['semestre'] == 'XI') ? "SELECTED" : ""; echo $selected ?>>XI</option>
			  							<option value="XII" <?php $selected = ($rs_details['semestre'] == 'XII') ? "SELECTED" : ""; echo $selected ?>>XII</option>
    								</select>
    								<label>Semestre</label>
  								</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
                  					<select name="carrera_clave_carrera">
                  						<option value="" disabled selected>Elige la carrera</option>
                  						<?php 
				        					foreach($results as $rs) {
				        				?>
  										<option value="<?php echo $rs['clave_carrera']?>" <?php $selected = ($rs_details['nombre_carrera'] == $rs['nombre_carrera']) ? "SELECTED" : ""; echo $selected ?>><?php echo $rs['nombre_carrera']?></option>
  										<?php 
				          					}
				        				?>
									</select>
									<label>Carrera</label>
								</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="estudiantes.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Estudiantes</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>No Control</th>
				          	<th>Nombre</th>
				            <th>Apellido Paterno</th>
				            <th>Apellido Materno</th>
				            <th>Semestre</th>
				            <th>Carrera</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['No_control']?></td>
							<td><?php echo $rs2['nombre_estudiante']?></td>
							<td><?php echo $rs2['apellido_paterno_estudiante']?></td>
							<td><?php echo $rs2['apellido_materno_estudiante']?></td>
							<td><?php echo $rs2['semestre']?></td>
							<td><?php echo $rs2['nombre_carrera']?></td>
							<td><a class="btn waves-effect waves-light" href="estudiantes.php?No_control=<?php echo $rs2['No_control']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_estudiante(<?php echo $rs2['No_control']; ?>)" href="#">ELIMINAR</a>
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
