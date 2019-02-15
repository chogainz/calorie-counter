@include('layouts.app') 
@section('content') 
@stop
<div class="container container-full-height  d-flex justify-content-center align-items-center">
	<div class="row d-flex justify-content-center">
		<div class="card card-default">
			<div class="form-group">
				<h5 class="card-header">Update your Goals</h5>
				<form class="card-body" method="POST" action="{{route('goals.update',['user_id'=>$goals->user_id])}}">
					{{ method_field('PATCH') }} {{ csrf_field() }}
					<label>Calories Target</label>
					<input type="text" name="calories_target" value="{{$goals->calories_target}}" class="form-control">
					<h6 class="mt-2">Macronutrients</h6>

					<div class="d-flex">
						<div class="mr-2">
							<label>Protein (%)</label>
							<input type="text" name="protein_percentage" value="{{$goals->protein_percentage}}" class="form-control">
							<label>Carbohydrates (%)</label>
							<input type="text" name="carbohydrates_percentage" value="{{$goals->carbohydrates_percentage}}" class="form-control">
							<label>Fat (%)</label>
							<input type="text" name="fat_percentage" value="{{$goals->fat_percentage}}" class="form-control">

						</div>

						<div>

							<label>Protein Target (grams)</label>
							<input type="text" disabled name="protein_target" value="{{$userTargets->protein_target}}" class="form-control">
							<label>Carbohydrates Target (grams)</label>
							<input type="text" disabled name="carbohydrates_target" value="{{$userTargets->carbohydrates_target}}" class="form-control">
							<label>Fat Target (grams)</label>
							<input type="text" disabled name="fat_targete" value="{{$userTargets->fat_target}}" class="form-control">

						</div>
					</div>


					<button class="btn-primary btn btn-save mt-2" type="submit">Update</button>
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