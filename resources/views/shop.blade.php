@extends('layouts.app')

@section('title', 'Venta Produtos')

@section('content')

	<div class="row">
		<div class="col col-lg-10">
			<h2><i class="fas fa-store"></i> 
				Detalles de compra
			</h2>
		</div>
		<div class="col col-lg-1 float-right">
			<a href="/listado" data-toggle="tooltip" data-placement="top" title="Ver Listado">
				<i class="fas fa-clipboard-list" style="font-size: 1.5rem;"></i>
			</a>
		</div>
	</div>

    <div id="failureMessage"></div>

    <form id="frmPagos">
		@csrf
        <div class="card">
			<div class="card-body">
				<div class="card">
					<div class="card-header bg-evertec">
						Cliente
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" required />
								<div class="invalid-feedback">Por favor diligencia el nombre.</div>
							</div>
							<div class="form-group col-md-6">
								<label for="apellidos">Apellidos</label>
								<input type="text" class="form-control" id="apellidos" name="apellidos" required />
								<div class="invalid-feedback">Por favor diligencia los apellidos.</div>
							</div>
							<div class="form-group col-md-6">
								<label for="celular">Celular</label>
								<input type="text" class="form-control" id="celular" name="celular" required />
								<div class="invalid-feedback">Por favor diligencia el celular.</div>
							</div>
							<div class="form-group col-md-6">
								<label for="correo">Correo electrónico</label>
								<input type="email" class="form-control" id="correo" name="correo" required />
								<div class="invalid-feedback">Por favor diligencia el correo.</div>
							</div>
						</div>
					</div>
				</div>
			
				<div class="card mt-4">
					<div class="card-header bg-evertec">
						Producto
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-2">
								<label for="referencia">Referencia</label>
								<input type="text" readonly class="form-control" id="referencia" name="referencia" value="<?= time() ?>" />
							</div>
							<div class="form-group col-md-4">
								<label for="descripcion">Descripción</label>
								<input type="text" readonly class="form-control" id="descripcion" name="descripcion" value="Producto Prueba" />
							</div>
							<div class="form-group col-md-3">
								<label for="total">Total</label>
								<input type="text" class="form-control" id="total" name="total" value="250000"/>
							</div>
							<div class="form-group col-md-3">
								<label for="moneda">Moneda</label>
								<input type="text" readonly="readonly" class="form-control" id="moneda" name="moneda" value="COP" />
							</div>
						</div>
					</div>
				</div>

				<button type="button" class="btn btn-primary float-right mt-2" onclick="realizar_pago();">Realizar pago</button>
			</div>
        </div>
    </form>
@endsection

@section('footer')
	<script>
		function realizar_pago() {
			let form = document.getElementById('frmPagos');
			
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
			}else{

				let data = $( '#frmPagos' ).serialize();

				$.ajax({
					url: '/pago',
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					dataType: 'json',
					type : 'POST',
					data,
					success: function(response) {
						window.location.href = response.processUrl;
					},
					error: function(xhr){
						console.log(xhr);
					}
				});
			}

			form.classList.add('was-validated');
		};
	</script>
@endsection