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

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO solicitud ( folio, asunto, fecha, lugar, instituto_clave_instituto, instructor_rfc_instructor, estudiante_No_control_estudiante ) VALUES( ?, ?, ?, ?, ?, ?, ? )';

  		$folio = isset($_POST['folio']) ? $_POST['folio']: '';
  		$asunto = isset($_POST['asunto']) ? $_POST['asunto']: '';
  		$fecha = isset($_POST['fecha']) ? $_POST['fecha']: '';
  		$lugar = isset($_POST['lugar']) ? $_POST['lugar']: '';
  		$instituto = isset($_POST['instituto_clave_instituto']) ? $_POST['instituto_clave_instituto']: '';
  		$instructor = isset($_POST['instructor_rfc_instructor']) ? $_POST['instructor_rfc_instructor']: '';
  		$estudiante = isset($_POST['estudiante_No_control_estudiante']) ? $_POST['estudiante_No_control_estudiante']: '';
  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($folio,$asunto,$fecha, $lugar,$instituto,$instructor,$estudiante));

	}

	$sql_status = 'SELECT solicitud.*, instituto.nombre_instituto, instructor.nombre_instructor, estudiante.nombre_estudiante FROM solicitud INNER JOIN instituto ON instituto.clave_instituto = solicitud.instituto_clave_instituto INNER JOIN instructor ON instructor.rfc_instructor = solicitud.instructor_rfc_instructor INNER JOIN estudiante ON estudiante.No_control = solicitud.estudiante_No_control_estudiante ORDER BY folio';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute();
	$results_status = $statement_status->fetchAll();
	include("../extend/header.php");
?>
<div class="container">

			<div class="row">
				<form method="post" class="col s12">
					<div class="row">
						<h2>Insertar solicitud</h2>
						<hr>
						<div class="input-field col s12">
          				<input placeholder="Folio" name="folio" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s4">
          				<input placeholder="Asunto" name="asunto" type="text">
        				</div>
        				<div class="input-field col s4">
          				<input placeholder="Fecha" name="fecha" type="text">
        				</div>
        				<div class="input-field col s4">
          				<input placeholder="Lugar" name="lugar" type="text">
        				</div>
        			</div>
        			<div class="row">
        				<div class="input-field col s12">
                  		<select name="instituto_clave_instituto">
                  			<option value="" disabled selected>Elige el instituto</option>
                  			<?php 
				        	foreach($results1 as $rs) {
				        	?>
  							<option value="<?php echo $rs['clave_instituto']?>"><?php echo $rs['nombre_instituto']?></option>
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
				        	foreach($results2 as $rs) {
				        	?>
  							<option value="<?php echo $rs['rfc_instructor']?>"><?php echo $rs['nombre_instructor']?></option>
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
				        	foreach($results3 as $rs) {
				        	?>
  							<option value="<?php echo $rs['No_control']?>"><?php echo $rs['nombre_estudiante']?></option>
  							<?php 
				          	}
				        ?>
						</select>
						<label>Estudiante</label>
						</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="solicitudes.php" class = "btn waves-effect waves-light" type="submit">Regresar</a>
        		</form>
      		</div>
			<div class="row">
				<div class="col s12">
				    <h3>Estudiantes</h3>
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