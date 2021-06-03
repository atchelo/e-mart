@extends("admindesk/layouts.master")
@section('title','Add New Coupan |')
@section("body")
 <div class="col-md-8">
    <div class="box">
    
    <div class="box-header with-border">
      <div class="box-title">
          Edit Coupon : {{ $coupan->code }}
      </div>
    </div>
 <form action="{{ route('coupan.update',$coupan->id) }}" method="POST">
    @csrf
    {{ method_field("PUT") }}
    <div class="box-body">
         
        <div class="form-group">
          <label>Coupon code: <span class="required">*</span></label>
          <input value="{{ $coupan->code }}" type="text" class="form-control" name="code">
        </div>
        <div class="form-group">
          <label>Discount type: <span class="required">*</span></label>
          
            <select required="" name="distype" id="distype" class="form-control">
              
              <option {{ $coupan->distype == 'fix' ? "selected" : ""}} value="fix">Fix Amount</option>
              <option {{ $coupan->distype == 'per' ? "selected" : ""}} value="per">% Percentage</option>
              
            </select>
          
        </div>
        <div class="form-group">
            <label>Amount: <span class="required">*</span></label>
            <input type="text" value="{{ $coupan->amount }}"  class="form-control" name="amount">
          
        </div>
        <div class="form-group">
          <label>Linked to: <span class="required">*</span></label>
          
            <select required="" name="link_by" id="link_by" class="form-control">
              <option {{ $coupan->link_by == 'product' ? "selected" : ""}} value="product">Link By Product</option>
              <option {{ $coupan->link_by == 'cart' ? "selected" : ""}} value="cart">Link to Cart</option>
              <option {{ $coupan->link_by == 'category' ? "selected" : ""}} value="category">Link to Category</option>
            </select>
          
        </div>

        <div id="probox" class="form-group {{ $coupan->link_by == 'product' ? "" : 'display-none' }}">
          <label>Select Product: <span class="required">*</span> </label>
          <br>
          <select id="pro_id" name="pro_id" class="select2 form-control">
              @foreach(App\Product::where('status','1')->get() as $product)
               @if(count($product->subvariants)>0)
                <option {{ $coupan['pro_id'] == $product['id'] ? "selected" : "" }} value="{{ $product->id }}">{{ $product['name'] }}</option>
               @endif
              @endforeach
          </select>
        </div>

        <div id="catbox" class="form-group {{ $coupan->link_by == 'category' ? "" : 'display-none'}}">
          <label>Select Category: <span class="required">*</span> </label>
          <br>
          <select id="cat_id" name="cat_id" class="select2 form-control">
              @foreach(App\Category::where('status','1')->get() as $cat)
               @if(count($cat->products)>0)
                <option {{ $coupan->cat_id == $cat->id ? "selected" : "" }} value="{{ $cat->id }}">{{ $cat['title'] }}</option>
               @endif
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Max Usage Limit: <span class="required">*</span></label>
          <input value="{{ $coupan->maxusage }}" type="number" min="1" class="form-control" name="maxusage">
        </div>

        <div id="minAmount" class="form-group {{ $coupan->link_by=='product' ? 'display-none' : "" }}">
          <label>Min Amount: </label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa {{ $defCurrency->currency_symbol }}"></i></span>
            <input value="{{ $coupan->minamount }}" type="number" min="0.0" value="0.00" step="0.1" class="form-control" name="minamount">
          </div>
        </div>
        
        <div class="form-group">
          <label>Expiry Date: </label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input value="{{ date('Y-m-d',strtotime($coupan->expirydate)) }}" id="expirydate" type="text" class="form-control" name="expirydate">
          </div>
        </div>

        <div class="form-group">
            <label>Only For Registered Users:</label>
            <br>
            <label class="switch">
              <input {{ $coupan->is_login == 1 ? "checked" : "" }} type="checkbox" class="quizfp toggle-input toggle-buttons" name="is_login">
              <span class="knob"></span>
            </label>
        </div>
        
     
    </div>

    <div class="box-footer">
      <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif class="btn btn-md bg-blue btn-flat">
        <i class="fa fa-save"></i> Update
      </button>
    </form>
      <a href="{{ route('coupan.index') }}" title="Cancel and go back" class="btn btn-md btn-default btn-flat">
        <i class="fa fa-reply"></i> Back
      </a>
    </div>
  </div>       
 </div>
@endsection
