@extends("front/layout.master")

@section("body")
<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">{{ __('staticwords.Home') }}</a></li>
				<li class='active'>{{ __('Bank Details') }}</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs">
	<div class="container">
		<div class="row ">
			<div class="shopping-cart">
				<div class="shopping-cart-table ">
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th class="cart-product-name item">{{ __('staticwords.BankName') }}</th>
					<th class="cart-qty item">{{ __('Branch Name') }}</th>
					<th class="cart-sub-total item">{{ __('IFSC Code') }}</th>
					<th class="cart-sub-total item">{{ __('staticwords.AccountNumber') }} </th>
					<th class="cart-total last-item">{{ __('staticwords.AccountName') }}</th>
				</tr>
			</thead><!-- /thead -->
		
              
			<tbody>
       			@foreach($value as $row)
				<tr>
         
					<td class="cart-product-sub-total"><span class="cart-sub-total-price">{{$row->bankname}}</span>
					</td>
					<td class="cart-product-sub-total"><span class="cart-sub-total-price">{{$row->branchname}}</span>
					</td>
					<td class="cart-product-grand-total"><span class="cart-grand-total-price">{{$row->ifsc}}</span></td>
					<td class="cart-product-grand-total"><span class="cart-grand-total-price">{{$row->account}}</span></td>
					<td class="cart-product-grand-total"><span class="cart-grand-total-price">{{$row->acountname}}</span></td>
			        
				</tr>
				
			</tbody><!-- /tbody -->
        @endforeach
           
		</table><!-- /table -->
	</div>
	</div><!-- /.shopping-cart-table -->				
 </div>
</div>
</div>
</div>

@endsection
