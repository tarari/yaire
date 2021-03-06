<?php
	include 'head_common.php';
	?>
<span class="breadcrums perfil"><span>Perfil</span> <a href="/login/logout">Cerrar sesion</a></span>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div class="container">
	<div class="top_space">
	</div>
<?php if(empty ($_SESSION['user']) ){ ?>

		<p id="reg_title" class="body_title">¿Que quieres hacer?</p>

		<div class="reg_images">

			<a href="/register"><img id="reg" src="<?= 'pub/images/reg.png'; ?>" alt="clic para registro" class="hvr-grow"/></a>
			<a href="/login"><img id="ini" src="<?= 'pub/images/ini.png'; ?>" alt="clic para iniciar sesion" class="hvr-grow"/></a>

		</div>

<?php
	}
 else{ ?>

<div class="userweb_container">

	<div class="userweb bas">

	<h1>Información Básica</h1>

	<hr>

	<div>
		<b>Email:</b> <span><?=$this->dataTable['userweb'][0]['mail']?></span>
	</div>
	<div>
		<b>Username: </b><span><?=$this->dataTable['userweb'][0]['username']?></span>
	</div>

	<div class="userweb_bottom">

		<a id="user_change_password" href="#">Cambiar password</a>
		<div id="user_password">
			<label>Password Antigua <input type="password" name="antigua" id="antigua" class="w_input"></label>
			<label>Password Nueva <input type="password" name="nueva" id="nueva" class="w_input"></label>
			<label>Repite la Password<input type="password" name="rep" id="rep" class="w_input"></label>
			<input type="button" name="boton" id="cambiar" value="Cambiar">
		</div>

	</div>

	</div>

	<?php
	if($_SESSION['rol']==2)
	{
	?>
	<div class="userweb aprob">

			<img src="/pub/images/aprobado.png" id="users_aprobado" alt="instrucciones para pasar de userweb a usuario de practicas">

			<input type="button" class="test_button hvr-grow" id="reg_practico" value="¡He aprobado!">

	</div>

	<?php
	}
	?>

<?php
if($_SESSION['rol']==3 || $_SESSION['rol']==4)
{
?>
	<div class="userweb pers">

		<h1>Información Personal</h1>
		<hr>

		<div>
			<b>Nombre: </b><span><?=$this->dataTable['datos'][0]['nombre']?></span>
		</div>
		<div>
			<b>Apellidos:</b> <span><?=$this->dataTable['datos'][0]['apellidos']?></span>
		</div>
		<div>
			<b>Dni:</b> <span><?=$this->dataTable['datos'][0]['DNI']?></span>
		</div>
		<div>
			<b>Telefono:</b> <span><?=$this->dataTable['datos'][0]['telf']?></span>
		</div>
		<div>
			<b>Dirección:</b> <span><?=$this->dataTable['datos'][0]['direccion']?></span>
		</div>
		<div>
			<b>Población: </b><span><?=$this->dataTable['datos'][0]['poblacion']?></span>
		</div>
		<div>
			<b>Provincia: </b><span><?=$this->dataTable['datos'][0]['provincia']?></span>
		</div>

		<?php if($_SESSION['rol']==3){ ?>
		<div>
			<b>Autorizado: </b><span>
			<?php

			if( $this->dataTable['datos'][0]['t_aprobado'] == 1 )
			{
				echo 'SI';
			}
			else{
				echo 'NO';
			}

			?>
		</span>
		</div>
		<?php } ?>
	</div>

<?php
}
?>

</div>

<div class="results">

	<?php
	if($_SESSION['rol']==2 || $_SESSION['rol']==4 ){?>

	<div class="grafico">

		<h1>¿Cómo lo llevo?</h1>
		<hr>
		<div id="charts"></div>

	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	    $(function(){

	    	$("#antigua").on('focusout', function(){
	    		antigua = $("#antigua").val();
	    		if(antigua != "")
	    		{
	    			antigua = $.md5(antigua);
		    		$.post("/users/comprobar_contra", {antigua:antigua},function(data){
		    			if(data==1)
		    			{
		    				alert('Contraseña incorrecta');
		    				$("#antigua").val("");
		    			}
		    		});
	    		}
	    	});

	    	$("#cambiar").on('click', function(){
	    		antigua = $("#antigua").val();
	    		nueva = $("#nueva").val();
	    		rep = $("#rep").val();
	    		if(antigua != "" && nueva != "" && rep!= "")
	    		{
	    			if(nueva == rep)
	    			{
	    				nueva = $.md5(nueva);
			    		$.post("/users/cambiar_contra", {nueva:nueva},function(data){
			    				alert(data);
			    		});
	    			}
	    			else
	    			{
	    				alert("Las contraseñas no coinciden");
	    			}
	    		}
	    		else
	    		{
	    			alert("Completa los campos");
	    		}
	    	});
		$.post("/users/generar_grafico", function(data){
				datos = jQuery.parseJSON(data);
				resultado = Array()	;
				j=0;
				for (var i in datos) {
				    if (datos.hasOwnProperty(i)) {
				        resultado[j] =[Object.keys(datos)[j],datos[i]];
				        j++;
				    }
				  }
				  //Intenta separar array y poder recoger sus datos por separado
			      google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(dibujar);
						dibujar();
			});

			function dibujar()
			{
					var data = new google.visualization.DataTable();
					data.addColumn('string','Fecha');
					data.addColumn('number','Total test aprobados');
					data.addRows(
						resultado
					);
					var opciones = {'title':'Total test Aprobados','height':300, 'width':'50%'};
					var grafica = new google.visualization.AreaChart(document.getElementById('charts'));
					grafica.draw(data,opciones);
			}

			  $(window).resize(function() {
					dibujar();
				});

	    });
	</script>

	<?php }

	if($_SESSION['rol']==3 || $_SESSION['rol']==4)
	{

		if($_SESSION['rol']==3)
		{

			if(!empty($this->dataTable['practicas_ph_a']))
			{

				?>

				<div class="userweb practicas_x_rel_al">

					<h1>Practicas por realizar</h1>
					<hr>
					<table id="mapa">
						<tr>
							<td>Fecha y hora</td><td>Profesor</td><td>Zona</td><td>Observaciones</td>
						</tr>
					<?php

				foreach ($this->dataTable['practicas_ph_a'] as $practica) {
					?>
					<tr>
						<td><?=$practica['fecha_hora']?></td><td><?=$practica['Np']?> <?=$practica['Ap']?></td><td><?=utf8_encode($practica['zona'])?></td><td><?=$practica['observaciones']?></td>
					</tr>
					<?php
				}
			}

			if(!empty($this->dataTable['practicas_h_a']))
			{

				?>

				</table>

			</div>
			<div class="userweb practicas_rel_al">

				<h1>Practicas realizadas</h1>
				<hr>
				<table id="mapa">
					<tr>
						<td>Fecha y hora</td><td>Profesor</td><td>Zona</td><td>Observaciones</td>
					</tr>

				<?php

				foreach ($this->dataTable['practicas_h_a'] as $practica) {
					?>
					<tr>
						<td><?=$practica['fecha_hora']?></td><td><?=$practica['Np']?> <?=$practica['Ap']?></td><td><?=utf8_encode($practica['zona'])?></td><td><?=$practica['observaciones']?></td>
					</tr>
					<?php
				}

		}

		?>

		</table>
		</div>

		<?php
		}
		else if($_SESSION['rol']==4)
		{

			if(!empty($this->dataTable['practicas_ph_p']))
			{
				?>

			<div class="userweb practicas_x_rel_pro">

				<h1>Practicas por realizar</h1>
				<hr>
				<table id="mapa">
					<tr>
						<td>Fecha y hora</td><td> Alumno</td><td>Zona</td><td>Observaciones</td><td>¿Realizada?</td>
					</tr>

				<?php
				foreach ($this->dataTable['practicas_ph_p'] as $practica) {
					?>
					<tr>
						<td><?=$practica['fecha_hora']?></td><td><?=$practica['Na']?> <?=$practica['Aa']?></td><td><?=utf8_encode($practica['zona'])?></td><td><?=$practica['observaciones']?></td><td><button class="m_h">hecha<span style="display: none"><?=$practica['id_practicas']?></span></button></td>
					</tr>
					</tr>
					<?php
				}
			}


			if(!empty($this->dataTable['practicas_h_p']))
			{
				?>

				</table>
			</div>
			<div class="userweb practicas_rel_pro table_wrapper">
				<h1>Practicas realizadas</h1>
				<hr>
				<table id="mapa">
					<tr>
						<td>Fecha y hora</td><td>Profesor</td><td>Zona</td><td>Observaciones</td>
					</tr>

				<?php
				foreach ($this->dataTable['practicas_h_p'] as $practica) {
					?>
					<tr>
						<td><?=$practica['fecha_hora']?></td><td><?=$practica['Np']?> <?=$practica['Ap']?></td><td><?=utf8_encode($practica['zona'])?></td><td><?=$practica['observaciones']?></td>
					<?php
				}

			}
			?>

			</table>
		</div>

			<?php
		}
	}
	?>

	<div class="space">
	</div>

</div>

<div class="space">
</div>

</div>

<?php } ?>

	<script src="/pub/js/jquery.md5.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php
	include 'footer_common.php';
?>
