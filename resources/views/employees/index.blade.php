@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
	<a href="{{ route('employee.create') }}" class="btn btn-success">Добавить</a>
</div>

<div class="card card-default">
	<div class="card-header">
		Сотрудники
	</div>
	<div class="card-body">
		<table class="table">
			<thead>
				<th>id</th>
				<th>Почта</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($items as $item)
					<tr>
						<td>
							{{ $item->id }}
						</td>
						<td>
							{{ $item->email }}
						</td>
						<td>
							<a href="{{ route('employee.edit', $item) }}" class="btn btn-info btn-sm">
								Редактировать
							</a>
						</td>
						<td>
							<form action="{{ route('employee.destroy', $item) }}" method="POST">
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

