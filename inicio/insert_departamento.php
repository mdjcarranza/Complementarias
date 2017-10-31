<?php
	require_once('../conexion/conexion.php');
	$title = 'Departamentos';
	$title_menu = 'Departamentos';
	$sql_carrera = 'SELECT * FROM trabajador';

	$statement = $pdo->prepare($sql_carrera);
	$statement->execute();
	$results = $statement->fetchAll();

	if( $_POST )
	{

  		$sql_insert = 'INSERT INTO departamento ( ClaveDepa, nombre_depa, trabajador_rfc_trabajador ) VALUES( ?, ?, ? )';

  		$clave = isset($_POST['ClaveDepa']) ? $_POST['ClaveDepa']: '';
  		$nombre = isset($_POST['nombre_depa']) ? $_POST['nombre_depa']: '';
  		$foranea = isset($_POST['trabajador_rfc_trabajador']) ? $_POST['trabajador_rfc_trabajador']: '';

  		$statement_insert = $pdo->prepare($sql_insert);
  		$statement_insert->execute(array($clave,$nombre,$foranea));

	}

	$sql_status = 'SELECT departamento.*, trabajador.nombre_trabajador FROM departamento INNER JOIN trabajador ON trabajador.rfc_trabajador = departamento.trabajador_rfc_trabajador ORDER BY claveDepa';
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
          				<input placeholder="Clave" name="ClaveDepa" type="text">
        				</div>
					</div>
					<div class="row">
        				<div class="input-field col s12">
          				<input placeholder="Nombre" name="nombre_depa" type="text">
        				</div>
        			</div>
        			<div class="row">
        				<div class="input-field col s12">
                  		<select name="trabajador_rfc_trabajador">
                  			<option value="" disabled selected>Elige el trabajador</option>
                  			<?php 
				        	foreach($results as $rs) {
				        	?>
  							<option value="<?php echo $rs['rfc_trabajador']?>"><?php echo $rs['nombre_trabajador']?></option>
  							<?php 
				          	}
				        ?>
						</select>
						<label>Trabajador</label>
						</div>
        			</div>
        			<input class="btn waves-effect waves-light" type="submit" value="Agregar" />
        			<a href="departamentos.php" class = "btn waves-effect waves-light" type="submit">Regresar</a>
        		</form>
      		</div>
			<div class="row">
				<div class="col s12">
				    <h3>Estudiantes</h3>
				    <table class="striped">
					  <thead>
					    <tr>
					    	<th>Clave</th>
				          	<th>Nombre</th>
				            <th>Trabajador</th>
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