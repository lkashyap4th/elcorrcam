@extends('layouts.default')
@section('content')
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox">
					<div class="ibox-title">
						<h5>{{ $title or '' }}</h5>
						<div class="ibox-tools">
							<a href="/sets/create" class="btn btn-primary btn-xs">Create Set</a>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<form method="GET" action="/sets">
								<div class="col-sm-12">
									<div class="input-group">
										<input type="text" placeholder="Search sets" class="input form-control" name="global_search" value="{{Request::get('global_search')}}" >
										<span class="input-group-btn">
											<button type="submit" class="btn btn btn-primary "> <i class="fa fa-search"></i> Search</button>
										</span>
									</div>
								</div>
							</form>
						</div>
						@if(count($sets)>0)
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Active</th>
										<th>Created_at</th>
									</tr>
								</thead>
								<tbody class="table_body">
								@foreach($sets as $set)
									<tr>
										<td>{{ $set->name }}</td>
										<td>{{ $set->active ? "Yes":"No" }}</td>
										<td>{{ ucfirst($set->created_at) }}</td>
										<td>
											<div class="btn-group">
												<button data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle">Action <span class="caret"></span></button>
												<ul class="dropdown-menu">
													<li><a href="/sets/view/{{$set->id}}">View</a></li>
													<li><a href="/sets/edit/{{$set->id}}">Edit</a></li>
													<li class="divider"></li>
													<li><a href="#" class="delete-set" data-id={{ $set->id }}>Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
								@endforeach
								@if ($sets->total() > 10)
									<tr>
										<td colspan="6" align="right">
											{{$sets->render()}}
										</td>
									</tr>
								@endif
								</tbody>
							</table>
						@else
							<div class="text-center">
								<p>No Set found in the system, please <a href="/sets/create">create</a> one.</p>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script src="/js/modalform.js"></script>
	<script>
		$('.delete-set').on('click', function(event) {
        event.preventDefault();
        var set_id = $(this).data('id');

        modalform.dialog({
            bootbox : {
                title: 'Delete Set',
                message: ''+
                    '<form action="/sets/delete/' + set_id + '" method="get" class="form-horizontal">'+
                        '<p>Are you sure you want to delete this  entry?</p>'+
                        '{{ csrf_field() }}'+
                    '</form>',
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-default'
                    },
                    submit: {
                        label: 'Delete Set',
                        className: 'btn-danger'
                    }
                }
            }
        });
    });
	</script>
@endsection