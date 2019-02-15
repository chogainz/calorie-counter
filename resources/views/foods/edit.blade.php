@include('layouts.app') 
@section('content') 
@stop
<div class="container container-full-height  d-flex justify-content-center align-items-center">
	<div class="row d-flex justify-content-center">
		<div class="card card-default">
			<div class="form-group">
				<h5 class="card-header">Edit Food</h5>
				<form class="card-body" method="POST" action="{{route('foods.update', ['id' => $foods->id])}}">
					{{ csrf_field() }} {{ method_field('PATCH') }}
					<label>Name</label>
					<input type="text" name="food_name" value="{{$foods->food_name}}" class="form-control">
					<h6 class="mt-2">Macronutrients</h6>
					<label>Protein (grams)</label>
					<input type="text" name="protein_content" value="{{$foods->protein_content}}" class="form-control">
					<label>Carbohydrates (grams)</label>
					<input type="text" name="carbohydrates_content" value="{{$foods->carbohydrates_content}}" class="form-control">
					<label>Fat (grams)</label>
					<input type="text" name="fat_content" value="{{$foods->fat_content}}" class="form-control mb-2">
					<button class="btn-primary btn btn-save" type="submit">Update</button>
					<!-- Button trigger modal -->
					<a href="" class="btn btn-danger btn-save" data-toggle="modal" data-target="#deleteConfirm">Delete</a>
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
		<!-- Modal -->





		<div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Confirm Delete?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete this record?</p>
					</div>
					<div class="modal-footer">
						<form method="POST" action="{{ route('foods.destroy', $foods->id) }}">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="DELETE" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger">Delete</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>