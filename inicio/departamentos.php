<?php
	require_once('../conexion/conexion.php');
	$title = 'Departamentos';
	$title_menu = 'Departamentos';

	$sql_carrera = 'SELECT * FROM trabajador';
	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	$show_form1 = FALSE;
	$show_form2 = FALSE;
	if($_POST)
	{
	  	//TODO:UPDATE ARTICLE
	  	$sql_update_details = 'UPDATE departamento SET ClaveDepa = ?, nombre_depa = ?, trabajador_rfc_trabajador = ? WHERE ClaveDepa = ?';

		$clave = isset($_GET['ClaveDepa']) ? $_GET['ClaveDepa']: '';
		$clave2 = isset($_POST['claveDepa2']) ? $_POST['claveDepa2']: '';
  		$nombre = isset($_POST['nombre_depa']) ? $_POST['nombre_depa']: '';
  		$foranea = isset($_POST['trabajador_rfc_trabajador']) ? $_POST['trabajador_rfc_trabajador']: '';

	  	$statement_update_details = $pdo->prepare($sql_update_details);
	  	$statement_update_details->execute(array($clave2,$nombre,$foranea, $clave));
	  	header('Location: departamentos.php');
	}

	if(isset( $_GET['ClaveDepa'] ) )
	{
		//TODO: GET DETAILS
		$show_form1 = TRUE;
		$sql_update = 'SELECT departamento.*, trabajador.nombre_trabajador FROM departamento INNER JOIN trabajador ON trabajador.rfc_trabajador = departamento.trabajador_rfc_trabajador WHERE ClaveDepa = ?';
		$clave = isset( $_GET['ClaveDepa']) ? $_GET['ClaveDepa'] : 0;

		$statement_update = $pdo->prepare($sql_update);
		$statement_update->execute(array($clave));
		$result_details = $statement_update->fetchAll();
		$rs_details = $result_details[0];

	}

	$sql_status = 'SELECT departamento.*, trabajador.nombre_trabajador FROM departamento INNER JOIN trabajador ON trabajador.rfc_trabajador = departamento.trabajador_rfc_trabajador where nombre_depa like :search';
	$search_terms = isset($_GET['nombre_depa']) ? $_GET['nombre_depa'] : '';
	$arr_sql_terms[':search'] = '%'.$search_terms.'%';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute($arr_sql_terms);
	$results_status = $statement_status->fetchAll();

	$sql_show = 'SELECT departamento.*, trabajador.nombre_trabajador FROM departamento INNER JOIN trabajador ON trabajador.rfc_trabajador = departamento.trabajador_rfc_trabajador';
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
									<input type="text" name="nombre_depa" placeholder = "Ej. Sistemas y computacion">
								</label>
							</div>
							<div class = "col s3">
								<input class="btn waves-effect waves-light" type="submit" value = "BUSCAR">
								<hr>
								<a href="insert_departamento.php" class="btn waves-effect waves-light" type="submit">Agregar</a>
							</div>
						</div>
					</form>
					<h3>Departamentos</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave</th>
				          	<th>Nombre departamento</th>
				            <th>RFC trabajador</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_status as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['ClaveDepa']?></td>
							<td><?php echo $rs2['nombre_depa']?></td>
							<td><?php echo $rs2['trabajador_rfc_trabajador']?></td>
							<td><a class="btn waves-effect waves-light" href="departamentos.php?ClaveDepa=<?php echo $rs2['ClaveDepa']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_departamento(<?php echo $rs2['ClaveDepa']; ?>)" href="#">ELIMINAR</a>
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
          							<input placeholder="<?php echo $rs_details['ClaveDepa'] ?>" name="claveDepa2" type="text" value="<?php echo $rs_details['ClaveDepa'] ?>">
        						</div>
							</div>
							<div class="row">
        						<div class="input-field col s12">
          							<input placeholder="<?php echo $rs_details['nombre_depa'] ?>" name="nombre_depa" type="text" value="<?php echo $rs_details['nombre_depa'] ?>">
        						</div>
        					</div>
        					<div class="row">
        						<div class="input-field col s12">
                  					<select name="trabajador_rfc_trabajador">
                  						<option value="" disabled selected>Elige el trabajador</option>
                  						<?php 
				        					foreach($results as $rs) {
				        				?>
  										<option value="<?php echo $rs['rfc_trabajador']?>" <?php $selected = ($rs_details['nombre_trabajador'] == $rs['nombre_trabajador']) ? "SELECTED" : ""; echo $selected ?>><?php echo $rs['nombre_trabajador']?></option>
  										<?php 
				          					}
				        				?>
									</select>
									<label>Trabajador</label>
								</div>
        					</div>
        				<input class="btn waves-effect waves-light" type="submit" value="Modificar" />
        				<a href="departamentos.php" class="btn waves-effect waves-light" type="submit">Cancelar</a>
						</form>
						<h3>Departamentos</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave</th>
				          	<th>Nombre</th>
				            <th>Trabajador</th>
				            <th colspan="2">Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
				        	foreach($results_show as $rs2) {
				        ?>
					    <tr>
					    	<td><?php echo $rs2['ClaveDepa']?></td>
							<td><?php echo $rs2['nombre_depa']?></td>
							<td><?php echo $rs2['trabajador_rfc_trabajador']?></td>
							<td><a class="btn waves-effect waves-light" href="departamentos.php?ClaveDepa=<?php echo $rs2['ClaveDepa']; ?>">Ver Detalles</a></td>
							<td><a class="btn waves-effect waves-light red" onclick="delete_departamento(<?php echo $rs2['ClaveDepa']; ?>)" href="#">ELIMINAR</a>
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
