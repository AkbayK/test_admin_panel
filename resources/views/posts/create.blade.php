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
		<form action="{{ isset($item) ? route('posts.update', $item) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			@if(isset($item))
				@method('PUT')
			@endif

			<div class="form-group">
				<label for="name">Наименование *</label>
				<input type="text" id="name" class="form-control" required name="name" value="{{ isset($item) ? $item->name : '' }}">
			</div>
			@if(isset($item))
				<div class="form-group">
					<img src="{{ asset('/storage/' . $item->image) }}" style="width: 30%">
				</div>
			@endif
			<div class="form-group">
				<label for="image">Изображение</label>
				<input type="file" class="form-control" name="image" id="image">
			</div>
			
			<div class="form-group">
				<label for="category_id">Категория *</label>
				<select name="category_id" id="category_id" class="form-control" required>
					@foreach($categories as $category)
						<option value="{{ $category->id }}"
							@if(isset($item))
								@if($category->id == $item->category_id)
									selected
								@endif
							@endif
							>
							{{ $category->name }}
						</option>
					@endforeach
				</select>
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