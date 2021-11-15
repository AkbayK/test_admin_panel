@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
	<a href="{{ route('posts.create') }}" class="btn btn-success">Добавить</a>
</div>

<div class="card card-default">
	<br>
	<form action="{{ route('posts.index') }}" method="get">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-2">
					<label for="id">Id</label>
					<input type="number" name="id" class="form-control" value="{{ $request_ar->id ? $request_ar->id : '' }}">
				</div>
				<div class="col-md-5">
					<label for="category_id">Категория</label>
					<select name="category_id" id="category_id" class="form-control">
						<option value=""></option>
						@foreach($categories as $category)
							<option value="{{ $category->id }}"
								@if(isset($request_ar->category_id))
									@if($category->id == $request_ar->category)
										selected
									@endif
								@endif>
								{{ $category->name }}
							</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-5">
					<label for="created_user_id">Автор</label>
					<select name="created_user_id" id="created_user_id" class="form-control">
						<option value=""></option>
						@foreach($employees as $employee)
							<option value="{{ $employee->id }}"
								@if(isset($request_ar->created_user_id))
									@if($employee->id == $request_ar->created_user_id)
										selected
									@endif
								@endif>
								{{ $employee->name }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-2">
					<span class="input-group-prepend">
						<button type="submit" class="btn btn-success">Применить</button>
					</span>
				</div>
				<div class="col-md-2">
					<a href="{{ route('posts.index') }}" class="btn btn-primary">
						Сбросить
					</a>
				</div>
			</div>
		</div>
	</form>
	<br>

	<div class="card-header">
		Записи
	</div>
	<div class="card-body">
		<table class="table">
			<thead>
				<th>id</th>
				<th>Наименование</th>
				<th>Категория</th>
				<th>Автор</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($items as $item)
					<tr>
						<td>
							{{ $item->id }}
						</td>
						<td>
							{{ $item->name }}
						</td>
						<td>
							{{ $item->category ? $item->category->name : ''}}
						</td>
						<td>
							{{ $item->author ? $item->author->name : ''}}
						</td>
						<td>
							<a href="{{ route('posts.edit', $item) }}" class="btn btn-info btn-sm">
								Редактировать
							</a>
						</td>
						<td>
							<form action="{{ route('posts.destroy', $item) }}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger btn-sm">
									Удалить
								</button>
							</form>							
						</td>
					</tr>
				@endforeach				
			</tbody>
		</table>
		{{ $items->links() }}
	</div>
</div>
@endsection

