@extends('layouts.app')

@section('content')
<div class="card card-default">
	<div class="card-header">
		{{ isset($item) ? 'Редактирование' : 'Создание' }}
	</div>
	<div class="card-body">
		@if($errors->any())
			<div class="alert alert-danger">
				<ul class="list-group">
					@foreach($errors->all() as $error)
						<li class="list-group-item text-danger">
							{{ $error }}
						</li>
					@endforeach
				</ul>
			</div>
		@endif
		<form action="{{ isset($item) ? route('employee.update', $item) : route('employee.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			@if(isset($item))
				@method('PUT')
			@endif

			<div class="form-group">
				<label for="name">Имя</label>
				<input type="text" id="name" class="form-control" name="name" value="{{ isset($item) ? $item->name : '' }}">
			</div>
			<div class="form-group">
				<label for="email">Почта *</label>
				<input type="text" id="email" class="form-control" required name="email" value="{{ isset($item) ? $item->email : '' }}">
			</div>
			<div class="form-group">
				<label for="password">Пароль *</label>
				<input type="text" id="password" class="form-control" name="password">
			</div>

			<div class="form-group">
				<button class="btn btn-success"> 
					{{ isset($item) ? 'Редактировать' : 'Добавить' }}
				</button>
			</div>
		</form>
	</div>
</div>
@endsection