@extends('admindesk.layouts.master')
@section('title','Progressive Web App Setting | ')
@section('body')
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">
				Progressive Web App Setting
			</div>		
		</div>

		<div class="box-body">
			<div class="nav-tabs-custom">

				  <!-- Nav tabs -->
				  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				    
				    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">App Setting</a></li>
				    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Update Icons</a></li>
				    
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="home">

				    	<div class="callout callout-success">
				    		<i class="fa fa-info-circle"></i>
				    		 Progessive Web App Requirements
				    		 <ul>
				    		 	<li><b>HTTPS</b> must required in your domain (for enable contact your host provider for SSL configuration).</li>
				    		 	<li><b>Icons and splash screens </b> required and to be updated in Icon Settings.</li>
				    		 </ul>
				    	</div>

						<div class="row">
							<div class="col-md-8">
								<form action="{{ route('pwa.setting.update') }}" method="POST" enctype="multipart/form-data">
									@csrf
		
									<div class="form-group">
										<label>Enable PWA: </label>
										<br>
										<label class="switch">
											<input id="pwa_enable" type="checkbox" name="PWA_ENABLE"
											  {{ env("PWA_ENABLE") =='1' ? "checked" : "" }}>
											<span class="knob"></span>
										</label>
									</div>
									
									<div class="form-group">
										<label>App Name: </label>
										<input disabled class="form-control" type="text" name="app_name" value="{{ config("app.name")}}"/>
									</div>
		
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Theme Color for header: </label>
												<input name="PWA_THEME_COLOR" class="form-control" type="color" value="{{env('PWA_THEME_COLOR') ?? '' }}"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Background Color:</label>
												<input name="PWA_BG_COLOR" class="form-control" type="color" value="{{ env('PWA_BG_COLOR') ?? '' }}"/>
											</div>
										</div>
									</div>
		
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="">Shortcut icon for cart:</label>
												<input type="file" name="shorticon_1" class="form-control" />
											</div>
										</div>
		
										<div class="col-md-1 well">
											<img class="img-responsive" width="96px" height="96px" src="{{ url('images/icons/'.$pwa_settings['shorticon_1']) }}" alt="{{ $pwa_settings['shorticon_1'] }}">
										</div>
		
										<div class="col-md-5">
											<div class="form-group">
												<label for="">Shortcut icon for wishlist:</label>
												<input type="file" name="shorticon_2" class="form-control" />
											</div>
										</div>
		
										<div class="col-md-1 well">
											<img class="img-responsive" width="96px" height="96px" src="{{ url('images/icons/'.$pwa_settings['shorticon_2']) }}" alt="{{ $pwa_settings['shorticon_2'] }}">
										</div>
		
										<div class="col-md-5">
											<div class="form-group">
												<label for="">Shortcut icon for login:</label>
												<input type="file" name="shorticon_3" class="form-control" />
											</div>
										</div>
		
										<div class="col-md-1 well">
											<img class="img-responsive" width="96px" height="96px" src="{{ url('images/icons/'.$pwa_settings['shorticon_3']) }}" alt="{{ $pwa_settings['shorticon_3'] }}">
										</div>
		
									</div>
			
		
									<button type="submit" class="btn btn-md btn-flat btn-primary">
										<i class="fa fa-save"></i> Save Changes
									</button>
								</form>
							</div>

							<div class="col-md-4">
								
								<img height="100px" src="{{ url('images/pwa.jpg') }}" alt="" class="img-responsive">
								
							</div>
						</div>
				    	
				    </div>
				    <div role="tabpanel" class="tab-pane" id="profile">

						<h4>PWA Icons & Splash screens:</h4>

						<hr>

						<form action="{{ route('pwa.icons.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								
								<div class="col-md-3">
									<div class="form-group">
										<label for="">PWA Icon (512x512): <span class="text-danger">*</span> </label>
										<input type="file" name="icon_512" class="form-control" />
									</div>
								</div>

								<div class="col-md-2 well">
									<img class="img-responsive" src="{{ url('images/icons/icon_512x512.png') }}" alt="icon_256x256.png">
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="">PWA Splash Screen (2048x2732): <span class="text-danger">*</span> </label>
										<input type="file" name="splash_2048" class="form-control" />
									</div>
								</div>
	
								<div class="col-md-2 well">
									<img class="img-responsive" src="{{ url('images/icons/splash-2048x2732.png') }}" alt="splash-2048x2732.png">
								</div>

								<div class="col-md-12">
									<button type="submit" class="pull-left btn btn-md btn-flat btn-primary">
										<i class="fa fa-save"></i> Update
									</button>
								</div>
								
							</div>

							

						</form>
				    </div>
				  </div>

			</div>
		</div>
	</div>
@endsection
@section('custom-script')
  <script src="{{ url('js/pwasetting.js') }}"></script>
@endsection