@extends("admindesk/layouts.master")
@section('title',"Social Login Settings |")
@section("body")
<div class="box">
	<div class="box-header with-border">
		<div class="box-title">
			{{ __('Social Login Settings') }}
		</div>
	</div>

	<div class="box-body">
		<div class="nav-tabs-custom">

			<div class="row">
				<div class="col-md-4">
					<ul id="payment_tabs" class="nav nav-stacked">
						<li class="active">
							<a href="#tab_1" data-toggle="tab" aria-expanded="false">
								<div class="row">
									<div class="col-md-10">
										<i class="fa fa-facebook" aria-hidden="true"></i>
										{{ __('Facebook Login Settings') }}
									</div>
									<div class="col-md-2">
										<i title="{{ $configs->fb_login_enable==1 ? "Active" : "Deactive" }}"
											class="fa fa-circle {{ $configs->fb_login_enable==1 ? "text-green" : "text-red" }}"
											aria-hidden="true"></i>
									</div>
								</div>

							</a>
						</li>
						<li>
							<a href="#tab_2" data-toggle="tab" aria-expanded="true">
								<div class="row">
									<div class="col-md-10">
										<i class="fa fa-google" aria-hidden="true"></i>
										{{ __('Google Login Settings') }}
									</div>
									<div class="col-md-2">
										<i title="{{ $configs->google_login_enable == 1 ? "Active" : "Deactive" }}"
											class="fa fa-circle {{ $configs->google_login_enable == 1 ? "text-green" : "text-red" }}"
											aria-hidden="true"></i>
									</div>
								</div>
							</a>
						</li>
						<li><a href="#tab_3" data-toggle="tab">
								<div class="row">
									<div class="col-md-10">
										<i class="fa fa-twitter" aria-hidden="true"></i>
										{{ __('Twitter Login Settings') }}
									</div>

									<div class="col-md-2">
										<i title="{{ $configs->twitter_enable==1 ? "Active" : "Deactive" }}"
											class="fa fa-circle {{ $configs->twitter_enable==1 ? "text-green" : "text-red" }}"
											aria-hidden="true"></i>
									</div>
								</div>
							</a></li>
						<li><a href="#tab_4" data-toggle="tab">
								<div class="row">
									<div class="col-md-10">
										<i class="fa fa-amazon" aria-hidden="true"></i>
										{{ __('Amazon Login Settings') }}
									</div>

									<div class="col-md-2">



										<i title="{{ $configs->amazon_enable == 1 ? "Active" : "Deactive" }}"
											class="fa fa-circle {{ $configs->amazon_enable==1 ? "text-green" : "text-red" }}"
											aria-hidden="true"></i>
									</div>
								</div>
							</a></li>
						<li><a href="#tab_5" data-toggle="tab">
								<div class="row">
									<div class="col-md-10">
										<i class="fa fa-gitlab" aria-hidden="true"></i>
										{{ __('Gitlab Login Settings') }}
									</div>

									<div class="col-md-2">
										<i title="{{ env('ENABLE_GITLAB') == 1 ? "Active" : "Deactive" }}"
											class="fa fa-circle {{ env('ENABLE_GITLAB') == 1 ? "text-green" : "text-red" }}"
											aria-hidden="true"></i>
									</div>
								</div>
							</a>
						</li>

						<li><a href="#tab_6" data-toggle="tab">
							<div class="row">
								<div class="col-md-10">
									<i class="fa fa-linkedin-square"></i>
									{{ __('Linkedin Login Settings') }}
								</div>

								<div class="col-md-2">
									<i title="{{ $configs->linkedin_enable == 1 ? "Active" : "Deactive" }}"
										class="fa fa-circle {{ $configs->linkedin_enable == 1 ? "text-green" : "text-red" }}"
										aria-hidden="true"></i>
								</div>
							</div>
						</a>
					</li>


					</ul>
				</div>

				<div class="col-md-8">
					<div class="tab-content">
						<div class="tab-pane fade in active" id="tab_1">
							<h4>Facebook Login Settings</h4>
							<hr>
							<form action="{{ route('social.login.service.update','facebook') }}" method="POST">
								{{ csrf_field() }}

								<label for="">Client ID:</label>
								<input type="text" placeholder="enter client ID" class="form-control"
									name="FACEBOOK_CLIENT_ID" value="{{ env('FACEBOOK_CLIENT_ID') }}">
								<br>

								<div class="form-group eyeCy">

									<label for="">Client Secret Key:</label>
									<input type="password" placeholder="enter secret key" class="form-control"
										id="fb_secret" name="FACEBOOK_CLIENT_SECRET"
										value="{{ env('FACEBOOK_CLIENT_SECRET') }}">

									<span toggle="#fb_secret"
										class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

								</div>
								<label for="">Callback URL:</label>
								<div class="input-group">
									<input value="{{ route('social.login.callback','facebook') }}" type="text"
										placeholder="https://yoursite.com/public/login/facebook/callback"
										name="FB_CALLBACK_URL" value="{{ env('FB_CALLBACK_URL') }}"
										class="callback-url form-control">
									<span class="input-group-addon" id="basic-addon2">
										<button title="Copy" type="button" class="copy btn btn-xs btn-default">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</span>
								</div>
								<small class="text-muted">
									<i class="fa fa-question-circle"></i> Copy the callback url and paste in your app
								</small>
								<br><br>
								<div class="form-group">
									<label for=""><i class="fa fa-facebook"></i> Enable Facebook Login: </label>
									<br>
									<label class="switch">
										<input id="fb_login_enable" type="checkbox" name="fb_login_enable"
											{{ $setting->fb_login_enable=='1' ? "checked" : "" }}>
										<span class="knob"></span>
									</label>
								</div>
								<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
									title="This action is disabled in demo !" @endif class="btn btn-md btn-primary"><i
										class="fa fa-save"></i> Save Setting
								</button>
								<br><br>
							</form>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane fade" id="tab_2">
							<h4>Google Login Settings</h4>
							<hr>
							<form action="{{ route('social.login.service.update','google') }}" method="POST">
								{{ csrf_field() }}

								<label for="">Client ID:</label>
								<input name="GOOGLE_CLIENT_ID" type="text" placeholder="enter client ID"
									class="form-control" value="{{ env('GOOGLE_CLIENT_ID') }}">
								<br>

								<div class="eyeCy">

									<label for="">Client Secret Key:</label>
									<input type="password" name="GOOGLE_CLIENT_SECRET"
										value="{{ env('GOOGLE_CLIENT_SECRET') }}" placeholder="enter secret key"
										class="form-control" id="gsecret">

									<span toggle="#gsecret"
										class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

								</div>

								<br>
								<label for="">Callback URL:</label>
								<div class="input-group">
									<input type="text" placeholder="https://yoursite.com/login/public/google/callback"
										name="GOOGLE_CALLBACK_URL" value="{{ route('social.login.callback','google') }}"
										class="callback-url form-control">
									<span class="input-group-addon" id="basic-addon2">
										<button title="Copy" type="button" class="copy btn btn-xs btn-default">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</span>
								</div>
								<small class="text-muted">
									<i class="fa fa-question-circle"></i> Copy the callback url and paste in your app
								</small>
								<br><br>
								<div class="form-group">
									<label for=""><i class="fa fa-google"></i> Enable Google Login: </label>
									<br>
									<label class="switch">
										<input id="google_login_enable" type="checkbox" name="google_login_enable"
											{{ $setting->google_login_enable=='1' ? "checked" : "" }}>
										<span class="knob"></span>
									</label>
								</div>
								<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
									title="This action is disabled in demo !" @endif class="btn btn-md btn-primary"><i
										class="fa fa-save"></i> Save Setting</button>
								<br><br>
							</form>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane fade" id="tab_3">
							<h4>Twitter Login Settings</h4>
							<hr>
							<form action="{{ route('social.login.service.update','twitter') }}" method="POST">
								{{ csrf_field() }}

								<label for="">Client ID:</label>
								<input type="text" placeholder="enter client ID" class="form-control"
									name="TWITTER_API_KEY" value="{{ env('TWITTER_API_KEY') }}">
								<br>

								<div class="form-group eyeCy">

									<label for="">Client Secret Key:</label>
									<input type="password" placeholder="enter secret key" class="form-control"
										id="tw_secret" name="TWITTER_SECRET_KEY"
										value="{{ env('TWITTER_SECRET_KEY') }}">

									<span toggle="#tw_secret"
										class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

								</div>
								<label for="">Callback URL:</label>
								<div class="input-group">
									<input value="{{ route('social.login.callback','twitter') }}" type="text"
										placeholder="https://yoursite.com/public/login/twitter/callback"
										name="FB_CALLBACK_URL" value="{{ env('FB_CALLBACK_URL') }}"
										class="callback-url form-control">
									<span class="input-group-addon" id="basic-addon2">
										<button title="Copy" type="button" class="copy btn btn-xs btn-default">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</span>
								</div>
								<small class="text-muted">
									<i class="fa fa-question-circle"></i> Copy the callback url and paste in your app
								</small>
								<br><br>
								<div class="form-group">
									<label for=""><i class="fa fa-twitter"></i> Enable Twitter Login: </label>
									<br>
									<label class="switch">
										<input id="twitter_enable" type="checkbox" name="twitter_enable"
											{{ $setting->twitter_enable=='1' ? "checked" : "" }}>
										<span class="knob"></span>
									</label>
								</div>
								<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
									title="This action is disabled in demo !" @endif class="btn btn-md btn-primary"><i
										class="fa fa-save"></i> Save Setting
								</button>
								<br><br>
							</form>
						</div>
						<!-- /.tab-pane -->
						<!-- /.tab-pane -->
						<div class="tab-pane fade" id="tab_4">
							<h4>Amazon Login Settings</h4>
							<hr>
							<form action="{{ route('social.login.service.update','amazon') }}" method="POST">
								{{ csrf_field() }}

								<label for="">Client ID:</label>
								<input type="text" placeholder="enter client ID" class="form-control"
									name="AMAZON_LOGIN_ID" value="{{ env('AMAZON_LOGIN_ID') }}">
								<br>

								<div class="form-group eyeCy">

									<label for="">Client Secret Key:</label>
									<input type="password" placeholder="enter secret key" class="form-control"
										id="amz_secret" name="AMAZON_LOGIN_SECRET"
										value="{{ env('AMAZON_LOGIN_SECRET') }}">

									<span toggle="#amz_secret"
										class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

								</div>
								<label for="">Callback URL:</label>
								<div class="input-group">
									<input value="{{ route('social.login.callback','amazon') }}" type="text"
										placeholder="https://yoursite.com/public/login/amazon/callback"
										name="AMAZON_LOGIN_CALLBACK" value="{{ env('AMAZON_LOGIN_CALLBACK') }}"
										class="callback-url form-control">
									<span class="input-group-addon" id="basic-addon2">
										<button title="Copy" type="button" class="copy btn btn-xs btn-default">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</span>
								</div>
								<small class="text-muted">
									<i class="fa fa-question-circle"></i> Copy the callback url and paste in your app
								</small>
								<br><br>
								<div class="form-group">
									<label for=""><i class="fa fa-amazon"></i> Enable Amazon Login: </label>
									<br>
									<label class="switch">
										<input id="amazon_enable" type="checkbox" name="amazon_enable"
											{{ $setting->amazon_enable == '1' ? "checked" : "" }}>
										<span class="knob"></span>
									</label>
								</div>
								<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
									title="This action is disabled in demo !" @endif class="btn btn-md btn-primary"><i
										class="fa fa-save"></i> Save Setting
								</button>
								<br><br>
							</form>
						</div>
						<!-- /.tab-pane -->
						<!-- /.tab-pane -->
						<div class="tab-pane fade" id="tab_5">
							<h4>Gitlab Login Settings</h4>
							<hr>
							<form action="{{ route('social.login.service.update','gitlab') }}" method="POST">
								{{ csrf_field() }}

								<label for="">Gitlab Client ID:</label>
								<input type="text" placeholder="enter gitlab client ID" class="form-control"
									name="GITLAB_CLIENT_ID" value="{{ env('GITLAB_CLIENT_ID') }}">
								<br>

								<div class="eyeCy">

									<label for="">Gitlab Client Secret Key:</label>
									<input type="password" placeholder="enter gitlab client secret key"
										class="form-control" id="gitlab_secret" name="GITLAB_CLIENT_SECRET"
										value="{{ env('GITLAB_CLIENT_SECRET') }}">

									<span toggle="#gitlab_secret"
										class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

								</div>

								<br>
								<label for="">Gitlab Callback URL:</label>
								<div class="input-group">
									<input type="text" placeholder="https://yoursite.com/public/login/gitlab/callback"
										name="GITLAB_CALLBACK_URL" value="{{ route('social.login.callback','gitlab') }}"
										class="callback-url form-control">
									<span class="input-group-addon" id="basic-addon2">
										<button title="Copy" type="button" class="copy btn btn-xs btn-default">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</span>

								</div>
								<small class="text-muted">
									<i class="fa fa-question-circle"></i> Copy the callback url and paste in your app
								</small>
								<br><br>
								<div class="form-group">
									<label for=""><i class="fa fa-gitlab"></i> Enable GitLab Login: </label>
									<br>
									<label class="switch">
										<input id="ENABLE_GITLAB" type="checkbox" name="ENABLE_GITLAB"
											{{ env('ENABLE_GITLAB') == '1' ? "checked" : "" }}>
										<span class="knob"></span>
									</label>
								</div>

								<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
									title="This action is disabled in demo !" @endif class="btn btn-md btn-primary"><i
										class="fa fa-save"></i> Save Setting</button>

								<br><br>

							</form>
						</div>

						<div class="tab-pane fade" id="tab_6">
							<h4>Linkedin Login Settings</h4>
							<hr>
							<form action="{{ route('social.login.service.update','linkedin') }}" method="POST">
								{{ csrf_field() }}

								<label for="">LINKEDIN Client ID:</label>
								<input type="text" placeholder="enter gitlab client ID" class="form-control"
									name="LINKEDIN_CLIENT_ID" value="{{ env('LINKEDIN_CLIENT_ID') }}">
								<br>

								<div class="eyeCy">

									<label for="">LINKEDIN  Client Secret Key:</label>
									<input type="password" placeholder="enter LINKEDIN  client secret key"
										class="form-control" id="LINKEDIN_SECRET" name="LINKEDIN_SECRET"
										value="{{ env('LINKEDIN_SECRET') }}">

									<span toggle="#LINKEDIN_SECRET"
										class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

								</div>

								<br>
								<label for="">LINKEDIN Callback URL:</label>
								<div class="input-group">
									<input type="text" placeholder="https://yoursite.com/public/login/linkedin/callback"
										name="LINKEDIN_CALLBACK" value="{{ route('social.login.callback','linkedin') }}"
										class="callback-url form-control">
									<span class="input-group-addon" id="basic-addon2">
										<button title="Copy" type="button" class="copy btn btn-xs btn-default">
											<i class="fa fa-clipboard" aria-hidden="true"></i>
										</button>
									</span>

								</div>
								<small class="text-muted">
									<i class="fa fa-question-circle"></i> Copy the callback url and paste in your app
								</small>
								<br><br>
								<div class="form-group">
									<label for=""><i class="fa fa-linkedin-square"></i> Enable Linkedin Login: </label>
									<br>
									<label class="switch">
										<input id="linkedin_enable" type="checkbox" name="linkedin_enable"
											{{ $configs->linkedin_enable == '1' ? "checked" : "" }}>
										<span class="knob"></span>
									</label>
								</div>

								<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
									title="This action is disabled in demo !" @endif class="btn btn-md btn-primary"><i
										class="fa fa-save"></i> Save Setting</button>

								<br><br>

							</form>
						</div>
					</div>
					<!-- /.tab-pane -->
				</div>
			</div>
		</div>


		<!-- /.tab-content -->
	</div>
</div>
</div>
@endsection
@section('custom-script')
<script>
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if (activeTab) {
		$('#payment_tabs a[href="' + activeTab + '"]').tab('show');
	}

	$('.copy').on('click', function () {

		var copyText = $(this).closest('.input-group').find('.callback-url');
		copyText.select();
		//copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		/* Copy the text inside the text field */
		document.execCommand("copy");
	});
</script>
@endsection