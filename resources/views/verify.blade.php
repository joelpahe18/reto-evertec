@extends('layouts.app')
 
@section('title', 'Detalle de Pago')

@section('content')

<div class="row">
	<div class="col col-lg-10">
		<h2>
			<i class="far fa-credit-card"></i> 
			Información detallada del pago
		</h2>
	</div>
	<div class="col col-lg-1 float-right">
		<a href="/" data-toggle="tooltip" data-placement="top" title="Realizar Nueva Compra">
			<i class="fa fa-plus-circle" style="font-size: 1.5rem;"></i>
		</a>
	</div>
</div>

<div class="card mt-3 mb-3">
	<div class="card-body">
		<table class="table table-borderless table-sm">
			<tbody>
				<tr>
					<?php if ($object_array->payment[0]->status->status == 'APPROVED'): ?>
						<td colspan="2" class="text-center" style="color: #1e7e34">
							<i class="far fa-check-circle fa-3x"></i>
							</br>
							<p>TRANSACCIÓN APROBADA</p>
						</td>
					<?php elseif ($object_array->payment[0]->status->status == 'PENDING'): ?> 
						<td colspan="2" class="text-center" style="color: #eecf22">
							<i class="far fa-question-circle fa-3x"></i>
							</br>
							<p>TRANSACCIÓN PENDIENTE</p>
						</td>
					<?php else: ?>
						<td colspan="2" class="text-center" style="color: #d6211a">
							<i class="far fa-times-circle fa-3x"></i>
							</br>
							<p>TRANSACCIÓN RECHAZADA</p>
						</td>
					<?php endif; ?>
				</tr>
				<tr>
					<td colspan="2" class="text-center" style="color: #555758">
						<p>Total Pagado</p>
						$ {{ number_format($object_array->payment[0]->amount->from->total) }}
					</td>
				</tr>
				<?php if ( isset( $object_array->payment[0]->receipt ) ): ?>
					<tr>
						<th class="text-center" style="color: #555758">
							Recibo
						</th>
						<td class="text-center" style="color: #555758">
							{{ $object_array->payment[0]->receipt }}
						</td>
					</tr>
				<?php endif; ?>
				<tr>
					<th class="text-center" style="color: #555758">
						Metodo de Pago
					</th>
					<td class="text-center" style="color: #555758">
						{{ $object_array->payment[0]->paymentMethod }}
					</td>
				</tr>
				<tr>
					<th colspan="2" class="text-center thead-light" style="color: #555758">
						Datos de Producto
					</th>
				</tr>
				<tr>
					<th class="text-center" style="color: #555758">
						Referencia
					</th>
					<td class="text-center" style="color: #555758">
						{{ $object_array->request->payment->reference }}
					</td>
				</tr>
				<tr>
					<th class="text-center" style="color: #555758">
						Descripción
					</th>
					<td class="text-center" style="color: #555758">
						{{ $object_array->request->payment->description }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php if ($object_array->payment[0]->status->status == 'PENDING'): ?> 
	<a href="#" data-requestid="{{ $object_array->requestId }}" id="procesar-pago" class="btn btn-primary float-left">
		<i class="fa fa-sync"></i> Procesar Pago
	</a>
<?php endif ?>

<a href="<?= url('listado') ?>" class="btn btn-success float-right">
	<i class="fas fa-undo-alt"></i> Regresar
</a>

@endsection

@section('footer')
	<script>
		$("body").on("click", "a#procesar-pago", function() {
			$.ajax({
				url: '/procesar/' + $("a#procesar-pago").data( 'requestid' ),
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				dataType: 'json',
				type : 'GEt',
				success: function(response) {
					location.reload();
				},
				error: function(xhr){
					console.log(xhr);
				}
			});
		});
	</script>
@endsection