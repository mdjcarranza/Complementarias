<?php
	require_once('../conexion/conexion.php');
	$title = 'Solicitudes';
	$title_menu = 'Solicitudes';

	$sql1 = 'SELECT * FROM instituto';
	$statement1 = $pdo->prepare($sql1);
	$statement1->execute();
	$results1 = $statement1->fetchAll();

	$sql2 = 'SELECT * FROM instructor';
	$statement2 = $pdo->prepare($sql2);
	$statement2->execute();
	$results2 = $statement2->fetchAll();

	$sql3 = 'SELECT * FROM estudiante';
	$statement3 = $pdo->prepare($sql3);
	$statement3->execute();
	$results3 = $statement3->fetchAll();

	$show_form1 = FALSE;
	$show_form2 = FALSE;
	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE solicitud SET folio = ?, asunto = ?, fecha = ?, lugar = ?, instituto_clave_instituto = ?, instructor_rfc_instructor = ?, estudiante_No_control_estudiante = ? WHERE folio = ?';

		$folio = isset($_GET['folio']) ? $_GET['folio']: '';
		$folio2 = isset($_POST['folio2']) ? $_POST['folio2']: '';
  		$asunto = isset($_POST['asunto']) ? $_POST['asunto']: '';
		$fecha = isset($_POST['fecha']) ? $_POST['fecha']: '';
		$lugar = isset($_POST['lugar']) ? $_POST['lugar']: '';
  		$instituto = isset($_POST['instituto_clave_instituto']) ? $_POST['instituto_clave_instituto']: '';
  		$instructor = isset($_POST['instructor_rfc_instructor']) ? $_POST['instructor_rfc_instructor']: '';
  		$estudiante = isset($_POST['estudiante_No_control_estudiante']) ? $_POST['estudiante_No_control_estudiante']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($folio2,$asunto,$fecha,$lugar,$instituto,$instructor,$estudiante, $folio));
	  	header('Location: solicitudes.php');
	}

	if(isset( $_GET['folio'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT solicitud.*, instituto.nombre_instituto, instructor.nombre_instructor, estudiante.nombre_estudiante FROM solicitud INNER JOIN instituto ON instituto.clave_instituto = solicitud.instituto_clave_instituto INNER JOIN instructor ON instructor.rfc_instructor = solicitud.instructor_rfc_instructor INNER JOIN estudiante ON estudiante.No_control = solicitud.estudiante_No_control_estudiante WHERE folio = ?';
		$clave = isset( $_GET['folio']) ? $_GET['folio'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($clave));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT solicitud.*, instituto.nombre_instituto, instructor.nombre_instructor, estudiante.nombre_estudiante FROM solicitud INNER JOIN instituto ON instituto.clave_instituto = solicitud.instituto_clave_instituto INNER JOIN instructor ON instructor.rfc_instructor = solicitud.instructor_rfc_instructor INNER JOIN estudiante ON estudiante.No_control = solicitud.estudiante_No_control_estudiante WHERE asunto like :search';
	$search_terms = isset($_GET['asunto']) ? $_GET['asunto'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT solicitud.*, instituto.nombre_instituto, instructor.nombre_instructor, estudiante.nombre_estudiante FROM solicitud INNER JOIN instituto ON instituto.clave_instituto = solicitud.instituto_clave_instituto INNER JOIN instructor ON instructor.rfc_instructor = solicitud.instructor_rfc_instructor INNER JOIN estudiante ON estudiante.No_control = solicitud.estudiante_No_control_estudiante';
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
									Ingrese el asunto de la solicitud
									<input type="text" name="asunto" placeholder = "Ej. Reinscripcion">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_solicitud.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Solicitudes</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Folio</th>
				          	<th>Asunto</th>
				            <th>Fecha</th>
				            <th>Lugar</th>
				            <th>Instituto</th>
				            <th>Instructor</th>
				            <th>Estudiante</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['folio']?></td>
							<td><?php echo $rs2['asunto']?></td>
							<td><?php echo $rs2['fecha']?></td>
							<td><?php echo $rs2['lugar']?></td>
							<td><?php echo $rs2['instituto_clave_instituto']?></td>
							<td><?php echo $rs2['instructor_rfc_instructor']?></td>
							<td><?php echo $rs2['estudiante_No_control_estudiante']?></td>
							<td><a class="btn waves-effect waves-light" href="solicitudes.php?folio=<?php echo $rs2['folio']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_solicitud(<?php echo $rs2['folio']; ?>)" href="#">ELIMINAR</a>
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
          							<input placeholder="<?php echo $rs_details['folio'] ?>" name="folio2" type="text" value="<?php echo $rs_details['folio'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s4">
          							<input placeholder="<?php echo $rs_details['asunto'] ?>" name="asunto" type="text" value="<?php echo $rs_details['asunto'] ?>">
        						</div>
        						<div class="input-field col s4">
        							
          							<input placeholder="<?php echo $rs_details['fecha'] ?>" name="fecha" type="text" value="<?php echo $rs_details['fecha'] ?>">
        						</div>
        						<div class="input-field col s4">
        					 		
          						<input placeholder="<?php echo $rs_details['lugar'] ?>" name="lugar" type="text" value="<?php echo $rs_details['lugar'] ?>">
        						</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
                  					<select name="instituto_clave_instituto">
                  						<option value="" disabled selected>Elige el instituto</option>
                  						<?php 
				        					foreach($results1 as $rs1) {
				        				?>
  										<option value="<?php echo $rs['clave_instituto']?>" <?php $selected = ($rs_details['nombre_instituto'] == $rs1['nombre_instituto']) ? "SELECTED" : ""; echo $selected ?>><?php echo $rs1['nombre_instituto']?></option>
  										<?php 
				          					}
				        				?>
									</select>
									<label>Instituto</label>
								</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
                  					<select name="instructor_rfc_instructor">
                  						<option value="" disabled selected>Elige el instructor</option>
                  						<?php 
				        					foreach($results2 as $rs2) {
				        				?>
  										<option value="<?php echo $rs['rfc_instructor']?>" <?php $selected = ($rs_details['nombre_instructor'] == $rs2['nombre_instructor']) ? "SELECTED" : ""; echo $selected ?>><?php echo $rs2['nombre_instructor']?></option>
  										<?php 
				          					}
				        				?>
									</select>
									<label>Instructor</label>
								</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
                  					<select name="estudiante_No_control_estudiante">
                  						<option value="" disabled selected>Elige el estudiante</option>
                  						<?php 
				        					foreach($results3 as $rs3) {
				        				?>
  										<option value="<?php echo $rs['No_control']?>" <?php $selected = ($rs_details['nombre_estudiante'] == $rs3['nombre_estudiante']) ? "SELECTED" : ""; echo $selected ?>><?php echo $rs3['nombre_estudiante']?></option>
  										<?php 
				          					}
				        				?>
									</select>
									<label>Estudiante</label>
								</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="solicitudes.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Solicitudes</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Folio</th>
				          	<th>Asunto</th>
				            <th>Fecha</th>
				            <th>Lugar</th>
				            <th>Instituto</th>
				            <th>Instructor</th>
				            <th>Estudiante</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['folio']?></td>
							<td><?php echo $rs2['asunto']?></td>
							<td><?php echo $rs2['fecha']?></td>
							<td><?php echo $rs2['lugar']?></td>
							<td><?php echo $rs2['instituto_clave_instituto']?></td>
							<td><?php echo $rs2['instructor_rfc_instructor']?></td>
							<td><?php echo $rs2['estudiante_No_control_estudiante']?></td>
							<td><a class="btn waves-effect waves-light" href="solicitudes.php?folio=<?php echo $rs2['folio']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_solicitud(<?php echo $rs2['folio']; ?>)" href="#">ELIMINAR</a>
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
