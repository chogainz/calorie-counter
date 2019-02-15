@include('layouts.app') 
@section('content') 
@stop
<div class="container container-full-height  d-flex justify-content-center align-items-center">
	<div class="row d-flex justify-content-center">
		<div class="card card-default">
			<div class="form-group">
				<h4 class="card-header">Edit Food</h4>
				<form class="card-body" method="POST" action="{{route('diaries.update', ['id' => $diaries->id ])}}">
					{{ csrf_field() }} {{ method_field('PATCH') }}

					<h5>All Food</h5>

					<div class="d-flex mb-2">
						<label class="col-6 pl-0">Amount (grams)</label>
						<input type="hidden" value="{{$diaries->date_consumed}}" name="date_consumed">
						<input class="form-control" type="text" name="food_grams" value="{{$diaries->food_grams}}">
					</div>
					<select name="id" class="custom-select">
				@foreach ($food_selection as $food)
				<option  value="{{$food->id}}" >{{$food->food_name}}</option>
				@endforeach
				</select>
					<div class='form-group mt-2'>
						<button class="btn btn-primary btn-save" type="submit">Update</button>
					</div>
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