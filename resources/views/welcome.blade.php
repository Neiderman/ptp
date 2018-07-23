@extends('master')

@section('style')
<style>

</style>
@endsection

@section('contenido')
<div class="jumbotron">
	<div class="container">
		<h1>Bienvenido ala prueba de pagos!</h1>
		<p>Se crea aplicativo de prueba para realizar 'Pagos' con PSE utilizando los WebServices de Place To Pay.</p>
		<p>
			<center>
				<a id="b_pse" class="btn btn-default btn-xs" role="button"><img src="https://www.quibdo-choco.gov.co/Ciudadanos/PublishingImages/logo-pse.PNG"></a>
				<a id="b_cancelar" class="btn btn-danger" role="button" style="display: none;">Cancelar</a>
			</center>
		</p>
	</div>
</div>
<hr>

<div id="form_continue" style="display: none;">

</div>

@endsection

@section('javascripts')
<script>
	$(document).ready(function() {
		$('#b_pse').on('click', function(event) {
			event.preventDefault();
			$('#progress_bar').css('display', 'block');

			
			$.ajax({
				url: "{{ action('HomeController@inPago') }}",
				type: 'POST',
				dataType: 'html',
				data: {
					_token: $('meta[name=_token]').attr('content')
				},
			})
			.done(function(res) {

				setTimeout(function() {
					$('#progress_bar').css('display', 'none');
				}, 1000);

				$('#b_pse').css('display','none');
				$('#b_cancelar').css('display','block');
				$('#form_continue').css('display','block');
				$('#form_continue').html(res);
			})
			.fail(function(res) {
				$('#form_continue').html('<div class="alert alert-danger" role="alert"><center>No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde.</center></div>');
			});
		});

		$('#b_cancelar').on('click', function(event) {
			event.preventDefault();

			$('#form_continue').html();
			$('#b_pse').css('display','block');
			$('#b_cancelar').css('display','none');
			$('#form_continue').css('display','none');
			
			// alert('se cancela');
		});
	});
</script>
@endsection