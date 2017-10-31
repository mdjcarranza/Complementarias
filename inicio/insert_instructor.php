<?php
	require_once('../conexion/conexion.php');
	$title = 'Instructores';
	$title_menu = 'Instructores';
	$sql_carrera = 'SELECT * FROM act_complementaria';

	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO instructor ( rfc_instructor, nombre_instructor, apellido_paterno_instructor, apellido_materno_instructor, act_complementaria_clave_act ) VALUES( ?, ?, ?, ?, ? )';

  		$clave = isset($_POST['rfc_instructor']) ? $_POST['rfc_instructor']: '';
  		$nombre = isset($_POST['nombre_instructor']) ? $_POST['nombre_instructor']: '';
  		$apellido_p = isset($_POST['apellido_paterno_instructor']) ? $_POST['apellido_paterno_instructor']: '';
  		$apellido_m = isset($_POST['apellido_materno_instructor']) ? $_POST['apellido_materno_instructor']: '';
  		$foranea = isset($_POST['act_complementaria_clave_act']) ? $_POST['act_complementaria_clave_act']: '';

  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($clave,$nombre,$apellido_p, $apellido_m,$foranea));

	}

	$sql_status = 'SELECT instructor.*, act_complementaria.nombre_act FROM instructor INNER JOIN act_complementaria ON act_complementaria.clave_act = instructor.act_complementaria_clave_act ORDER BY rfc_instructor';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute();
	$results_status = $statement_status->fetchAll();
	include("../extend/header.php");
?>
<div class="container">

			<div class="row">
				<form method="post" class="col s12">
					<div class="row">
						<h2>Insertar instructor</h2>
						<hr>
						<div class="input-field col s12">
          				<input placeholder="RFC" name="rfc_instructor" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s4">
        				<i class="material-icons prefix">account_circle</i>
          				<input placeholder="Nombre" name="nombre_instructor" type="text">
        				</div>
        				<div class="input-field col s4">
        					 <i class="material-icons prefix">account_circle</i>
          				<input placeholder="Apellido Paterno" name="apellido_paterno_instructor" type="text">
        				</div>
        				<div class="input-field col s4">
        					 <i class="material-icons prefix">account_circle</i>
          				<input placeholder="Apellido Materno" name="apellido_materno_instructor" type="text">
        				</div>
        			</div>
        			<div class="row">
        				<div class="input-field col s12">
                  		<select name="act_complementaria_clave_act">
                  			<option value="" disabled selected>Elige la actividad complementaria</option>
                  			<?php 
				        	foreach($results as $rs) {
				        	?>
  							<option value="<?php echo $rs['clave_act']?>"><?php echo $rs['nombre_act']?></option>
  							<?php 
				          	}
				        ?>
						</select>
						<label>Actividad complementaria</label>
						</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="instructores.php" class = "btn waves-effect waves-light" type="submit">Regresar</a>
        		</form>
      		</div>
			<div class="row">
				<div class="col s12">
				    <h3>Estudiantes</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>RFC</th>
				          	<th>Nombre</th>
				            <th>Apellido Paterno</th>
				            <th>Apellido Materno</th>
				            <th>Actividad complementaria</th>
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