<?php
	require_once('../conexion/conexion.php');
	$title = 'Trabajadores';
	$title_menu = 'Trabajadores';

	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO instructor ( rfc_trabajador, nombre_trabajador, apellido_paterno_trabajador, apellido_materno_trabajador, clave_presupuestal ) VALUES( ?, ?, ?, ?, ? )';

  		$clave = isset($_POST['rfc_trabajador']) ? $_POST['rfc_trabajador']: '';
  		$nombre = isset($_POST['nombre_trabajador']) ? $_POST['nombre_trabajador']: '';
  		$apellido_p = isset($_POST['apellido_paterno_instructor']) ? $_POST['apellido_paterno_trabajador']: '';
  		$apellido_m = isset($_POST['apellido_materno_trabajador']) ? $_POST['apellido_materno_trabajador']: '';
  		$presu = isset($_POST['clave_presupuestal']) ? $_POST['clave_presupuestal']: '';

  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($clave,$nombre,$apellido_p, $apellido_m,$presu));

	}

	$sql_status = 'SELECT * FROM trabajador ORDER BY rfc_trabajador';
	$statement_status = $pdo->prepare($sql_status);
	$statement_status->execute();
	$results_status = $statement_status->fetchAll();
	include("../extend/header.php");
?>
<div class="container">

			<div class="row">
				<form method="post" class="col s12">
					<div class="row">
						<h2>Insertar trabajador</h2>
						<hr>
						<div class="input-field col s12">
          				<input placeholder="RFC" name="rfc_trabajador" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s4">
        				<i class="material-icons prefix">account_circle</i>
          				<input placeholder="Nombre" name="nombre_trabajador" type="text">
        				</div>
        				<div class="input-field col s4">
        					 <i class="material-icons prefix">account_circle</i>
          				<input placeholder="Apellido Paterno" name="apellido_paterno_trabajador" type="text">
        				</div>
        				<div class="input-field col s4">
        					 <i class="material-icons prefix">account_circle</i>
          				<input placeholder="Apellido Materno" name="apellido_materno_trabajador" type="text">
        				</div>
        			</div>
        			<div class="row">
        				<div class="input-field col s12">
                  		<input placeholder="Clave presupuestal" type="text" name="clave_presupuestal">
						</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="trabajadores.php" class = "btn waves-effect waves-light" type="submit">Regresar</a>
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
				            <th>Clave presupuestal</th>
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