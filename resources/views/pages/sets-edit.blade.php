@extends('layouts.default')
@section('content')
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Edit set</h5>
					</div>
					<div class="ibox-content">
						<form class="form-horizontal" method="post" action="/sets/edit/{{$set->id}}">
							{{csrf_field()}}

							<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
								<label class="col-lg-2 control-label"> Name</label>
								<div class="col-lg-10"><input type="text" placeholder="Set Name" name="name" class="form-control" value="{{ old('name',$set->name) }}">
									@if ($errors->has('name'))
										<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
									@endif
								</div>
							</div>
							
							<div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
								<label class="col-lg-2 control-label">Active</label>

								<div class="col-lg-8">
									<label class="radio-inline"><input type="checkbox" name="active" value="1" {{ old('active' ,$set->active ) == '1' ? 'checked' : '' }} ></label>
								</div>
						   </div>

							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button class="btn btn-sm btn-white" type="submit">Update</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
