@include('layouts.app') 
@section('content') 
@stop
<div class="container container-full-height  d-flex justify-content-center align-items-center">
	<div class="row d-flex justify-content-center">
		<div class="card card-default">
			<div class="form-group">
				<h5 class="card-header">Create Goals</h5>
				<form class="card-body" method="POST" action="{{route('goals.index')}}">
					{{ csrf_field() }}
					<label>Calories Target</label>
					<input type="text" name="calories_target" value="{{old('calories_target')}}" class="form-control">
					<h6 class="mt-2">Macronutrients</h6>
					<label>Protein (%)</label>
					<input type="text" name="protein_percentage" value="{{old('protein_percentage')}}" class="form-control">
					<label>Carbohydrates (%)</label>
					<input type="text" name="carbohydrates_percentage" value="{{old('carbohydrates_percentage')}}" class="form-control">
					<label>Fat (%)</label>
					<input type="text" name="fat_percentage" value="{{old('fat_percentage')}}" class="form-control">
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