@extends('app')

@section('content')


	<div class="contentBody">

		@if(Session::has('message'))
			<p class="alert alert-info">{{ Session::get('message') }}</p>
		@elseif(Session::has('error'))
			<p class="alert alert-danger">{{ Session::get('error') }}</p>
		@endif

		<h1>Chargement d'un relevé de consommation</h1>

		<div style="margin-top: 50px;margin-bottom: 50px;">
	        <form action="{{ route('uploadFile') }}" method="POST" class="form-upload" enctype="multipart/form-data">
	    		@csrf
				<div class="row">
					<div class="col-md-3">
						<label>Sélectionner un fichier CSV :</label>
					</div>
					<div class="col-md-5">
						<div class="form-control">
							<input type="file" id="file_upload_id" name="file_upload" accept=".csv" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-example">
							<input class="form-control btn btn-primary" type="submit" value="Valider">
						</div>
					</div>
				</div>
			</form>
		</div>

		<div>
			@if(($nbValue) > 0)
				<p>Durée totale réelle des appels effectués après le 15/02/2012 : {{ $dayHourSecond }} ({{ number_format($sumComm->sumComm, 0, ',', ' ') }} secondes)</p>
				<p>TOP 10 des volumes data facturés en dehors de la tranche horaire 8h00-18h00, par abonné : </p>
				@forelse ($topData as $key => $value)
					<li>N°{{ $key + 1 }} -- {{ $value->abonne_id }} : {{ number_format($value->topData, 2, ',', ' ') }} Mo </li>
				@empty
				    <p>-</p>
				@endforelse

				<p style="margin-top: 10px;">Nombre de SMS envoyés : {{ number_format($sumSMS, 0,',', ' ') }}</p>
			@endif

		</div>
	</div>


@endsection  