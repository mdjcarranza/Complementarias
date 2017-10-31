<?php
	require_once('../conexion/conexion.php');
	$title = 'Trabajadores';
	$title_menu = 'Trabajadores';

	$show_form1 = FALSE;
	$show_form2 = FALSE;
	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE trabajador SET rfc_trabajador = ?, nombre_trabajador = ?, apellido_paterno_trabajador = ?, apellido_materno_trabajador = ?, clave_presupuestal = ? WHERE rfc_trabajador = ?';

		$clave = isset($_GET['rfc_trabajador']) ? $_GET['rfc_trabajador']: '';
		$clave2 = isset($_POST['rfc_trabajador2']) ? $_POST['rfc_trabajador2']: '';
  		$nombre = isset($_POST['nombre_trabajador']) ? $_POST['nombre_trabajador']: '';
  		$apellido_p = isset($_POST['apellido_paterno_trabajador']) ? $_POST['apellido_paterno_trabajador']: '';
  		$apellido_m = isset($_POST['apellido_materno_trabajador']) ? $_POST['apellido_materno_trabajador']: '';
  		$presu = isset($_POST['clave_presupuestal']) ? $_POST['clave_presupuestal']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($clave2,$nombre,$apellido_p,$apellido_m,$presu, $clave));
	  	header('Location: trabajadores.php');
	}

	if(isset( $_GET['rfc_trabajador'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT * FROM trabajador WHERE rfc_trabajador = ?';
		$clave = isset( $_GET['rfc_trabajador']) ? $_GET['rfc_trabajador'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($clave));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT * FROM trabajador WHERE nombre_trabajador like :search';
	$search_terms = isset($_GET['nombre_trabajador']) ? $_GET['nombre_trabajador'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT * FROM trabajador';
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
									Ingrese el nombre del trabajador
									<input type="text" name="nombre_trabajador" placeholder = "Ej. Leonel">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_trabajador.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Instructores</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>RFC trabajador</th>
				          	<th>Nombre</th>
				            <th>Apellido Paterno</th>
				            <th>Apellido Materno</th>
				            <th>Clave presupuestal</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['rfc_trabajador']?></td>
							<td><?php echo $rs2['nombre_trabajador']?></td>
							<td><?php echo $rs2['apellido_paterno_trabajador']?></td>
							<td><?php echo $rs2['apellido_materno_trabajador']?></td>
							<td><?php echo $rs2['clave_presupuestal']?></td>
							<td><a class="btn waves-effect waves-light" href="trabajadores.php?rfc_trabajador=<?php echo $rs2['rfc_trabajador']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_trabajador(<?php echo $rs2['rfc_trabajador']; ?>)" href="#">ELIMINAR</a>
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
          							<input placeholder="<?php echo $rs_details['rfc_trabajador'] ?>" name="rfc_trabajador2" type="text" value="<?php echo $rs_details['rfc_trabajador'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s4">
          							<input placeholder="<?php echo $rs_details['nombre_trabajador'] ?>" name="nombre_trabajador" type="text" value="<?php echo $rs_details['nombre_trabajador'] ?>">
        						</div>
        						<div class="input-field col s4">
        							
          							<input placeholder="<?php echo $rs_details['apellido_paterno_trabajador'] ?>" name="apellido_paterno_trabajador" type="text" value="<?php echo $rs_details['apellido_paterno_trabajador'] ?>">
        						</div>
        						<div class="input-field col s4">
        					 		
          						<input placeholder="<?php echo $rs_details['apellido_materno_trabajador'] ?>" name="apellido_materno_trabajador" type="text" value="<?php echo $rs_details['apellido_materno_trabajador'] ?>">
        						</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
                  					<input placeholder="<?php echo $rs_details['clave_presupuestal']?>" type="text" name="clave_presupuestal" value = "<?php echo $rs_details['clave_presupuestal']?>">
								</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="trabajadores.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Trabajadores</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>RFC trabajador</th>
				          	<th>Nombre</th>
				            <th>Apellido Paterno</th>
				            <th>Apellido Materno</th>
				            <th>Clave presupuestal</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['rfc_trabajador']?></td>
							<td><?php echo $rs2['nombre_trabajador']?></td>
							<td><?php echo $rs2['apellido_paterno_trabajador']?></td>
							<td><?php echo $rs2['apellido_materno_trabajador']?></td>
							<td><?php echo $rs2['clave_presupuestal']?></td>
							<td><a class="btn waves-effect waves-light" href="trabajadores.php?rfc_trabajador=<?php echo $rs2['rfc_trabajador']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_trabajador(<?php echo $rs2['rfc_trabajador']; ?>)" href="#">ELIMINAR</a>
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
