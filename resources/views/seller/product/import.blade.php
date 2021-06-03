@extends("admindesk.layouts.sellermaster")
@section('title','Import Product |')
@section("body")
	<div class="box box-primary">
		<div class="box-header with-header">
			<div class="box-title">Import Products</div>
		</div>

		<div class="box-body">
			 <a href="{{ url('files/ProductCSV.xlsx') }}" class="btn btn-md btn-success"> Download Example For xls/csv File</a>
			 <hr>
			<form action="{{ route('seller.import.store') }}" method="POST" enctype="multipart/form-data">
          		{{ csrf_field() }}
            
            <div class="row">
            	<div class="form-group col-md-6">
            	 <label for="file">Choose your xls/csv File :</label>
             	 <input required="" type="file" name="file" class="form-control">
             	 @if ($errors->has('file'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                 @endif

                 <p></p>

                 <button type="submit" class="btn bg-green">Import</button>
            	</div>

            </div>

        	</form>
			
		</div>
	</div>

	<div class="box box-danger">
		<div class="box-header with-border">
			<div class="box-title">Instructions</div>
		</div>

		<div class="box-body">
			<p><b>Follow the instructions carefully before importing the file.</b></p>
			<p>The columns of the file should be in the following order.</p>

			<table class="table table-striped">
				<thead>
					<tr>
						<th>Column No</th>
						<th>Column Name</th>
						<th>Description</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td><b>Category</b> (Required)</td>
						<td>Name of category (must be created already by admin)</td>

						
					</tr>

					<tr>
						<td>2</td>
						<td><b>Subcategory</b> (Required)</td>
						<td>Name of subcategory (must be created already by admin)</td>
					</tr>

					<tr>
						<td>3</td>
						<td><b>Childcategory</b> (Optional)</td>
						<td>Name of childcategory (must be created already by admin)</td>
					</tr>

					<tr>
						<td>4</td>
						<td><b>Store Name</b> (Required)</td>
						<td>Name of your store </td>
					</tr>

					<tr>
						<td>5</td>
						<td><b>Brand Name</b> (Required)</td>
						<td>Name of your brand (must be created already by admin)</td>
					</tr>

					<tr>
						<td>6</td>
						<td><b>Product Name</b> (Required)</td>
						<td>Name of your product</td>
					</tr>

					<tr>
						<td>7</td>
						<td><b>Product Description</b> (Optional)</td>
						<td>Detail of your product</td>
					</tr>

					<tr>
						<td>8</td>
						<td><b>Model</b> (Optional)</td>
						<td>Model No. of your product</td>
					</tr>

					<tr>
						<td>9</td>
						<td><b>SKU</b> (Optional)</td>
						<td>Detail of your product</td>
					</tr>

					<tr>
						<td>10</td>
						<td><b>Price In</b> (Required)</td>
						<td>Your Product price in currency (eg. INR,USD) </td>
					</tr>

					<tr>
						<td>11</td>
						<td><b>Price</b> (Required)</td>
						<td>Your Product price (No string or comma in price)</td>
					</tr>

					<tr>
						<td>12</td>
						<td><b>Offer Price</b> [<b>Note:</b> Leave blank if you dont want offer price.]</td>
						<td>Your Product offer price (No string or comma in price)</td>
					</tr>

					<tr>
						<td>13</td>
						<td><b>Featured</b> (Optional)</td>
						<td><p>Enable or disable product is featured or not.</p>
						<p>(Yes = 1, No = 0)</p>
						</td>
					</tr>

					<tr>
						<td>14</td>
						<td><b>Status</b> (Required)</td>
						<td><p>Enable or disable product is active or not.</p>
						<p>(Yes = 1, No = 0)</p>
						</td>
					</tr>

					<tr>
						<td>15</td>
						<td><b>Tax</b> (Required if your price is exclusive of tax)</td>
						<td><p>Enable tax class name (must be already created by admin) in tax classes section or else enter <b>0</b>.</p>
						</td>
					</tr>

					<tr>
						<td>16</td>
						<td><b>Cash on delivery</b> (Required)</td>
						<td><p>Enable cash on delivery on your product.</p>
						   <p>(Yes = 1, No = 0)</p>
						</td>
					</tr>

					<tr>
						<td>17</td>
						<td><b>Free Shipping</b> (Required)</td>
						<td><p>Enable free shipping on your product.</p>
						   <p>(Yes = 1, No = 0)</p>
						</td>
					</tr>

					<tr>
						<td>18</td>
						<td><b>Return Available</b> (Required)</td>
						<td><p>Enable Return available on your product.</p>
						   <p>(Yes = 1, No = 0)</p>
						</td>
					</tr>

					<tr>
						<td>19</td>
						<td><b>Cancel Available</b> (Required)</td>
						<td><p>Enable Cancel available on your product.</p>
						   <p>(Yes = 1, No = 0)</p>
						</td>
					</tr>

					<tr>
						<td>20</td>
						<td><b>Selling Start at</b> (Optional)</td>
						<td><p>Enable if you want to start selling your product from specific date.</p>
						   <p><b>(Date Format : 2019-11-12 00:00:00)</b></p>
						</td>
					</tr>

					<tr>
						<td>21</td>
						<td><b>Warranty In (Period)</b> (Optional)</td>
						<td><p>Enter if your product have warranty else enter <b>None</b>.</p>
						   <p><b>(eg. 1)</b></p>
						</td>
					</tr>

					<tr>
						<td>22</td>
						<td><b>Warranty in (months,year,days)</b> (Optional)</td>
						<td><p>Enable if your product have warranty else enter <b>None</b>.</p>
						   <p><b>(Available format: days,year,months)</b></p>
						</td>
					</tr>

					<tr>
						<td>23</td>
						<td><b>Warranty type</b> (Optional)</td>
						<td><p>Enable if your product have warranty else enter <b>None</b>.</p>
						   <p><b>(Available types: Gurrantey, Warrantey)</b></p>
						</td>
					</tr>

					

					<tr>
						<td>24</td>
						<td><b>Return Policy</b> (Required if)</td>
						<td>If you set return available = 1, than enter return policy name.</td>
					</tr>

					<tr>
						<td>25</td>
						<td><b>Tax Rate</b> (Required if)</td>
						<td>If you set tax = 0 and your price is inclusive of tax , than enter Tax rate
							<p><b>eg.(18,25)</b> without % sign.</p></td>
					</tr>

					<tr>
						<td>26</td>
						<td><b>Tax name</b> (Required if)</td>
						<td>If you set tax = 0 and your price is inclusive of tax than enter your tax name.</td>
					</tr>

					<tr>
						<td>27</td>
						<td><b>Tags</b> (Optional)</td>
						<td>Enter product tags by putting comma to seprate tags.</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
@endsection