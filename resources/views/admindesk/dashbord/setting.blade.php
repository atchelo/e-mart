@extends("admindesk/layouts.master")
@section('title','Dashboard Setting |')
@section("body")
  <div class="box">
  	<div class="box-header with-border">
  		<div class="box-title">
  			Admin Dashboard Setting
  		</div>
    </div>
		
		<div class="box-body">
			<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Main Screen Setting</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Facebook Widget Setting</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Twitter Widget Setting</a></li>
    <li role="presentation"><a href="#insta" aria-controls="settings" role="tab" data-toggle="tab">Instagram Widget Setting</a></li>
  </ul>
	
	@php
	 $dashsetting = App\DashboardSetting::first();
	@endphp
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="fade in tab-pane active" id="home">
    	<form action="{{ route('admindesk.dash.update',$dashsetting->id) }}" method="POST">
    		{{ csrf_field() }}
    	<div class="container">
    		<table class="table table-hover table-responsive">
    			<thead>
    				<tr>
    					<th>Widget Name</th>
    					<th>Action</th>
    					<th>Max Item</th>
    				</tr>
    			</thead>

    			<tbody>
    				<tr>
    					<td>
    						Latest Order
    					</td>
    					<td>
    						<input {{ $dashsetting->lat_ord==1 ? "checked" : "" }} id="order" type="checkbox" class="tgl tgl-skewed">
               <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="order"></label>
              <input type="hidden" name="lat_ord" value="{{ $dashsetting->lat_ord }}" id="order_status">
    					</td>
              
    					<td class="{{ $dashsetting->lat_ord==0 ? 'display-none' : ''}}"><input class="wid" min="1" name="max_item_ord" type="number" value="{{ $dashsetting->max_item_ord }}"></td>
             
    				</tr>

    				<tr>
    					<td>
    						Recently Added Product
    					</td>
    					<td>
    						<input {{ $dashsetting->rct_pro==1 ? "checked" : "" }} id="product" type="checkbox" class="tgl tgl-skewed">
               <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="product"></label>
              <input type="hidden" name="rct_pro" value="{{ $dashsetting->rct_pro }}" id="product_status">
    					</td>
              
    					<td class="{{ $dashsetting->rct_pro == 0 ? 'display-none' : '' }}"><input class="wid" min="1" name="max_item_pro" max="5" type="number" value="{{ $dashsetting->max_item_pro }}"></td>
             
    				</tr>

    				<tr>
    					<td>
    						Recent Store Request
    					</td>
    					<td>
    						<input {{ $dashsetting->rct_str==1 ? "checked" : "" }} id="store" type="checkbox" class="tgl tgl-skewed">
               <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="store"></label>
              <input type="hidden" name="rct_str" value="{{ $dashsetting->rct_str }}" id="store_status">
    					</td>
              
    					<td class="{{ $dashsetting->rct_str == 0 ? 'display-none' : ''}}"><input class="wid" min="1" name="max_item_str" type="number" value="{{ $dashsetting->max_item_str }}"></td>
             
    				</tr>

    				<tr>
    					<td>
    						Recent Customer
    					</td>
    					<td>
    						<input {{ $dashsetting->rct_cust==1 ? "checked" : "" }} id="cust" type="checkbox" class="tgl tgl-skewed">
               <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="cust"></label>
              <input type="hidden" name="rct_cust" value="{{ $dashsetting->rct_cust }}" id="cust_status">
    					</td>
             
    					<td><input class="wid {{ $dashsetting->rct_cust == 0 ? 'display-none' : ""}}" min="1" name="max_item_cust" max="12" type="number" value="{{ $dashsetting->max_item_cust }}"></td>
             
    				</tr>

    				
    			</tbody>
    		</table>
    		 <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Setting</button>
    		</form>
    		
		
	
		
		
		

    	</div>
		
    </div>

    <div role="tabpanel" class="fade tab-pane" id="messages">
      <br>
      <form class="col-md-6" action="{{ route('fb.update',$dashsetting->id) }}" method="POST">
        {{ csrf_field() }}
        <label for="">Facebook Page ID:</label>
        <input type="text" placeholder="Enter Facebook Page ID" name="fb_page_id" class="form-control" value="{{ $dashsetting->fb_page_id }}" />
        <br>
        <div class="eyeCy">
          <label>Facebook Page Access Token:</label>
          <input placeholder="Enter Page Access Token" type="password" id="token" class="form-control" name="fb_page_token" value="{{ $dashsetting->fb_page_token }}" />
        <span toggle="#token" class="fa fa-fw fa-eye field-icon toggle-password"></span>
        
        </div>
        <br>
        <label for="">Status:</label>
        <input {{ $dashsetting->fb_wid==1 ? "checked" :"" }} id="fb" type="checkbox" class="tgl tgl-skewed">
               <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="fb"></label>
              <input {{ $dashsetting->fb_wid }} type="hidden" name="fb_wid" value="0" id="fb_status">
              <br>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Setting</button>
      </form>
    </div>
    <div role="tabpanel" class="fade tab-pane" id="settings">
      <br>
      <form class="col-md-6" action="{{ route('tw.update',$dashsetting->id) }}" method="POST">
        {{ csrf_field() }}
        <label for="">Twitter Username:</label>
        <input type="text" placeholder="Enter Twitter Username" name="tw_username" class="form-control" value="{{ $dashsetting->tw_username }}" />
        <br>
        <input {{ $dashsetting->tw_wid==1 ? "checked" :"" }} id="tw" type="checkbox" class="tgl tgl-skewed">
               <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="tw"></label>
              <input {{ $dashsetting->fb_wid }} type="hidden" name="tw_wid" value="{{ $dashsetting->tw_wid }}" id="tw_status">
        <br>
         <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Setting</button>
      </form>
    </div>
    <div role="tabpanel" class="fade tab-pane" id="insta">
      <br>
      <form class="col-md-6" action="{{ route('ins.update',$dashsetting->id) }}" method="POST">
        {{ csrf_field() }}
        <label for="">Instagram Username:</label>
        <input type="text" placeholder="Enter Instagram Username" name="inst_username" class="form-control" value="{{ $dashsetting->inst_username }}" />
        <br>
        <input {{ $dashsetting->insta_wid==1 ? "checked" :"" }} id="ins" type="checkbox" class="tgl tgl-skewed">
               <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="ins"></label>
              <input {{ $dashsetting->insta_wid }} type="hidden" name="insta_wid" value="{{$dashsetting->insta_wid}}" id="insta_status">
        <br>

         <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Setting</button>
      </form>
    </div>
  </div>

</div>
		</div>
  		
  	</div>
  </div>
@endsection

