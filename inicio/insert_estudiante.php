<?php
	require_once('../conexion/conexion.php');
	$title = 'Estudiantes';
	$title_menu = 'Estudiantes';
	$sql_carrera = 'SELECT * FROM carrera';

	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO estudiante ( No_control, nombre_estudiante, apellido_paterno_estudiante, apellido_materno_estudiante, semestre, carrera_clave_carrera ) VALUES( ?, ?, ?, ?, ?, ? )';

  		$noControl = isset($_POST['No_control']) ? $_POST['No_control']: '';
  		$nombreEstudiante = isset($_POST['nombre_estudiante']) ? $_POST['nombre_estudiante']: '';
  		$apellido_p_Estudiante = isset($_POST['apellido_paterno_estudiante']) ? $_POST['apellido_paterno_estudiante']: '';
  		$apellido_m_Estudiante = isset($_POST['apellido_materno_estudiante']) ? $_POST['apellido_materno_estudiante']: '';
  		$semestre = isset($_POST['semestre']) ? $_POST['semestre']: '';
  		$carrera_clave = isset($_POST['carrera_clave_carrera']) ? $_POST['carrera_clave_carrera']: '';

  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($noControl,$nombreEstudiante,$apellido_p_Estudiante, $apellido_m_Estudiante,$semestre,$carrera_clave));

	}

	$sql_status = 'SELECT estudiante.*, carrera.nombre_carrera FROM estudiante INNER JOIN carrera ON carrera.clave_carrera = estudiante.carrera_clave_carrera ORDER BY No_control';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute();
	$results_status = $statement_status->fetchAll();
	include("../extend/header.php");
?>
<div class="container">

			<div class="row">
				<form method="post" class="col s12">
					<div class="row">
						<h2>Insertar estudiante</h2>
						<hr>
						<div class="input-field col s12">
          				<input placeholder="Número de control" name="No_control" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s4">
        				<i class="material-icons prefix">account_circle</i>
          				<input placeholder="Nombre" name="nombre_estudiante" type="text">
        				</div>
        				<div class="input-field col s4">
        					 <i class="material-icons prefix">account_circle</i>
          				<input placeholder="Apellido Paterno" name="apellido_paterno_estudiante" type="text">
        				</div>
        				<div class="input-field col s4">
        					 <i class="material-icons prefix">account_circle</i>
          				<input placeholder="Apellido Materno" name="apellido_materno_estudiante" type="text">
        				</div>
        			</div>
        			<div class="row">
        				<div class="input-field col s12">
    						<select name="semestre">
	      						<option value="" disabled selected>Elige el semestre</option>
	      						<option value="I">I</option>
	  							<option value="II">II</option>
	  							<option value="III">III</option>
	  							<option value="IV">IV</option>
	  							<option value="V">V</option>
	  							<option value="VI">VI</option>
	  							<option value="VII">VII</option>
	  							<option value="VIII">VIII</option>
	  							<option value="IX">IX</option>
	  							<option value="X">X</option>
	  							<option value="XI">XI</option>
	  							<option value="XII">XII</option>
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
  							<option value="<?php echo $rs['clave_carrera']?>"><?php echo $rs['nombre_carrera']?></option>
  							<?php 
				          	}
				        ?>
						</select>
						<label>Carrera</label>
						</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="estudiantes.php" class = "btn waves-effect waves-light" type="submit">Regresar</a>
        		</form>
      		</div>
			<div class="row">
				<div class="col s12">
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