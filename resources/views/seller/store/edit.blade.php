@extends("admindesk.layouts.sellermaster")
@section('title',"Edit Store - $store->name |")
@section("body")
<div class="box box-widget widget-user-2">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-blue">
    <div class="widget-user-image">
      @php
      $image = @file_get_contents('../public/images/store/'.$store->store_logo);
      @endphp
      <img title="{{ $store->name }}"
        src="{{ $image ? url('images/store/'.$store->store_logo) : Avatar::create($store->name)->toBase64() }}"
        alt="Store logo">
    </div>
    <!-- /.widget-user-image -->
    <h3 class="widget-user-username">{{ $store->name }}</h3>
    <h5 class="widget-user-desc"><i class="fa fa-map-marker"></i> {{ $store->city['name'] }},
      {{ $store->state['name'] }}, {{ $store->country['nicename'] }}</h5>
  </div>
  <div class="box-footer no-padding">
    <ul class="nav nav-stacked">
      <li><a href="#">Created On <span
            class="pull-right badge bg-blue">{{ date('d-M-Y',strtotime($store->created_at)) }}</span></a></li>
      <li><a href="#">Owner <span class="pull-right badge bg-purple"> {{ $store->user->name }}</span></a></li>
      @php
        $allorders = App\Order::all();

        $sellerorder = collect();

        foreach ($allorders as $key => $order) {

          if(in_array(Auth::user()->id, $order->vender_ids)){
            $sellerorder->push($order);
          }

        }
      @endphp
      <li><a href="{{ url('seller/orders') }}">Total Orders <span
            class="pull-right badge bg-green">{{ count($sellerorder) }}</span></a></li>
      <li><a href="{{ url('seller/my/products') }}">Total Products <span
            class="pull-right badge bg-aqua">{{ $store->products->count() }}</span></a></li>
      <li><a href="#">Verified <span
            class="pull-right badge {{ $store->verified_store == '1' ? "bg-green" : "bg-primary" }}">{{ $store->verified_store == '1' ? "Yes" : "No" }}</span></a>
      </li>
    </ul>
  </div>
</div>

<div class="box box-primary">
  <div class="box-header with-border">
    <div class="box-title">
      Edit Store Details
    </div>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="row">
      <form action="{{ route('store.update',$store->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("PUT")

        <div class="col-md-6">
          <div class="form-group">
            <label>Store ID: <small class="text-muted">
                <i class="fa fa-question-circle"></i>
                {{ __('If you did not see store id hit update button to get it.') }}
              </small></label>
            <input disabled type="text" name="name" class="form-control" value="{{$store->uuid ?? 'NOT SET'}}">
           
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Store Name: <span class="required">*</span></label>
            <input type="text" name="name" class="form-control" value="{{$store->name ?? ''}}">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Store Email: <span class="required">*</span></label>
            <input type="text" name="email" class="form-control" value="{{$store->email ?? ''}}">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="">Phone:</label>
            <input type="text" placeholder="Enter phone no." name="phone" class="form-control"
              value="{{$store->phone ?? ''}}">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="">Mobile:</label>
            <input type="text" placeholder="Enter mobile no." name="mobile" class="form-control"
              value="{{$store->mobile ?? ''}}">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="">VAT/GSTIN No:</label>
            <input type="text" placeholder="Enter VAT or GSTIN no. of your store" name="vat_no" class="form-control"
              value="{{$store->vat_no ?? ''}}">
          </div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3">
              <label for="">Store Address: <span class="required">*</span></label>
              <textarea class="form-control" name="address" placeholder="Enter store address" cols="10"
                rows="5">{{ $store->address }}</textarea>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="">Country: <span class="required">*</span></label>
                <select data-placeholder="Please select country" name="country_id" id="country_id" class="form-control select2">
                  <option value="0">Please Choose</option>
                  @foreach($countries as $c)
                  
                  <option value="{{$c->id}}"
                    {{ $c->id == $store->country_id ? 'selected="selected"' : '' }}>
                    {{$c->nicename}}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="">State: <span class="required">*</span></label>
                <select data-placeholder="Please select state" required name="state_id" id="upload_id" class="form-control select2">
                  <option value="0">Please choose</option>
                  @foreach($states as $c)
                  <option value="{{$c->id}}" {{ $c->id == $store->state_id ? 'selected="selected"' : '' }}>
                    {{$c->name}}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="">City: </label>
                <select data-placeholder="Please select city" name="city_id" id="city_id" class="form-control select2">
                  <option value="">Please Choose</option>
                  @foreach($city as $c)
                  <option value="{{$c->id}}" {{ $c->id == $store->city_id ? 'selected="selected"' : '' }}>
                    {{$c->name}}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            @if($pincodesystem == 1)
            <div class="col-md-3">
              <label for="">Pincode: <span class="required">*</span></label>
              <input type="text" value="{{ $store->pin_code }}" name="pin_code" placeholder="Enter pincode"
                class="form-control">
            </div>
            @endif

            <div class="col-md-3">
              <label for="">Your Store Status :</label>
              <div class="callout {{ $store->status == 1 ? "callout-success" : "callout-danger"}}">
                @if($store->status == 1)
                <i class="fa fa-check-square"></i> Active
                @else
                <i class="fa fa-ban"></i> Deactive
                @endif
              </div>
            </div>

            <div class="col-md-3">
              <label for="">Verified Store :</label>
              <div class="callout {{ $store->verified_store == 1 ? "callout-success" : "callout-info"}}">
                @if($store->verified_store == 1)
                <i class="fa fa-check-square"></i> Verfied
                @else
                <i class="fa fa-info-circle"></i> Not verified
                @endif
              </div>
            </div>


          </div>
        </div>


        <div class="col-md-6">
          <div class="form-group">
            <label for="">Choose Store Logo:</label>
            <input type="file" class="form-control" name="store_logo">
          </div>
        </div>





    </div>
    <div class="box-footer">
      <button @if(env('DEMO_LOCK')==0) type="submit" @else title="This action is disabled in demo !" disabled="disabled"
        @endif class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save Details </button>
      </form>
      <button data-toggle="modal" data-target="#deletestore" type="button" class="btn btn-md btn-danger">
          <i class="fa fa-trash-o"></i> Request for delete !
      </button>
      <div id="deletestore" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>
                Do you really want to delete your store? This process cannot be undone. By clicking <b>YES</b> your all products,payouts, orders records will be deleted !</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{ route('req.for.delete.store',$store->id) }}" class="pull-right">
                {{csrf_field()}}
                {{method_field("DELETE")}}
      
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('custom-script')
<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url('js/ajaxlocationlist.js') }}"></script>
@endsection