<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ __('Warning !') }}</title>
	<link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
</head>
<body>
	<br>
	<div class="container">
		<h3 class="text-danger"><i class="fa fa-warning"></i> {{ __('Warning') }}</h3>
		<hr>
		<p class="text-info">{{ __('You tried to update the domain which is invalid !') }} 
		<h4>{{ __('You can use this project only in single domain for multiple domain please check License standard') }} <a target="_blank" href="https://codecanyon.net/licenses/standard">{{ __('here') }}</a>.</h4>
		<hr>
			<form class="needs-validation" action="{{ url('/change-domain') }}" method="POST" novalidate>
				@csrf

				<div class="form-group">
					<label>
						Enter the new domain where you want to move the license : <span class="text-danger">*</span>
					</label>
					<input required class="form-control @error('domain') is-invalid @enderror" type="text" name="domain" value="{{ old('domain') }}" placeholder="eg:example.com"/>

					@if ($errors->has('domain'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('domain') }}</strong>
						</span>
				 	@endif

					<small class="text-muted">
						<i class="fa fa-question-circle"></i> IF in some cases on current domain if you face the error you can re-update the domain by entering here.
					</small>

					<br>

					<small class="text-muted">
						<i class="fa fa-question-circle"></i> IF still facing the access denied error please con <a target="_blank" href="https://codecanyon.net/item/emart-laravel-multivendor-ecommerce-advanced-cms/25300293/support">{{ __('Support') }}</a> {{ __('for updation in domain.') }}.
					</small>

				</div>
				

				<div class="form-group">
					<button type="submit" class="btn btn-md btn-primary">
					 	<i class="fa fa-globe"></i>	Change domain
					</button>
				</div>
			</form>
		<hr>	
		<div class="text-muted text-center">&copy; {{ date('Y') }} | {{ __('All rights reserved') }} | {{ config('app.name') }}</div>
	</div>
	<!-- jQuery 3.5.4 -->
	<script src="{{url('js/jquery.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{url('js/bootstrap.bundle.min.js')}}"></script>
	<script>
		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function() {
		  'use strict';
		  window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');
			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
			  form.addEventListener('submit', function(event) {
				if (form.checkValidity() === false) {
				  event.preventDefault();
				  event.stopPropagation();
				}
				form.classList.add('was-validated');
			  }, false);
			});
		  }, false);
		})();
	</script>
</body>
</html>