@include('layouts.app') 
@section('content') 
@stop
<div class="container d-flex justify-content-center align-items-start mt-5">
	<div class="row d-flex justify-content-center">
		<div class="card card-default">


			<div class="d-flex card-header justify-content-between">
				<h5>All Foods</h5>
				<a class="btn btn-success" href="{{ route('foods.create') }}" class="btn btn-primary btn-edit">Add Food</a>
			</div>

			<table class="table card-body">
				<thead>
					<tr>
						<th>Name</a></th>
						<th>Protein (per 100 grams)</th>
						<th>Carbohydrates (per 100 grams)</th>
						<th>Fat (per 100 grams)</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($foods as $food)
					<tr>
						<td>{{$food->food_name}}</td>
						<td>{{$food->protein_content}}</td>
						<td>{{$food->carbohydrates_content}}</td>
						<td>{{$food->fat_content}}</td>
						<td><a href="{{ route('foods.edit', ['id' => $food->id]) }}" class="btn btn-primary" type="submit">Edit</a></td>

					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>