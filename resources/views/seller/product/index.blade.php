@extends("admindesk.layouts.sellermaster")
@section('title','All Products |')
@section("body")
   <div class="box">
     
      @if(env('ENABLE_SELLER_SUBS_SYSTEM') == 1 && getPlanStatus() == 1)
       
         @if(auth()->user()->products()->count() == auth()->user()->activeSubscription->plan->product_create/2)
         <br>
         <div class="callout callout-danger">
          {{ __('You reached 50% of your product upload limit you can upload '.(auth()->user()->activeSubscription->plan->product_create/2).' products more upgrade your plan to get more limit.') }}
         </div>
         @elseif(auth()->user()->products()->count() == auth()->user()->activeSubscription->plan->product_create)
         <br>
         <div class="callout callout-danger">
          {{ __('You reached 100% of your product upload limit.')}}
         </div>
         @endif
        
      @endif

      <div class="box-header">
        <h3 class="box-title">All Products</h3>
        <br><br>

        <form id="bulk_delete_form" method="POST" action="{{ route('seller.pro.bulk.delete') }}" class="pull-left form-inline">
          @csrf
          
          <div class="form-group">
            <select required name="action" id="action" class="form-control">
              <option value="">Please select action</option>
              <option value="deleted">Delete selected</option>
              <option value="deactivated">Deactive selected</option>
              <option value="activated">Active selected</option>
            </select>
          </div>
          
          <button type="submit" class="btn bg-gray">Apply</button>

          
        </form>

       
        @if(env('ENABLE_SELLER_SUBS_SYSTEM') == 1)
         
         @if(getPlanStatus() == 1 && auth()->user()->products()->count() < auth()->user()->activeSubscription->plan->product_create)
          
          <div class="form-inline pull-right">
            @if(auth()->user()->activeSubscription->plan->csv_product == 1)
            <a title="Import products" href="{{ route('seller.import.product') }}" class="btn btn-md bg-olive">Import Products</a>
            @endif
            <a href="{{ url('seller/products/create') }}" class="btn btn-md btn-success">+ Add Product</a>
          </div>

          @endif

        @else 
          
        <div class="form-inline pull-right">
          <a title="Import products" href="{{ route('seller.import.product') }}" class="btn btn-md bg-olive">Import Products</a>
          <a href="{{ url('seller/products/create') }}" class="btn btn-md btn-success">+ Add Product</a>
        </div>

        @endif
          
      </div>

      <div class="box-body">
          <div class="table-responsive">
            <table id="productTable" class="width100 table table-bordered table-hover">
              <thead>
                <th>
                  <div class="inline">
                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all"/>
                    <label for="checkboxAll" class="material-checkbox"></label>
                  </div>
                
                </th>
                <th>
                  S.NO
                </th>
                <th>
                  Image
                </th>

                <th>
                  Product Detail
                </th>

                <th>
                  Price ({{ $defCurrency->currency->code }})
                </th>

                <th>
                  Categories & More
                </th>

                <th>
                  Status
                </th>
                <th>
                  Add / Update on
                </th>

                <th>
                  Actions
                </th>
              </thead>
          </table>
          </div>
      </div>

    </div>
@endsection
@section('custom-script')
<script>
  $(function () {

      "use strict";

      var table = $('#productTable').DataTable({
          processing: true,
          serverSide: true,
          searching: true,
          stateSave: true,
          ajax: "{{ route('my.products.index') }}",
          columns: [
              
              {data : 'checkbox', name : 'checkbox', searchable : false,orderable : false},
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
              {data : 'image', name : 'image',searchable : false, orderable : false},
              {data : 'name', name : 'products.name'},
              {data : 'price', name : 'price'},
              {data : 'catdtl', name : 'category.title'},
              {data : 'status', name : 'products.status',searchable : false},
              {data : 'created_at', name : 'products.created_at'},
              {data : 'action', name : 'action', searchable : false,orderable : false}
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [
            [7,'DESC']
          ]
      });
      
  });

  

   $('#productTable').on('click', '.ptl', function (e) { 
        var id = $(this).data('proid');
        
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type : 'POST',
          data : { productid : $(this).data('proid') },
          datatype : 'html',
          url  : '{{ route('add.price.product') }}',
          success : function(response){
              $('#priceDetail'+id).modal('show');
              $('#pricecontent'+id).html('');
              $('#pricecontent'+id).html(response.body);
          }
      });

    });
    
</script>
@endsection
