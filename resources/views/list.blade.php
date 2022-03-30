@extends('layouts.app')
 
@section('title', 'Lista de Pagos')

@section('content')

<div class="card mt-4">
	<div class="card-header bg-evertec">
		<div class="row">
			<div class="col col-lg-10">
				<h2>
					<i class="fas fa-list-ol"></i> Listado de Pagos
				</h2>
			</div>
			<div class="col col-lg-1 float-right">
				<a href="/" data-toggle="tooltip" data-placement="top" title="Realizar Nueva Compra">
					<i class="fa fa-plus-circle" style="font-size: 1.5rem;"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<th>Fecha y hora</th>
					<th>Cliente</th>
					<th>Referencia</th>
					<th>Descripción</th>
					<th>Valor Total</th>
					<th>Opciones</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($responses) && count($responses)): ?>
					@foreach ($responses as $response)
						<tr>
							<td>{{ $response->payment_date }}</td>
							<td>{{ $response->customer_name . " " . $response->customer_surname }}</td>
							<td>{{ $response->payment_reference }}</td>
							<td>{{ $response->payment_description }}</td>
							<td>$ {{ number_format($response->payment_total) }}</td>
							<td>
								<a href="{{ url('/verificar') .'/'. $response->payment_requestId }}" class="btn btn-primary btn-sm">
									<i class="fas fa-eye"></i>
									Ver
								</a>
							</td>
						</tr>
					@endforeach
				<?php else: ?>
					<tr>
						<td colspan="100%" class="text-center">
							No existen tracsacciones.
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
@endsection