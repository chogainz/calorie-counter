@include('layouts.app') 
@section('content') 
@stop
<div class="container container-full-height  d-flex justify-content-center align-items-center">
	<div class="row d-flex justify-content-center">
		<div class="card card-default">
			<div class="form-group">
				<h5 class="card-header">Add Food</h5>
				<form class="card-body" method="POST" action="{{route('foods.index')}}">
					{{ csrf_field() }}
					<label>Name</label>
					<input type="text" name="food_name" value="{{old('food_name')}}" class="form-control">
					<h6 class="mt-2">Macronutrients</h6>
					<label>Protein (grams)</label>
					<input type="text" name="protein_content" value="{{old('protein_content')}}" class="form-control">
					<label>Carbohydrates (grams)</label>
					<input type="text" name="carbohydrates_content" value="{{old('carbohydrates_content')}}" class="form-control">
					<label>Fat (grams)</label>
					<input type="text" name="fat_content" value="{{old('fat_content')}}" class="form-control">
					<button class="btn-primary btn btn-save mt-2" type="submit">Save</button>
				</form>
				@if (count($errors) > 0)
				<div class="errors alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>