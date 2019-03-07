@if (count($errors) > 0)
	<div class="sufee-alert alert alert-danger alert-dismissible fade show">
		@lang('auth.errors_title'):<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		</div>
@endif
