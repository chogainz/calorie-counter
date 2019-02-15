@include('layouts.app') 
@section('content') 
@stop
<div class="container container-full-height  d-flex justify-content-center align-items-center">
	<div class="row d-flex justify-content-center">
		<div class="card card-default">
			<div class="form-group">
				<h4 class="card-header">Food Consumed</h4>
				<div class="card-body">
					<h5>Total Calories {{$total_calories}}</h5>
					<table class="table">
						<thead>
							<tr>
								<th><a href="">Name</a></th>
								<th><a href="">Amount (grams)</a></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($allFood as $food)
							<tr>
								<td>{{$food->food_name}}</td>
								<td>{{$food->food_grams}}</td>
								<td><a href="{{ route('diaries.edit', ['id' => $food->id]) }}" class="btn btn-primary btn-edit" type="submit">Edit</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<form method="POST" action="{{route('diaries.index',['user_id' => $user_id ])}}">
						{{ csrf_field() }}
						<h5>All Food</h5>

						<div class="d-flex mb-2">
							<label class="col-6 pl-0" >Amount (grams)</label>
							<input type="hidden" value="{{$date_consumed}}" name="date_consumed">
							<input type="hidden" value="{{$user_id}}" name="user_id">
							<input class="form-control" type="text" name="food_grams" value={{old( 'food_grams')}}>
						</div>


						<select name="id" class="custom-select">
						@foreach ($foodSelection as $food)
						<option  value="{{$food->id}}" >{{$food->food_name}}</option>
						@endforeach
						</select>
						<div class='form-group mt-2'>
							<button class="btn btn-primary btn-save" type="submit">Add</button>
						</div>
					</form>
					@if($errors->any())
					<div class="alert alert--error">
						@foreach($errors->all() as $error)
						<p>{{ $error }}</p>
						@endforeach
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>