@extends("admindesk/layouts.master")
@section('title','Add New Coupan |')
@section("body")
 <div class="col-md-8">
    <div class="box">
    
    <div class="box-header with-border">
      <div class="box-title">
          Create New Coupon
      </div>
    </div>
 <form action="{{ route('coupan.store') }}" method="POST">
    @csrf
    <div class="box-body">
         
        <div class="form-group">
          <label>Coupon code: <span class="required">*</span></label>
          <input required="" type="text" class="form-control" name="code">
        </div>
        <div class="form-group">
          <label>Discount type: <span class="required">*</span></label>
          
            <select required="" name="distype" id="distype" class="form-control">
              
              <option value="fix">Fix Amount</option>
              <option value="per">% Percentage</option>
              
            </select>
          
        </div>
        <div class="form-group">
            <label>Amount: <span class="required">*</span></label>
            <input required="" type="text"  class="form-control" name="amount">
          
        </div>
        <div class="form-group">
          <label>Linked to: <span class="required">*</span></label>
          
            <select required="" name="link_by" id="link_by" class="form-control">
              <option value="cart">Link to Cart</option>
              <option value="product">Link By Product</option>
              <option value="category">Link to Category</option>
            </select>
          
        </div>
        
        <div id="probox" class="display-none form-group">
          <label>Select Product: <span class="required">*</span> </label>
          <br>
          <select id="pro_id" name="pro_id" class="select2 form-control">
              @foreach(App\Product::where('status','1')->get() as $product)
               @if(count($product->subvariants)>0)
                <option value="{{ $product->id }}">{{ $product['name'] }}</option>
               @endif
              @endforeach
          </select>
        </div>

        <div id="catbox" class="display-none form-group">
          <label>Select Category: <span class="required">*</span> </label>
          <br>
          <select id="cat_id" name="cat_id" class="select2 form-control">
              @foreach(App\Category::where('status','1')->get() as $cat)
               @if(count($cat->products)>0)
                <option value="{{ $cat->id }}">{{ $cat['title'] }}</option>
               @endif
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Max Usage Limit: <span class="required">*</span></label>
          <input required="" type="number" min="1" class="form-control" name="maxusage">
        </div>

        <div id="minAmount" class="form-group">
          <label>Min Amount: </label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa {{ $defCurrency->currency_symbol }}"></i></span>
            <input type="number" min="0.0" value="0.00" step="0.1" class="form-control" name="minamount">
          </div>
        </div>
        
        
         <div class="form-group">
          <label>Expiry Date: </label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input required="" id="expirydate" type="text" class="form-control" name="expirydate">
          </div>
        </div>

       <div class="form-group">
          <label>Only For Registered Users:</label>
          <br>
          <label class="switch">
            <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="is_login">
            <span class="knob"></span>
          </label>
       </div>
        
     
    </div>

    <div class="box-footer">
      <button type="submit" class="btn btn-md bg-blue btn-flat">
        <i class="fa fa-plus-circle"></i> Create
      </button>
    </form>
      <a href="{{ route('coupan.index') }}" title="Cancel and go back" class="btn btn-md btn-default btn-flat">
        <i class="fa fa-reply"></i> Back
      </a>
    </div>
  </div>       
 </div>
@endsection
