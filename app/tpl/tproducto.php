<?php
	include 'head_common.php';
	?>
<span class="breadcrums"><a href="/tienda">Tienda</a> > Producto</span>
<div class="nav_back">

	<button type="button" name="button" id="nav_back"> < </button>

</div>

<div class="container">

	<div class="top_space">
	</div>

	<div class="product_container">

		<img alt="producto <?=$this->dataTable['productos'][0]['nombre']?>" src="/pub/images/<?=$this->dataTable['productos'][0]['img']?>">

		<div class="product_information">

				<div class="product_information_top">

					<h1><?=$this->dataTable['productos'][0]['nombre']?></h1>

					<hr />

					<span id="desc"><?=$this->dataTable['productos'][0]['descripcion']?></span>

				</div>

				<div class="product_information_bottom">

					<span id="precio"><?=$this->dataTable['productos'][0]['precio']?>€
					<?php if( (! empty ($_SESSION['user'])) && ( ($_SESSION['rol']==3) ) ):?>
						<span id="cant" >cantidad:</span>
						<input class="create_input_text" type="number" name="cantidad" value="1" min="1"></span>
						<button class="comprar hvr-grow">Comprar</button>
					<?php else:?>
						</span>
						<button class="comprar_userw hvr-grow">Comprar</button>
					<?php endif;?>

					<span class="id" style="display: none"><?=$this->dataTable['productos'][0]['id_productos']?></span>
					<span class="precio" style="display: none"><?=$this->dataTable['productos'][0]['precio']?></span>

				</div>

			</div>

	</div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php
	include 'footer_common.php';
?>
